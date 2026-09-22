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
├── compose.dev.yaml
├── compose.prod.yaml
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

## 3. Setup `compose.dev.yaml`

Four spastic docker images

---

## 4. Start up `bootstrap.sh`

Make it executable:

```bash
chmod +x bootstrap.sh
```

---

First run:

```bash
# Trigger ./bootstrap.sh see (make help) for more information
make up
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
docker compose -f compose.dev.yaml down
docker compose -f compose.dev.yaml up -d
```

```bash
ls -la web/sites/default/settings.php
```

That file must exist on the host with non-zero size. If it's missing, the
installer never wrote it, which means `web/sites/default/` isn't writable
from inside the container. Run:

```bash
docker compose -f compose.dev.yaml exec -u root drupal \
  chown -R www-data:www-data /opt/drupal/web/sites/default
```

and reinstall from the browser once.

---

## Daily commands

```bash
make help

# Bring the stack up (safe to run every time)
./bootstrap.sh

# Drush
docker compose -f compose.dev.yaml exec drupal vendor/bin/drush status
docker compose -f compose.dev.yaml exec drupal vendor/bin/drush cr
docker compose -f compose.dev.yaml exec drupal vendor/bin/drush uli     # one-time login link

# Composer inside the container, then sync manifests back to the host
docker compose -f compose.dev.yaml exec drupal composer require drupal/admin_toolbar
docker compose -f compose.dev.yaml cp drupal:/opt/drupal/composer.json ./composer.json
docker compose -f compose.dev.yaml cp drupal:/opt/drupal/composer.lock ./composer.lock

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
docker compose -f compose.dev.yaml up -d
```

### `sites/default/files is not writable`
Either run `drupal-init` (in the compose) or fix manually:

```bash
docker compose -f compose.dev.yaml exec -u root drupal \
  chown -R www-data:www-data /opt/drupal/web/sites/default/files
docker compose -f compose.dev.yaml exec -u root drupal \
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
docker compose -f compose.dev.yaml logs db
```

If the volume was half-initialized by an earlier bad run:

```bash
docker compose -f compose.dev.yaml down
docker volume rm drupal_mysql
./bootstrap.sh
```

### If you want to blow it all away and start fresh

```bash
docker compose -f compose.dev.yaml down -v
docker volume rm drupal_mysql 2>/dev/null || true
$ rm -rf web vendor config/sync composer.json composer.lock # Be careful 
./bootstrap.sh
```

Then reinstall from the browser at <http://localhost:8080>.
