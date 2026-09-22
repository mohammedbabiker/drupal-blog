# Local Drupal 11 Dev Environment — Docker Compose

A complete, reproducible setup for Drupal 11 on a clean machine.
Everything lives in the project folder on the host — `web/`, `vendor/`,
`config/sync/`, `composer.json` — no named volumes for code, only for the
database.

---

## What you get

- Drupal 11 served at `http://localhost:8080`
- phpMyAdmin at `http://localhost:8081`
- MySQL 9 on a private network
- All Drupal code, settings, uploads, and composer manifests persisted on
  the host under `./web/`, `./vendor/`, etc.
- A `bootstrap.sh` that seeds the project on first run and is safe to re-run.

---

## Prerequisites

You need:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)

You do **not** need PHP, Composer, MySQL, or Drupal installed on the host.
Everything runs inside containers.

---

## 1. Create the project folder

```bash
mkdir -p ~/dev/drupal-local
cd ~/dev/drupal-local
```

The final layout will look like this:

```
drupal-local/
├── .env
├── docker-compose.yml
├── bootstrap.sh
├── composer.json            ← seeded from the image on first run
├── composer.lock            ← seeded from the image on first run
├── config/
│   └── sync/                ← Drupal config sync directory
├── vendor/                  ← seeded from the image on first run
└── web/                     ← Drupal webroot, seeded from the image
    ├── core/
    ├── modules/
    ├── themes/
    ├── sites/
    │   └── default/
    │       ├── settings.php     ← created by the installer, persists here
    │       └── files/           ← uploads, persists here
    └── index.php
```

---

## 2. Create `.env`

```env
MYSQL_ROOT_PASSWORD=
MYSQL_DATABASE=
MYSQL_USER=
MYSQL_PASSWORD=
DRUPAL_PORT=8080
PHPMYADMIN_PORT=8081
```

Change the passwords if you like; they only matter locally.

---

## 3. Create `docker-compose.yml`

Create `docker-compose.yml` in the project root:

```yaml
services:
  db:
    image: mysql:9
    container_name: drupal_mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
      MYSQL_DATABASE: ${MYSQL_DATABASE}
      MYSQL_USER: ${MYSQL_USER}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD}
    volumes:
      - drupal_mysql:/var/lib/mysql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "127.0.0.1", "-p${MYSQL_ROOT_PASSWORD}"]
      interval: 5s
      timeout: 5s
      retries: 20
      start_period: 30s
    networks:
      - drupal

  phpmyadmin:
    image: phpmyadmin:5
    container_name: drupal_pma
    restart: unless-stopped
    depends_on:
      db:
        condition: service_healthy
    environment:
      PMA_HOST: db
      UPLOAD_LIMIT: 256M
    ports:
      - "${PHPMYADMIN_PORT:-8081}:80"
    networks:
      - drupal

  # One-shot container that fixes filesystem permissions on every `up`.
  drupal-init:
    image: drupal:11
    container_name: drupal_init
    user: root
    entrypoint: ["/bin/sh", "-c"]
    command:
      - |
        set -e
        mkdir -p /opt/drupal/web/sites/default/files
        chown -R www-data:www-data /opt/drupal/web/sites/default
        chmod -R 775 /opt/drupal/web/sites/default/files
        echo "drupal-init: files dir ready"
    volumes:
      - ./web:/opt/drupal/web
    networks:
      - drupal
    restart: "no"

  drupal:
    image: drupal:11
    container_name: drupal_web
    restart: unless-stopped
    depends_on:
      db:
        condition: service_healthy
      drupal-init:
        condition: service_completed_successfully
    ports:
      - "${DRUPAL_PORT:-8080}:80"
    volumes:
      - ./web:/opt/drupal/web
      - ./vendor:/opt/drupal/vendor
      - ./config/sync:/opt/drupal/config/sync
      - type: bind
        source: ./composer.json
        target: /opt/drupal/composer.json
        bind:
          create_host_path: false
      - type: bind
        source: ./composer.lock
        target: /opt/drupal/composer.lock
        bind:
          create_host_path: false
    networks:
      - drupal

networks:
  drupal:
    name: drupal_local
    driver: bridge

volumes:
  drupal_mysql:
    name: drupal_mysql
```

