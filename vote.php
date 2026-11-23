<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/database.php';

function redirectToCategory(string $status, string $slug = 'artist-of-year'): never
{
    if (!preg_match('/^[a-z0-9-]{1,120}$/', $slug)) {
        $slug = 'artist-of-year';
    }
    header('Location: categories/' . $slug . '.php?vote=' . rawurlencode($status), true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method not allowed.');
}

$submittedToken = $_POST['csrf_token'] ?? '';
$sessionToken = $_SESSION['vote_csrf_token'] ?? '';

if (!is_string($submittedToken) || !is_string($sessionToken) || $sessionToken === '' || !hash_equals($sessionToken, $submittedToken)) {
    redirectToCategory('invalid');
}

$categorySlug = $_POST['category_slug'] ?? '';
$nomineeId = filter_input(INPUT_POST, 'nominee_id', FILTER_VALIDATE_INT);

if (!is_string($categorySlug) || !preg_match('/^[a-z0-9-]{1,120}$/', $categorySlug) || !$nomineeId || $nomineeId < 1) {
    redirectToCategory('invalid', $categorySlug);
}

$ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
if (!is_string($ipAddress) || $ipAddress === '') {
    redirectToCategory('unavailable', $categorySlug);
}

$voterHash = hash_hmac('sha256', $ipAddress, VOTING_SECRET);

try {
    $pdo = getDatabaseConnection();

    $categoryStatement = $pdo->prepare(
        'SELECT id, is_open FROM categories WHERE slug = :slug LIMIT 1'
    );
    $categoryStatement->execute(['slug' => $categorySlug]);
    $category = $categoryStatement->fetch();

    if (!$category) {
        redirectToCategory('invalid', $categorySlug);
    }

    if ((int) $category['is_open'] !== 1) {
        redirectToCategory('closed', $categorySlug);
    }

    $nomineeStatement = $pdo->prepare(
        'SELECT id FROM nominees WHERE id = :nominee_id AND category_id = :category_id LIMIT 1'
    );
    $nomineeStatement->execute([
        'nominee_id' => $nomineeId,
        'category_id' => $category['id'],
    ]);

    if (!$nomineeStatement->fetch()) {
        redirectToCategory('invalid', $categorySlug);
    }

    $insertVote = $pdo->prepare(
        'INSERT INTO votes (category_id, nominee_id, voter_hash) VALUES (:category_id, :nominee_id, :voter_hash)'
    );

    try {
        $insertVote->execute([
            'category_id' => $category['id'],
            'nominee_id' => $nomineeId,
            'voter_hash' => $voterHash,
        ]);
        redirectToCategory('success', $categorySlug);
    } catch (PDOException $error) {
        if ($error->getCode() === '23000') {
            redirectToCategory('duplicate', $categorySlug);
        }
        throw $error;
    }
} catch (Throwable $error) {
    error_log('Live Show Awards vote processing error: ' . $error->getMessage());
    redirectToCategory('unavailable', $categorySlug);
}
