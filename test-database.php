<?php
declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $pdo = getDatabaseConnection();
    $count = (int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();

    echo "Database connection successful.\n";
    echo "Categories found: " . $count . "\n";
} catch (Throwable $error) {
    http_response_code(500);
    error_log('Live Show Awards database test failed: ' . $error->getMessage());
    echo "Database connection failed. Check config/database.php and the hosting error log.\n";
}
