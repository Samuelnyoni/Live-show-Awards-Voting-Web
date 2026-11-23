<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$pdo = getDatabaseConnection();

$sql = "
    SELECT
        c.id AS category_id,
        c.title AS category_title,
        c.slug AS category_slug,
        c.is_open,
        n.id AS nominee_id,
        n.name AS nominee_name,
        n.photo AS nominee_photo,
        COUNT(v.id) AS vote_count
    FROM categories c
    LEFT JOIN nominees n ON n.category_id = c.id
    LEFT JOIN votes v ON v.nominee_id = n.id AND v.category_id = c.id
    GROUP BY c.id, c.title, c.slug, c.is_open, n.id, n.name, n.photo, n.display_order
    ORDER BY c.display_order ASC, n.display_order ASC, n.name ASC
";

$rows = $pdo->query($sql)->fetchAll();

$categories = [];
foreach ($rows as $row) {
    $categoryId = (int) $row['category_id'];

    if (!isset($categories[$categoryId])) {
        $categories[$categoryId] = [
            'title' => $row['category_title'],
            'slug' => $row['category_slug'],
            'is_open' => (int) $row['is_open'],
            'nominees' => [],
            'total_votes' => 0,
        ];
    }

    if ($row['nominee_id'] !== null) {
        $votes = (int) $row['vote_count'];
        $categories[$categoryId]['nominees'][] = [
            'name' => $row['nominee_name'],
            'photo' => $row['nominee_photo'],
            'votes' => $votes,
        ];
        $categories[$categoryId]['total_votes'] += $votes;
    }
}

function escapeResult(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View the latest public voting standings for Live Show Awards in Salima District.">
    <title>Live Results | Live Show Awards</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root{--red:#c8102e;--gold:#d7ad45;--ink:#171717;--muted:#686868;--soft:#f6f6f6}
        *{box-sizing:border-box}
        body{margin:0;color:var(--ink);background:#fff;font-family:'Poppins',sans-serif}
        a{color:inherit}
        .site-header{min-height:76px;padding:12px clamp(18px,4vw,46px);display:flex;align-items:center;justify-content:space-between;gap:14px;background:#fff;border-bottom:1px solid #eee;position:sticky;top:0;z-index:1000}
        .brand{display:flex;align-items:center;gap:12px;text-decoration:none}
        .brand-logo{width:52px;height:52px;object-fit:contain;display:block}
        .brand-copy strong{display:block;color:var(--red);font-size:13px;letter-spacing:1px;text-transform:uppercase}
        .brand-copy small,.brand-copy em{display:block;margin-top:3px;color:#888;font-size:9px;letter-spacing:1px;text-transform:uppercase}
        .brand-copy em{color:#999;font-style:normal;letter-spacing:0;text-transform:none}
        .back-link{color:var(--red);font-size:12px;font-weight:700;text-decoration:none;white-space:nowrap}
        .page-heading{padding:48px 18px 42px;color:#fff;text-align:center;background:linear-gradient(120deg,#171717,#7d1026 55%,var(--red))}
        .eyebrow{margin:0 0 10px;color:#f2d58e;font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase}
        .page-heading h1{margin:0 0 10px;font-size:clamp(32px,6vw,52px);line-height:1.1}
        .page-heading p{max-width:620px;margin:0 auto;color:rgba(255,255,255,.86);font-size:14px;line-height:1.7}
        .results-wrap{width:min(1080px,calc(100% - 36px));margin:0 auto;padding:35px 0 60px}
        .results-top{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:25px}
        .results-top h2{margin:0;font-size:20px}
        .refresh-note{color:var(--muted);font-size:11px}
        .category-results{margin-bottom:30px;border:1px solid #e8e8e8;background:#fff}
        .category-title{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:17px 18px;background:#fafafa;border-bottom:1px solid #eee}
        .category-title h3{margin:0;font-size:16px}
        .category-total{color:var(--muted);font-size:11px;white-space:nowrap}
        .category-status{padding:8px 18px 0;color:#8a6a20;font-size:11px;font-weight:600}
        .standings{padding:8px 18px 16px}
        .nominee-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:10px 16px;align-items:center;padding:14px 0;border-bottom:1px solid #eee}
        .nominee-row:last-child{border-bottom:0}
        .nominee-name{font-size:13px;font-weight:700}
        .vote-total{font-size:12px;font-weight:800;text-align:right;white-space:nowrap}
        .vote-bar{grid-column:1/-1;height:7px;background:#eee;overflow:hidden}
        .vote-bar span{display:block;height:100%;background:linear-gradient(90deg,var(--red),var(--gold))}
        .empty-category{padding:22px 18px;color:var(--muted);font-size:13px}
        .empty-all{padding:30px;border:1px solid #eee;text-align:center;color:var(--muted)}
        @media(max-width:430px){.brand-logo{width:43px;height:43px}.brand-copy strong{font-size:11px}.brand-copy small,.brand-copy em{font-size:8px}.back-link{font-size:11px}.category-title{padding:15px 12px}.standings{padding-left:12px;padding-right:12px}}
    </style>
</head>
<body>
    <header class="site-header">
        <a class="brand" href="../index.php" aria-label="Live Show Awards home">
            <img class="brand-logo" src="../assets/images/logo.png" alt="Live Show Awards logo">
            <span class="brand-copy">
                <strong>Live Show Awards</strong>
                <small>Salima District, Malawi</small>
                <em>Celebrating Salima's finest</em>
            </span>
        </a>
        <a class="back-link" href="../index.php">&larr; Home</a>
    </header>

    <main>
        <section class="page-heading">
            <p class="eyebrow">Live Show Awards · Salima District</p>
            <h1>Live Results</h1>
            <p>Follow the public voting standings across all award categories.</p>
        </section>

        <section class="results-wrap">
            <div class="results-top">
                <h2>Current Standings</h2>
                <span class="refresh-note">Refresh the page for the latest totals</span>
            </div>

            <?php if ($categories): ?>
                <?php foreach ($categories as $category): ?>
                    <section class="category-results">
                        <div class="category-title">
                            <h3><?php echo escapeResult($category['title']); ?></h3>
                            <span class="category-total"><?php echo number_format($category['total_votes']); ?> votes</span>
                        </div>

                        <?php if ($category['is_open'] !== 1): ?>
                            <div class="category-status">Voting is currently closed in this category.</div>
                        <?php endif; ?>

                        <?php if ($category['nominees']): ?>
                            <div class="standings">
                                <?php
                                usort($category['nominees'], static function (array $a, array $b): int {
                                    return $b['votes'] <=> $a['votes'];
                                });
                                $highestVotes = max(1, ...array_column($category['nominees'], 'votes'));
                                ?>
                                <?php foreach ($category['nominees'] as $nominee): ?>
                                    <?php $barWidth = ($nominee['votes'] / $highestVotes) * 100; ?>
                                    <div class="nominee-row">
                                        <span class="nominee-name"><?php echo escapeResult($nominee['name']); ?></span>
                                        <span class="vote-total"><?php echo number_format($nominee['votes']); ?> votes</span>
                                        <div class="vote-bar" aria-label="<?php echo escapeResult($nominee['name']); ?> vote share">
                                            <span style="width:<?php echo number_format($barWidth, 2, '.', ''); ?>%"></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-category">Nominees have not yet been added to this category.</div>
                        <?php endif; ?>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-all">Results are not available yet.</div>
            <?php endif; ?>
        </section>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
