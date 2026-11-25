<?php
declare(strict_types=1);

session_start();
if (empty($_SESSION['vote_csrf_token'])) {
    $_SESSION['vote_csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../config/database.php';

$pdo = getDatabaseConnection();

$categoryQuery = $pdo->prepare(
    'SELECT id, title, description, is_open FROM categories WHERE slug = :slug LIMIT 1'
);
$categoryQuery->execute(['slug' => 'best-collaboration']);
$category = $categoryQuery->fetch();

if (!$category) {
    http_response_code(404);
    exit('Category not found.');
}

$nomineeQuery = $pdo->prepare(
    'SELECT n.id, n.name, n.photo, COUNT(v.id) AS vote_count
     FROM nominees n
     LEFT JOIN votes v ON v.nominee_id = n.id AND v.category_id = n.category_id
     WHERE n.category_id = :category_id
     GROUP BY n.id, n.name, n.photo, n.display_order
     ORDER BY n.display_order ASC, n.name ASC'
);
$nomineeQuery->execute(['category_id' => $category['id']]);
$nominees = $nomineeQuery->fetchAll();

$totalVotes = 0;
foreach ($nominees as $nominee) {
    $totalVotes += (int) $nominee['vote_count'];
}

foreach ($nominees as &$nominee) {
    $nominee['vote_count'] = (int) $nominee['vote_count'];
    $nominee['vote_percentage'] = $totalVotes > 0
        ? ($nominee['vote_count'] / $totalVotes) * 100
        : 0;
}
unset($nominee);

function escapeOutput(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo escapeOutput($category['description']); ?>">
    <title><?php echo escapeOutput($category['title']); ?> | Live Show Awards</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --red: #c8102e;
            --gold: #d7ad45;
            --ink: #171717;
            --muted: #686868;
        }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: #fff; font-family: 'Poppins', sans-serif; }
        a { color: inherit; }
        .site-header {
            min-height: 76px; padding: 12px clamp(18px, 4vw, 46px);
            display: flex; align-items: center; justify-content: space-between;
            background: #fff; border-bottom: 1px solid #eee;
            position: sticky; top: 0; z-index: 1000;
        }
        .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-logo { width: 52px; height: 52px; object-fit: contain; display: block; }
        .brand-copy strong { display: block; color: var(--red); font-size: 13px; letter-spacing: 1px; text-transform: uppercase; }
        .brand-copy small, .brand-copy em { display: block; margin-top: 3px; color: #888; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; }
        .brand-copy em { color: #999; font-style: normal; letter-spacing: 0; text-transform: none; }
        .back-link { color: var(--red); font-size: 13px; font-weight: 700; text-decoration: none; }
        .category-heading {
            padding: 48px 18px 42px; color: #fff; text-align: center;
            background: linear-gradient(120deg, #171717, #7d1026 55%, var(--red));
        }
        .eyebrow { margin: 0 0 12px; color: #f2d58e; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; }
        .category-heading h1 { margin: 0 0 12px; font-size: clamp(32px, 6vw, 54px); line-height: 1.08; }
        .category-heading p { max-width: 620px; margin: 0 auto; color: rgba(255,255,255,.86); font-size: 14px; line-height: 1.65; }
        .voting-content { width: min(1120px, calc(100% - 36px)); margin: 0 auto; padding: 38px 0 55px; }
        .section-top { display: flex; align-items: end; justify-content: space-between; gap: 15px; margin-bottom: 22px; }
        .section-top h2 { margin: 0; font-size: 22px; }
        .nominee-count { color: var(--muted); font-size: 12px; white-space: nowrap; }
        .nominee-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .nominee-card { overflow: hidden; border: 1px solid #e8e8e8; background: #fff; }
        .nominee-photo { aspect-ratio: 1 / 1; display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, rgba(200,16,46,.09), transparent 55%), #ededed; }
        .nominee-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .nominee-initial { color: #a80d26; font-size: clamp(48px, 9vw, 76px); font-weight: 800; }
        .nominee-info { padding: 16px 12px; text-align: center; }
        .nominee-info h3 { margin: 0 0 13px; font-size: 15px; font-weight: 700; }
        .nominee-stats { margin: 0 0 14px; text-align: left; }
        .nominee-stats-top { display: flex; justify-content: space-between; gap: 8px; margin-bottom: 7px; color: var(--muted); font-size: 10px; }
        .nominee-stats-top strong { color: var(--ink); font-size: 11px; }
        .vote-progress { height: 6px; overflow: hidden; background: #ededed; }
        .vote-progress span { display: block; height: 100%; background: linear-gradient(90deg, var(--red), var(--gold)); }
        .vote-button { width: 100%; padding: 11px 12px; border: 0; color: #fff; background: var(--red); font-size: 12px; font-weight: 700; cursor: pointer; }
        .vote-button:disabled { background: #999; cursor: not-allowed; }
        .vote-message { margin: 0 0 22px; padding: 13px 16px; border-left: 4px solid var(--gold); background: #faf7ef; color: #5e5237; font-size: 13px; line-height: 1.6; }
        .empty-state { padding: 34px 20px; border: 1px solid #eee; color: var(--muted); text-align: center; font-size: 14px; }
        .site-footer { padding: 20px; color: #bbb; background: #171717; text-align: center; font-size: 11px; }
        @media (min-width: 650px) {
            .nominee-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
            .nominee-info { padding: 18px; }
        }
        @media (min-width: 950px) { .nominee-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
        @media (max-width: 430px) {
            .brand-logo { width: 43px; height: 43px; }
            .brand-copy strong { font-size: 11px; }
            .brand-copy small, .brand-copy em { font-size: 8px; }
            .back-link { font-size: 11px; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <a class="brand" href="../index.php" aria-label="Live Show Awards home">
            <img class="brand-logo" src="../assets/images/logo.png" alt="Live Show Awards logo">
            <span class="brand-copy">
                <strong>Live Show Awards</strong>
                <em>Celebrating Salima's finest talents</em>
            </span>
        </a>
        <a class="back-link" href="../categories/">&larr; Categories</a>
    </header>

    <main>
        <section class="category-heading">
            <p class="eyebrow">Live Show Awards</p>
            <h1><?php echo escapeOutput($category['title']); ?></h1>
            <p><?php echo escapeOutput($category['description']); ?></p>
        </section>

        <section class="voting-content">
            <?php
            $voteMessages = [
                'success' => 'Your vote has been recorded. Thank you for participating.',
                'duplicate' => 'A vote from this internet connection has already been recorded in this category.',
                'closed' => 'Voting for this category is not open yet.',
                'invalid' => 'We could not validate that vote. Please try again.',
                'unavailable' => 'We could not process your vote right now. Please try again later.',
            ];
            $voteStatus = $_GET['vote'] ?? '';
            if (is_string($voteStatus) && isset($voteMessages[$voteStatus])):
            ?>
                <div class="vote-message" role="status"><?php echo escapeOutput($voteMessages[$voteStatus]); ?></div>
            <?php endif; ?>

            <div class="section-top">
                <h2>Meet the Nominees</h2>
                <span class="nominee-count"><?php echo count($nominees); ?> Nominees</span>
            </div>

            <?php if ($nominees): ?>
                <div class="nominee-grid">
                    <?php foreach ($nominees as $nominee): ?>
                        <article class="nominee-card">
                            <div class="nominee-photo">
                                <?php if (!empty($nominee['photo'])): ?>
                                    <img src="../<?php echo escapeOutput($nominee['photo']); ?>" alt="<?php echo escapeOutput($nominee['name']); ?>">
                                <?php else: ?>
                                    <span class="nominee-initial" aria-hidden="true"><?php echo escapeOutput(strtoupper(substr($nominee['name'], 0, 1))); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="nominee-info">
                                <h3><?php echo escapeOutput($nominee['name']); ?></h3>
                                <div class="nominee-stats">
                                    <div class="nominee-stats-top">
                                        <strong><?php echo number_format($nominee['vote_count']); ?> votes</strong>
                                        <span><?php echo number_format($nominee['vote_percentage'], 1); ?>%</span>
                                    </div>
                                    <div class="vote-progress" role="progressbar"
                                         aria-label="<?php echo escapeOutput($nominee['name']); ?> vote share"
                                         aria-valuemin="0" aria-valuemax="100"
                                         aria-valuenow="<?php echo number_format($nominee['vote_percentage'], 1, '.', ''); ?>">
                                        <span style="width:<?php echo number_format($nominee['vote_percentage'], 2, '.', ''); ?>%"></span>
                                    </div>
                                </div>
                                <form method="post" action="../vote.php">
                                    <input type="hidden" name="csrf_token" value="<?php echo escapeOutput($_SESSION['vote_csrf_token']); ?>">
                                    <input type="hidden" name="category_slug" value="best-collaboration">
                                    <input type="hidden" name="nominee_id" value="<?php echo (int) $nominee['id']; ?>">
                                    <button class="vote-button" type="submit" <?php echo (int) $category['is_open'] === 1 ? '' : 'disabled'; ?>>
                                        <?php echo (int) $category['is_open'] === 1 ? 'VOTE FOR THIS NOMINEE' : 'VOTING NOT OPEN'; ?>
                                    </button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">Nominees will be announced here.</div>
            <?php endif; ?>
        </section>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
