# PHP 8.4 Entwicklungsumgebung

Docker-basierte Entwicklungsumgebung für PHP 8.4 auf macOS M4.

## 🚀 Schnellstart

```bash
docker compose up -d
```

Fertig! Öffne im Browser: **http://localhost:8080**

## 📂 Projektstruktur

```
projekt/
├── .docker/                    ← Docker-Konfiguration
│   ├── config/
│   │   ├── php.ini             ← PHP-Einstellungen
│   │   └── apache-vhost.conf   ← Apache Virtual Host
│   ├── sql/
│   │   └── 01_init.sql         ← Initiale DB-Skripte
│   └── Dockerfile              ← PHP/Apache Image
├── .vscode/
│   └── launch.json             ← Xdebug Konfiguration
├── docker-compose.yml          ← Container-Orchestrierung
├── .gitignore
├── index.php                   ← Testseite (später löschen)
└── [dein PHP-Code]             ← Hier entwickeln!
```

## 📦 Enthaltene Dienste

| Dienst | URL | Beschreibung |
|--------|-----|--------------|
| **PHP/Apache** | http://localhost:8080 | Webserver mit PHP 8.4 |
| **phpMyAdmin** | http://localhost:8081 | Datenbank-Verwaltung |
| **MariaDB** | localhost:3306 | Datenbank-Server |

## 🔧 Datenbank-Zugangsdaten

| Eigenschaft | Wert |
|-------------|------|
| Host (im PHP-Code) | `db` |
| Host (extern/IDE) | `localhost` |
| Port | `3306` |
| Datenbank | `app` |
| Benutzer | `dev` |
| Passwort | `dev` |
| Root-Passwort | `root` |

### PHP-Verbindung

```php
$pdo = new PDO(
    'mysql:host=db;dbname=app;charset=utf8mb4',
    'dev',
    'dev'
);
```

## 🐛 Xdebug

Xdebug startet automatisch bei jedem Request – kein Browser-Plugin nötig.

### VS Code
1. PHP Debug Extension installieren
2. `.vscode/launch.json` ist bereits konfiguriert
3. **Run → Start Debugging** (F5)
4. Breakpoint setzen, Seite aufrufen

### PHPStorm
1. **Run → Edit Configurations → + → PHP Remote Debug**
2. Server erstellen: `localhost:8080`
3. IDE Key: `PHPSTORM`
4. Path Mapping: `/` → `/httpdocs`

## 🛠️ Nützliche Befehle

```bash
# Container starten
docker compose up -d

# Container stoppen
docker compose down

# Logs anzeigen (live)
docker compose logs -f

# PHP Shell öffnen
docker compose exec php bash

# Composer installieren
docker compose exec php composer install

# Composer Paket hinzufügen
docker compose exec php composer require monolog/monolog

# MariaDB Shell
docker compose exec db mariadb -u dev -pdev app

# Container neu bauen (nach Dockerfile-Änderung)
docker compose build --no-cache
docker compose up -d

# Alles löschen (inkl. Datenbank-Daten!)
docker compose down -v
```

## 🔄 PHP-Erweiterungen

Vorinstalliert:
- `pdo_mysql`, `mysqli` – Datenbank
- `gd` – Bildverarbeitung (JPEG, PNG, WebP, FreeType)
- `zip`, `curl`, `xml`, `mbstring`
- `intl` – Internationalisierung
- `opcache` – Performance
- `bcmath` – Präzise Berechnungen
- `xdebug` – Debugging

### Weitere Erweiterungen hinzufügen

In `.docker/Dockerfile` ergänzen:

```dockerfile
# Standard-Erweiterung
RUN docker-php-ext-install <name>

# PECL-Erweiterung
RUN pecl install <name> && docker-php-ext-enable <name>
```

Danach: `docker compose build --no-cache && docker compose up -d`

## 📝 Konfiguration anpassen

| Datei | Beschreibung |
|-------|--------------|
| `.docker/config/php.ini` | PHP-Einstellungen (Memory, Upload, Xdebug) |
| `.docker/config/apache-vhost.conf` | Apache Virtual Host |
| `.docker/sql/*.sql` | Initiale Datenbank-Skripte |
| `docker-compose.yml` | Ports, Volumes, Environment |

Nach Änderungen an `php.ini` oder `apache-vhost.conf`:
```bash
docker compose restart php
```

Nach Änderungen am `Dockerfile`:
```bash
docker compose build --no-cache && docker compose up -d
```

## ⚠️ Hinweise

- **Nur für Entwicklung!** Nicht für Produktion geeignet.
- Datenbank-Daten bleiben im Docker Volume `php-dev-db` erhalten.
- Bei `docker compose down -v` wird die Datenbank gelöscht!
- Die `index.php` Testseite nach Überprüfung löschen.