Notes on choices:

- **`drupal-init` service** — chowns `sites/default` inside the container
  on every `up`, so the installer's "not writable" error can't happen.

---

## 4. Create `bootstrap.sh`

Create `bootstrap.sh` in the project root. It seeds `web/`, `vendor/`,
`composer.json`, and `composer.lock` from the image on first run, then
starts the stack.

```bash
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
  die ".env not found. Create it first (see INSTALL.md step 2)."
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
log "docker compose up -d"
$COMPOSE up -d

# ---------- 6. wait for db to be healthy ----------
log "waiting for db to be healthy…"
for _ in $(seq 1 60); do
  health="$($COMPOSE ps --format json db 2>/dev/null \
    | sed -n 's/.*"Health":"\([^"]*\)".*/\1/p' || true)"
  [ "$health" = "healthy" ] && break
  sleep 1
done
[ "${health:-}" = "healthy" ] || warn "db did not reach healthy state in time"
log "db: ${health:-unknown}"

# ---------- 7. wait for drupal-init to exit ----------
log "waiting for drupal-init…"
for _ in $(seq 1 30); do
  state="$($COMPOSE ps -a --format json drupal-init 2>/dev/null \
    | sed -n 's/.*"State":"\([^"]*\)".*/\1/p' || true)"
  [ "$state" = "exited" ] && break
  sleep 1
done
code="$($COMPOSE ps -a --format json drupal-init 2>/dev/null \
  | sed -n 's/.*"ExitCode":\([0-9]*\).*/\1/p' || true)"
[ "${code:-1}" = "0" ] || warn "drupal-init exit code ${code:-unknown} — check: $COMPOSE logs drupal-init"
log "drupal-init: done (exit ${code:-?})"

# ---------- 8. summary ----------
echo
log "ready:"
echo "  Drupal      → http://localhost:${DRUPAL_PORT:-8080}"
echo "  phpMyAdmin  → http://localhost:${PHPMYADMIN_PORT:-8081}"
echo
echo "  logs:   $COMPOSE logs -f"
echo "  shell:  $COMPOSE exec drupal bash"
echo "  drush:  $COMPOSE exec drupal vendor/bin/drush"
```

Make it executable:

```bash
chmod +x bootstrap.sh
```

---

## 5. First run

```bash
./bootstrap.sh
```

What happens, in order:

1. Sanity checks Docker and `.env`.
2. Pulls the `drupal:11`, `mysql:9`, and `phpmyadmin:5` images (first run only).
3. Seeds `composer.json` and `composer.lock` from the image.
4. Seeds `web/` and `vendor/` on the host (once — subsequent runs skip this).
5. Creates `config/sync/` and `web/sites/default/files/`.
6. Starts MySQL, phpMyAdmin, the one-shot `drupal-init`, and Drupal.
7. Waits for MySQL to be healthy and for `drupal-init` to finish.

Expected output ends with something like:

```
[bootstrap] ready:
  Drupal      → http://localhost:8080
  phpMyAdmin  → http://localhost:8081
```

If `drupal-init` failed, check `docker compose logs drupal-init`.

---

## 6. Install Drupal in the browser

1. Open <http://localhost:8080>.
2. Choose a language → **Save and continue**.
3. Choose **Standard** profile → **Save and continue**.
4. On the "Set up database" screen, enter:
   - **Database name**: `example`
   - **Database username**: `examlple`
   - **Database password**: `example`
   - Expand **Advanced options** and set:
     - **Host**: `db`
     - **Port**: `3306`
   - Leave **Table prefix** empty.
