<?php
/**
 * PHP Entwicklungsumgebung - Testseite
 * 
 * Diese Datei zeigt alle wichtigen Informationen zur Installation an.
 * Nach dem Test sollte diese Datei gelöscht werden!
 */

// Fehleranzeige aktivieren
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 8.4 Dev Environment</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        .container { max-width: 900px; margin: 0 auto; }
        h1 { 
            color: white; 
            text-align: center; 
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .card {
            background: rgba(255,255,255,0.95);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .card h2 {
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        .status { display: flex; align-items: center; padding: 0.5rem 0; }
        .status-ok { color: #10b981; }
        .status-error { color: #ef4444; }
        .icon { font-size: 1.2rem; margin-right: 0.5rem; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 0.5rem; border-bottom: 1px solid #e5e7eb; }
        td:first-child { font-weight: 600; color: #374151; width: 40%; }
        code { 
            background: #f3f4f6; 
            padding: 0.2rem 0.5rem; 
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐘 PHP 8.4 Entwicklungsumgebung</h1>

        <!-- PHP Version -->
        <div class="card">
            <h2>PHP Information</h2>
            <table>
                <tr>
                    <td>PHP Version</td>
                    <td><code><?= PHP_VERSION ?></code></td>
                </tr>
                <tr>
                    <td>Zend Engine</td>
                    <td><code><?= zend_version() ?></code></td>
                </tr>
                <tr>
                    <td>Server API</td>
                    <td><code><?= php_sapi_name() ?></code></td>
                </tr>
                <tr>
                    <td>Zeitzone</td>
                    <td><code><?= date_default_timezone_get() ?></code></td>
                </tr>
                <tr>
                    <td>Memory Limit</td>
                    <td><code><?= ini_get('memory_limit') ?></code></td>
                </tr>
                <tr>
                    <td>Upload Max</td>
                    <td><code><?= ini_get('upload_max_filesize') ?></code></td>
                </tr>
            </table>
        </div>

        <!-- Erweiterungen -->
        <div class="card">
            <h2>PHP Erweiterungen</h2>
            <?php
            $required_extensions = [
                'pdo_mysql' => 'PDO MySQL',
                'mysqli' => 'MySQLi',
                'gd' => 'GD (Bildverarbeitung)',
                'zip' => 'ZIP',
                'mbstring' => 'Multibyte String',
                'xml' => 'XML',
                'curl' => 'cURL',
                'intl' => 'Internationalisierung',
                'opcache' => 'OPcache',
                'xdebug' => 'Xdebug',
            ];
            foreach ($required_extensions as $ext => $name): 
                $loaded = extension_loaded($ext);
            ?>
            <div class="status <?= $loaded ? 'status-ok' : 'status-error' ?>">
                <span class="icon"><?= $loaded ? '✅' : '❌' ?></span>
                <?= $name ?> (<?= $ext ?>)
                <?php if ($ext === 'xdebug' && $loaded): ?>
                    - Version <?= phpversion('xdebug') ?>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Xdebug Details -->
        <?php if (extension_loaded('xdebug')): ?>
        <div class="card">
            <h2>Xdebug Konfiguration</h2>
            <table>
                <tr>
                    <td>Mode</td>
                    <td><code><?= ini_get('xdebug.mode') ?></code></td>
                </tr>
                <tr>
                    <td>Client Host</td>
                    <td><code><?= ini_get('xdebug.client_host') ?></code></td>
                </tr>
                <tr>
                    <td>Client Port</td>
                    <td><code><?= ini_get('xdebug.client_port') ?></code></td>
                </tr>
                <tr>
                    <td>IDE Key</td>
                    <td><code><?= ini_get('xdebug.idekey') ?></code></td>
                </tr>
                <tr>
                    <td>Start with Request</td>
                    <td><code><?= ini_get('xdebug.start_with_request') ?></code></td>
                </tr>
            </table>
        </div>
        <?php endif; ?>

        <!-- Datenbank -->
        <div class="card">
            <h2>MariaDB Verbindung</h2>
            <?php
            $db_host = 'db';
            $db_user = 'dev';
            $db_pass = 'dev';
            $db_name = 'app';
            
            try {
                $pdo = new PDO(
                    "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
                    $db_user,
                    $db_pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                $version = $pdo->query('SELECT VERSION()')->fetchColumn();
                ?>
                <div class="status status-ok">
                    <span class="icon">✅</span>
                    Verbindung erfolgreich!
                </div>
                <table style="margin-top: 1rem;">
                    <tr>
                        <td>Server Version</td>
                        <td><code><?= $version ?></code></td>
                    </tr>
                    <tr>
                        <td>Host</td>
                        <td><code><?= $db_host ?></code></td>
                    </tr>
                    <tr>
                        <td>Datenbank</td>
                        <td><code><?= $db_name ?></code></td>
                    </tr>
                    <tr>
                        <td>Benutzer</td>
                        <td><code><?= $db_user ?></code></td>
                    </tr>
                </table>
                <?php
            } catch (PDOException $e) {
                ?>
                <div class="status status-error">
                    <span class="icon">❌</span>
                    Verbindung fehlgeschlagen: <?= htmlspecialchars($e->getMessage()) ?>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- Composer -->
        <div class="card">
            <h2>Composer</h2>
            <?php
            $composer_version = shell_exec('composer --version 2>/dev/null');
            if ($composer_version):
            ?>
            <div class="status status-ok">
                <span class="icon">✅</span>
                <?= htmlspecialchars(trim($composer_version)) ?>
            </div>
            <p style="margin-top: 1rem; color: #6b7280;">
                Nutzung: <code>docker compose exec php composer install</code>
            </p>
            <?php else: ?>
            <div class="status status-error">
                <span class="icon">❌</span>
                Composer nicht gefunden
            </div>
            <?php endif; ?>
        </div>

        <!-- Wichtige Pfade -->
        <div class="card">
            <h2>Wichtige Informationen</h2>
            <table>
                <tr>
                    <td>Document Root</td>
                    <td><code>/httpdocs/</code></td>
                </tr>
                <tr>
                    <td>PHP-FPM/Apache</td>
                    <td><code>http://localhost:8080</code></td>
                </tr>
                <tr>
                    <td>phpMyAdmin</td>
                    <td><code>http://localhost:8081</code></td>
                </tr>
                <tr>
                    <td>MariaDB (extern)</td>
                    <td><code>localhost:3306</code></td>
                </tr>
                <tr>
                    <td>MariaDB (intern)</td>
                    <td><code>db:3306</code></td>
                </tr>
            </table>
            
            <div class="warning">
                ⚠️ <strong>Sicherheitshinweis:</strong> 
                Diese Testdatei nach der Überprüfung löschen!
            </div>
        </div>

        <!-- phpinfo() Link -->
        <div class="card">
            <h2>Vollständige PHP-Info</h2>
            <p>
                <a href="?phpinfo=1" style="color: #667eea; text-decoration: none;">
                    📋 phpinfo() anzeigen
                </a>
            </p>
        </div>
    </div>

    <?php if (isset($_GET['phpinfo'])): ?>
    <div class="container">
        <div class="card" style="overflow-x: auto;">
            <?php phpinfo(); ?>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
