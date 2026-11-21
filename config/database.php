<?php
/**
 * Girna Global - Database Configuration
 * Hostinger / Shared Hosting Compatible PDO Driver setup
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'girna_global_db');
define('DB_CHARSET', 'utf8mb4');

/**
 * Returns a singleton PDO Connection object
 */
function getDBConnection() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Graceful fallback display if database is not yet created
            error_log("Database Connection Error: " . $e->getMessage());
            $pdo = null;
        }
    }
    return $pdo;
}