5. **Save and continue** — Drupal will create the schema.
6. Fill in site name, admin user, password, email. Use a real-looking email
   (e.g. `admin@example.com`) — Drupal validates the format.
7. Finish the installer.
8. You should land on the Drupal front page.

Optional but recommended: set the sync directory to match the mount:

- Visit `admin/config/development/configuration`
- Or add to `web/sites/default/settings.php`:
  ```php
  $settings['config_sync_directory'] = '../config/sync';
  ```
  (Path is relative to the Drupal root, so `../config/sync`.)

---

## 7. Verify persistence (the important step)

```bash
docker compose down
docker compose up -d
```

```bash
ls -la web/sites/default/settings.php
```

That file must exist on the host with non-zero size. If it's missing, the
installer never wrote it, which means `web/sites/default/` isn't writable
from inside the container. Run:

```bash
docker compose exec -u root drupal \
  chown -R www-data:www-data /opt/drupal/web/sites/default
```

and reinstall from the browser once.

---

## Daily commands

```bash
# Bring the stack up (safe to run every time)
./bootstrap.sh

# Stop and remove containers (keeps ./web, ./vendor, ./composer.*, DB volume)
docker compose down

# Destroy everything including the database volume (full reset)
docker compose down -v
rm -rf web vendor composer.json composer.lock config/sync
./bootstrap.sh
# → reinstall via browser

# Logs
docker compose logs -f
docker compose logs -f drupal

# Shell inside Drupal
docker compose exec drupal bash

# Drush
docker compose exec drupal vendor/bin/drush status
docker compose exec drupal vendor/bin/drush cr
docker compose exec drupal vendor/bin/drush uli     # one-time login link

# Composer inside the container, then sync manifests back to the host
docker compose exec drupal composer require drupal/admin_toolbar
docker compose cp drupal:/opt/drupal/composer.json ./composer.json
docker compose cp drupal:/opt/drupal/composer.lock ./composer.lock

# phpMyAdmin
open http://localhost:8081
#   Server: db
#   User:   user
#   Pass:   pass
```

---

## Troubleshooting

### `error mounting .../composer.json: not a directory`
Docker created `composer.json` as a *directory* because the file was missing
on the host at `up` time. `bootstrap.sh` removes the bad dir and reseeds the
file. You can also fix manually:

```bash
rm -rf composer.json composer.lock
docker run --rm drupal:11 cat /opt/drupal/composer.json > composer.json
docker run --rm drupal:11 cat /opt/drupal/composer.lock > composer.lock
docker compose up -d
```

### `sites/default/files is not writable`
Either run `drupal-init` (in the compose) or fix manually:

```bash
docker compose exec -u root drupal \
  chown -R www-data:www-data /opt/drupal/web/sites/default/files
docker compose exec -u root drupal \
  chmod -R 775 /opt/drupal/web/sites/default/files
```

### Installer shows up every time after `down` / `up`
Root cause: `settings.php` was inside the container, not on the host. The
compose above bind-mounts `./web:/opt/drupal/web`, which keeps
`web/sites/default/settings.php` on the host. Verify it exists:

```bash
ls -la web/sites/default/settings.php
```

If it does not exist after install, run the chown from the previous section
and reinstall once.

### Port 8080 or 8081 is already in use
Change `DRUPAL_PORT` / `PHPMYADMIN_PORT` in `.env` and re-run `./bootstrap.sh`.

### `db` never becomes healthy
Check its logs:

```bash
docker compose logs db
```

If the volume was half-initialized by an earlier bad run:

```bash
docker compose down
docker volume rm drupal_mysql
./bootstrap.sh
```

### If you want to blow it all away and start fresh

```bash
docker compose down -v
docker volume rm drupal_mysql 2>/dev/null || true
$ rm -rf web vendor config/sync composer.json composer.lock # Be careful 
./bootstrap.sh
```

Then reinstall from the browser at <http://localhost:8080>.
