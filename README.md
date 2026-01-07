# PHP 8.4 Entwicklungsumgebung

Docker-basierte Entwicklungsumgebung für PHP 8.4 auf macOS M4.

## 🚀 Schnellstart

```bash
# Container starten
docker compose up -d

# Fertig! Öffne im Browser:
# http://localhost:8080
```

## 📦 Enthaltene Dienste

| Dienst | Port | Beschreibung |
|--------|------|--------------|
| **Apache/PHP** | 8080 | Webserver mit PHP 8.4 |
| **phpMyAdmin** | 8081 | Datenbank-Verwaltung |
| **MariaDB** | 3306 | Datenbank-Server |

## 🔧 Datenbank-Zugangsdaten

| Eigenschaft | Wert |
|-------------|------|
| Host (intern) | `db` |
| Host (extern) | `localhost` |
| Port | `3306` |
| Datenbank | `app` |
| Benutzer | `dev` |
| Passwort | `dev` |
| Root-Passwort | `root` |

## 🐛 Xdebug Konfiguration

Xdebug ist vorkonfiguriert und startet automatisch bei jedem Request.

### PHPStorm
1. **Run → Edit Configurations → + → PHP Remote Debug**
2. Server: `localhost:8080`
3. IDE Key: `PHPSTORM`
4. Path Mapping: `/` → `/httpdocs`

### VS Code
`.vscode/launch.json`:
```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/httpdocs": "${workspaceFolder}"
      }
    }
  ]
}
```

## 📂 Verzeichnisstruktur

```
./                      # Dein Projektordner (IDE)
├── docker-compose.yml  # Docker Konfiguration
├── Dockerfile          # PHP/Apache Build
├── config/
│   ├── php.ini         # PHP Einstellungen
│   └── apache-vhost.conf
├── sql/                # Initiale SQL-Skripte
│   └── 01_init.sql
├── vendor/             # Composer Pakete
└── index.php           # Deine PHP-Dateien
```

Im Container ist alles unter `/httpdocs/` gemountet.

## 🛠️ Nützliche Befehle

```bash
# Container starten
docker compose up -d

# Container stoppen
docker compose down

# Logs anzeigen
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
docker compose up -d --build

# Alles löschen (inkl. Datenbank!)
docker compose down -v
```

## 🔄 PHP-Erweiterungen

Vorinstalliert:
- pdo_mysql, mysqli
- gd (mit JPEG, PNG, WebP, FreeType)
- zip, curl, xml, mbstring
- intl, opcache, bcmath
- xdebug

Weitere hinzufügen im `Dockerfile`:
```dockerfile
RUN docker-php-ext-install <erweiterung>
# oder für PECL:
RUN pecl install <paket> && docker-php-ext-enable <paket>
```

## ⚠️ Hinweise

- **Nur für Entwicklung!** Nicht für Produktion geeignet.
- Die `index.php` Testdatei nach Überprüfung löschen.
- Datenbank-Daten bleiben in einem Docker Volume erhalten.
- Bei `docker compose down -v` wird die Datenbank gelöscht!
