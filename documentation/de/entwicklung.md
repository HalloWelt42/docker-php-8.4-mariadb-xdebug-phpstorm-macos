# Docker Merkblatt für PHP-Entwicklung

## Container starten & stoppen

```bash
# Starten (im Hintergrund)
docker compose up -d

# Stoppen
docker compose down

# Stoppen + Datenbank löschen (Neuanfang)
docker compose down -v

# Neustarten
docker compose restart

# Nur PHP-Container neustarten
docker compose restart php
```

## In den Container gehen

```bash
# Shell öffnen (als root)
docker compose exec php bash

# Einzeiler ausführen
docker compose exec php ls -la /httpdocs

# Als www-data User
docker compose exec -u www-data php bash
```

## Composer

```bash
# Install (composer.json vorhanden)
docker compose exec php composer install

# Paket hinzufügen
docker compose exec php composer require monolog/monolog

# Paket entfernen
docker compose exec php composer remove monolog/monolog

# Autoloader aktualisieren
docker compose exec php composer dump-autoload

# Pakete aktualisieren
docker compose exec php composer update
```

## Datenbank

```bash
# MariaDB Shell
docker compose exec db mariadb -u dev -pdev app

# SQL-Datei importieren
docker compose exec -T db mariadb -u dev -pdev app < dump.sql

# Datenbank exportieren
docker compose exec db mariadb-dump -u dev -pdev app > backup.sql

# Alle Tabellen anzeigen
docker compose exec db mariadb -u dev -pdev app -e "SHOW TABLES;"
```

## Logs & Debugging

```bash
# Alle Logs (live)
docker compose logs -f

# Nur PHP/Apache Logs
docker compose logs -f php

# Nur DB Logs
docker compose logs -f db

# Apache Error Log im Container
docker compose exec php tail -f /var/log/apache2/error.log

# PHP Error Log
docker compose exec php tail -f /var/log/php_errors.log
```

## Container-Status

```bash
# Laufende Container
docker compose ps

# Alle Container (auch gestoppte)
docker ps -a

# Ressourcenverbrauch
docker stats
```

## Neu bauen (nach Dockerfile-Änderung)

```bash
# Mit Cache
docker compose build
docker compose up -d

# Ohne Cache (sauberer Neuaufbau)
docker compose build --no-cache
docker compose up -d

# Alles in einem
docker compose up -d --build
```

## Aufräumen

```bash
# Gestoppte Container löschen
docker container prune

# Unbenutzte Images löschen
docker image prune

# Alles unbenutzte löschen (Vorsicht!)
docker system prune -a

# Speicherverbrauch anzeigen
docker system df
```

## Dateien kopieren

```bash
# Vom Container zum Host
docker compose cp php:/httpdocs/vendor ./vendor-backup

# Vom Host zum Container
docker compose cp ./meine-datei.php php:/httpdocs/
```

## Ports & Zugriff

| Dienst | URL / Port |
|--------|------------|
| Webserver | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| MariaDB | localhost:3306 |

## Datenbank-Verbindung (PHP)

```php
$pdo = new PDO(
    'mysql:host=db;dbname=app;charset=utf8mb4',
    'dev',
    'dev',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
```

## Datenbank-Verbindung (IDE / extern)

| Eigenschaft | Wert |
|-------------|------|
| Host | `localhost` oder `127.0.0.1` |
| Port | `3306` |
| Datenbank | `app` |
| User | `dev` |
| Passwort | `dev` |

## Typische Probleme

### Port belegt
```bash
# Wer benutzt Port 8080?
lsof -i :8080

# Anderen Port in docker-compose.yml setzen:
# ports:
#   - "8888:80"
```

### Container startet nicht
```bash
# Logs prüfen
docker compose logs php

# Container manuell starten für Fehlerausgabe
docker compose up php
```

### Datenbank-Verbindung schlägt fehl
```bash
# DB-Container läuft?
docker compose ps

# Warten bis DB bereit ist
docker compose logs db | grep "ready for connections"
```

### Änderungen werden nicht übernommen
```bash
# PHP-Dateien: Sofort sichtbar (Volume-Mount)

# php.ini geändert:
docker compose restart php

# Dockerfile geändert:
docker compose build --no-cache && docker compose up -d

# composer.json geändert:
docker compose exec php composer install
```

### Rechteprobleme
```bash
# Im Container als root
docker compose exec php chown -R www-data:www-data /httpdocs/storage

# Vom Host (macOS)
chmod -R 777 ./storage
```

## Xdebug

Läuft automatisch bei jedem Request. In der IDE:

1. **VS Code**: F5 → "Listen for Xdebug"
2. **PHPStorm**: Telefon-Icon aktivieren

Breakpoint setzen, Seite im Browser laden, fertig.

## Schnellreferenz

| Was | Befehl |
|-----|--------|
| Starten | `docker compose up -d` |
| Stoppen | `docker compose down` |
| Shell | `docker compose exec php bash` |
| Logs | `docker compose logs -f` |
| Composer | `docker compose exec php composer ...` |
| DB Shell | `docker compose exec db mariadb -u dev -pdev app` |
| Neubauen | `docker compose build --no-cache && docker compose up -d` |