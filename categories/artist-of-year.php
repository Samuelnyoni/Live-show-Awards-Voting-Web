<?php
/*
 * Live Show Awards Malawi
 * Category page template — Artist of the Year
 *
 * This first version is for layout testing. Replace the placeholder nominees
 * and connect the voting form to the database in a later development step.
 */

$category = [
    'slug' => 'artist-of-year',
    'title' => 'Artist of the Year',
    'description' => 'Recognising the artist whose talent, creativity and impact have stood out.',
];

$nominees = [
    ['name' => 'Nominee Name 1', 'image' => '../assets/images/nominee-placeholder.png'],
    ['name' => 'Nominee Name 2', 'image' => '../assets/images/nominee-placeholder.png'],
    ['name' => 'Nominee Name 3', 'image' => '../assets/images/nominee-placeholder.png'],
    ['name' => 'Nominee Name 4', 'image' => '../assets/images/nominee-placeholder.png'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($category['description']); ?>">
    <title><?php echo htmlspecialchars($category['title']); ?> | Live Show Awards Malawi</title>
    <style>
        :root {
            --red: #c8102e;
            --red-dark: #a80d26;
            --gold: #d7ad45;
            --ink: #171717;
            --muted: #686868;
            --soft: #f5f5f5;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--ink);
            background: #fff;
            font-family: Arial, Helvetica, sans-serif;
        }
        a { color: inherit; }
        .site-header {
            min-height: 76px;
            padding: 12px clamp(18px, 4vw, 46px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .brand-logo { width: 52px; height: 52px; object-fit: contain; display: block; }
        .brand-copy strong {
            display: block;
            color: var(--red);
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .brand-copy small {
            display: block;
            margin-top: 3px;
            color: #777;
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .brand-copy em { display:block; margin-top:3px; color:#999; font-size:9px; font-style:normal; }
        .back-link {
            color: var(--red);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }
        .category-heading {
            padding: 48px 18px 42px;
            color: #fff;
            text-align: center;
            background: linear-gradient(120deg, #171717, #7d1026 55%, var(--red));
        }
        .eyebrow {
            margin: 0 0 12px;
            color: #f2d58e;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .category-heading h1 {
            margin: 0 0 12px;
            font-size: clamp(32px, 6vw, 54px);
            line-height: 1.08;
        }
        .category-heading p {
            max-width: 620px;
            margin: 0 auto;
            color: rgba(255,255,255,.86);
            font-size: 14px;
            line-height: 1.65;
        }
        .voting-content {
            width: min(1120px, calc(100% - 36px));
            margin: 0 auto;
            padding: 38px 0 55px;
        }
        .section-top {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 22px;
        }
        .section-top h2 {
            margin: 0;
            font-size: 22px;
        }
        .nominee-count {
            color: var(--muted);
            font-size: 12px;
            white-space: nowrap;
        }
        .nominee-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }
        .nominee-card {
            overflow: hidden;
            border: 1px solid #e8e8e8;
            background: #fff;
        }
        .nominee-photo {
            aspect-ratio: 1 / 1;
            display: grid;
            place-items: center;
            color: #8a8a8a;
            background:
                linear-gradient(135deg, rgba(200,16,46,.09), transparent 55%),
                #ededed;
            font-size: 12px;
            text-align: center;
        }
        .nominee-photo span {
            padding: 8px;
            border: 1px dashed #bcbcbc;
        }
        .nominee-info {
            padding: 13px;
            text-align: center;
        }
        .nominee-info h3 {
            margin: 0 0 12px;
            font-size: 14px;
        }
        .vote-button {
            width: 100%;
            padding: 11px 12px;
            border: 0;
            color: #fff;
            background: var(--red);
            font-size: 12px;
            font-weight: 700;
            cursor: not-allowed;
            opacity: .72;
        }
        .voting-notice {
            margin-top: 24px;
            padding: 15px 17px;
            border-left: 4px solid var(--gold);
            background: #faf7ef;
            color: #5e5237;
            font-size: 13px;
            line-height: 1.6;
        }
        .site-footer {
            padding: 20px;
            color: #bbb;
            background: #171717;
            text-align: center;
            font-size: 11px;
        }
        @media (min-width: 650px) {
            .nominee-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
            .nominee-info { padding: 17px; }
        }
        @media (min-width: 950px) {
            .nominee-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <a class="brand" href="../index.php" aria-label="Live Show Awards Malawi home">
            <img class="brand-logo" src="../assets/images/logo.png" alt="Live Show Awards logo">
            <span class="brand-copy">
                <strong>Live Show Awards</strong>
                <small>Salima District, Malawi</small>
                <em>Celebrating Salima's finest</em>
            </span>
        </a>
        <a class="back-link" href="../index.php">&larr; Back to Home</a>
    </header>

    <main>
        <section class="category-heading">
            <p class="eyebrow">Live Show Awards Malawi</p>
            <h1><?php echo htmlspecialchars($category['title']); ?></h1>
            <p><?php echo htmlspecialchars($category['description']); ?></p>
        </section>

        <section class="voting-content">
            <div class="section-top">
                <h2>Meet the Nominees</h2>
                <span class="nominee-count"><?php echo count($nominees); ?> Nominees</span>
            </div>

            <div class="nominee-grid">
                <?php foreach ($nominees as $nominee): ?>
                    <article class="nominee-card">
                        <div class="nominee-photo">
                            <span>Nominee photograph</span>
                        </div>
                        <div class="nominee-info">
                            <h3><?php echo htmlspecialchars($nominee['name']); ?></h3>
                            <button class="vote-button" type="button" disabled aria-disabled="true">Voting not active yet</button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="voting-notice">
                This is the first layout version. Nominee details and photographs will be added,
                and voting will be activated after the voting system is connected.
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
