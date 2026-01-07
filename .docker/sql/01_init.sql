-- =============================================================================
-- Initiales Datenbank-Setup
-- Diese Datei wird automatisch beim ersten Start von MariaDB ausgeführt
-- =============================================================================

-- Beispiel-Tabelle (kann gelöscht/angepasst werden)
CREATE TABLE IF NOT EXISTS beispiel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    aktualisiert_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Beispiel-Daten
INSERT INTO beispiel (name) VALUES 
    ('Erster Eintrag'),
    ('Zweiter Eintrag');

-- Hinweis: Weitere .sql Dateien in diesem Ordner werden alphabetisch ausgeführt
-- Beispiel: 02_users.sql, 03_products.sql, etc.
