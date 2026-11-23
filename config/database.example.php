<?php
/**
 * Copy this file to database.php and enter your InfinityFree credentials.
 * Do not commit database.php or share its password publicly.
 */

define('DB_HOST', 'YOUR_MYSQL_HOSTNAME');
define('DB_NAME', 'YOUR_FULL_DATABASE_NAME');
define('DB_USER', 'YOUR_MYSQL_USERNAME');
define('DB_PASS', 'YOUR_MYSQL_PASSWORD');

/**
 * Use a long, random secret string. Keep it private.
 * It is used to create voter hashes without storing raw IP addresses.
 */
define('VOTING_SECRET', 'REPLACE_WITH_A_LONG_RANDOM_SECRET');

function getDatabaseConnection(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}
