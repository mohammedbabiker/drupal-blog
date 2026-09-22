#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")"

COMPOSE="docker compose"
IMAGE="drupal:11"

log()  { printf '\033[1;34m[bootstrap]\033[0m %s\n' "$*"; }
warn() { printf '\033[1;33m[bootstrap]\033[0m %s\n' "$*" >&2; }
die()  { printf '\033[1;31m[bootstrap]\033[0m %s\n' "$*" >&2; exit 1; }

# ---------- 1. sanity ----------
command -v docker >/dev/null || die "docker not found in PATH"
docker info >/dev/null 2>&1 || die "docker daemon not running — start Docker Desktop"

if [ ! -f .env ]; then
  die ".env not found. Create it first (see INSTALL.md step 3)."
fi

# ---------- 2. ensure composer files are real FILES ----------
ensure_composer_file() {
  local f="$1"
  if [ -d "$f" ]; then
    warn "$f exists as a directory (from a previous bad mount) — removing"
    rm -rf -- "$f"
  fi
  if [ ! -s "$f" ]; then
    log "seeding $f from $IMAGE:/opt/drupal/$f"
    docker run --rm --entrypoint cat "$IMAGE" "/opt/drupal/$f" > "$f"
  fi
  [ -s "$f" ] || die "failed to seed $f"
}
ensure_composer_file composer.json
ensure_composer_file composer.lock

# ---------- 3. seed ./web and ./vendor if empty ----------
seed_dir() {
  local host_dir="$1" container_dir="$2"
  if [ -z "$(ls -A "$host_dir" 2>/dev/null)" ]; then
    log "seeding $host_dir/ from $IMAGE:$container_dir"
    mkdir -p "$host_dir"
    docker run --rm \
      -v "$PWD/$host_dir:/out" \
      --entrypoint sh \
      "$IMAGE" \
      -c "cp -a $container_dir/. /out/ && chown -R 33:33 /out"
  fi
}
seed_dir web /opt/drupal/web
seed_dir vendor /opt/drupal/vendor

# ---------- 4. ensure sync dir + files dir ----------
mkdir -p config/sync
mkdir -p web/sites/default/files
log "config/sync and web/sites/default/files exist"

# ---------- 5. bring the stack up ----------
log "docker compose -f compose.dev.yaml up -d"
$COMPOSE -f compose.dev.yaml up -d

# ---------- 6. wait for db to be healthy ----------
log "waiting for db to be healthy…"
for _ in $(seq 1 60); do
  health="$($COMPOSE -f compose.dev.yaml ps --format json db 2>/dev/null \
    | sed -n 's/.*"Health":"\([^"]*\)".*/\1/p' || true)"
  [ "$health" = "healthy" ] && break
  sleep 1
done
[ "${health:-}" = "healthy" ] || warn "db did not reach healthy state in time"
log "db: ${health:-unknown}"

# ---------- 7. wait for drupal-init to exit ----------
log "waiting for drupal-init…"
for _ in $(seq 1 30); do
  state="$($COMPOSE -f compose.dev.yaml ps -a --format json drupal-init 2>/dev/null \
    | sed -n 's/.*"State":"\([^"]*\)".*/\1/p' || true)"
  [ "$state" = "exited" ] && break
  sleep 1
done
code="$($COMPOSE -f compose.dev.yaml ps -a --format json drupal-init 2>/dev/null \
  | sed -n 's/.*"ExitCode":\([0-9]*\).*/\1/p' || true)"
[ "${code:-1}" = "0" ] || warn "drupal-init exit code ${code:-unknown} — check: $COMPOSE -f compose.dev.yaml logs drupal-init"
log "drupal-init: done (exit ${code:-?})"

# ---------- 8. summary ----------
echo
log "ready:"
echo "  Drupal      → http://localhost:${DRUPAL_PORT:-8080}"
echo "  phpMyAdmin  → http://localhost:${PHPMYADMIN_PORT:-8081}"
echo
echo "  logs:   $COMPOSE -f compose.dev.yaml logs -f"
echo "  shell:  $COMPOSE -f compose.dev.yaml exec drupal bash"
echo "  drush:  $COMPOSE -f compsoe.dev.yaml exec drupal vendor/bin/drush"
