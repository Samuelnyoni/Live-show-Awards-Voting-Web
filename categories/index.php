<?php
// Live Show Awards Malawi — voting categories landing page
$categories = [
    ["title" => "Artist of the Year", "slug" => "artist-of-year", "description" => "Recognising an outstanding artist of the year."],
    ["title" => "Song of the Year", "slug" => "song-of-year", "description" => "Celebrating a standout song."],
    ["title" => "Album of the Year", "slug" => "album-of-year", "description" => "Recognising an exceptional album."],
    ["title" => "Best Male Artist", "slug" => "best-male-artist", "description" => "Celebrating outstanding male talent."],
    ["title" => "Best Female Artist", "slug" => "best-female-artist", "description" => "Celebrating outstanding female talent."],
    ["title" => "Best Upcoming Artist", "slug" => "best-upcoming-artist", "description" => "Recognising a rising star."],
    ["title" => "Best Hip Hop Artist", "slug" => "best-hip-hop-artist", "description" => "Celebrating excellence in hip hop."],
    ["title" => "Best Amapiano Artist", "slug" => "best-amapiano-artist", "description" => "Celebrating excellence in amapiano."],
    ["title" => "Best Dancehall Artist", "slug" => "best-dancehall-artist", "description" => "Celebrating excellence in dancehall."],
    ["title" => "Best Gospel Artist", "slug" => "best-gospel-artist", "description" => "Recognising inspirational gospel music."],
    ["title" => "Best Music Producer", "slug" => "best-producer", "description" => "Recognising outstanding music production."],
    ["title" => "Best Music Video", "slug" => "best-music-video", "description" => "Celebrating outstanding music visuals."],
    ["title" => "Best Collaboration", "slug" => "best-collaboration", "description" => "Recognising an exceptional collaboration."],
    ["title" => "Best Live Performer", "slug" => "best-live-performer", "description" => "Celebrating powerful live performances."],
    ["title" => "Best Duo / Group", "slug" => "best-duo-group", "description" => "Recognising an outstanding duo or group."]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Explore the Live Show Awards Malawi voting categories.">
<title>Voting Categories | Live Show Awards Malawi</title>
<style>
:root{--red:#c8102e;--gold:#d7ad45;--ink:#171717;--muted:#686868;--soft:#f5f5f5}
*{box-sizing:border-box}
body{margin:0;font-family:Arial,Helvetica,sans-serif;color:var(--ink);background:#fff}
a{color:inherit}
header{min-height:76px;padding:14px clamp(18px,4vw,46px);display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #eee}
.brand{display:flex;align-items:center;text-decoration:none}
.brand img{display:block;width:58px;height:58px;object-fit:contain}
.home-link{font-size:13px;font-weight:700;text-decoration:none}
main{max-width:1120px;margin:auto;padding:38px 20px 60px}
.heading{text-align:center;margin:0 auto 30px;max-width:650px}
.eyebrow{color:var(--red);font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase}
h1{font-size:clamp(30px,5vw,46px);margin:10px 0}
.heading p{color:var(--muted);font-size:14px;line-height:1.6;margin:0}
.category-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px}
.category{padding:10px;border:1px solid #e8e8e8;background:#fff;display:flex;flex-direction:column;gap:12px;text-decoration:none;transition:border-color .2s,transform .2s}
.category:hover{border-color:var(--gold);transform:translateY(-2px)}
.category-image{width:100%;aspect-ratio:1/1;background:#171717 url("../assets/images/logobg.jpg") center/cover no-repeat;overflow:hidden}
.category h2{font-size:16px;margin:0 0 7px}
.category p{font-size:12px;color:var(--muted);line-height:1.5;margin:0}
.category span{font-size:11px;font-weight:800;color:var(--red);letter-spacing:.6px}
footer{text-align:center;padding:20px;background:#171717;color:#bbb;font-size:11px}
@media(min-width:700px){.category-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.category{padding:12px}}
@media(min-width:1000px){.category-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
</style>
</head>
<body>
<header>
<a class="brand" href="../index.php"><img src="../assets/images/logo.png" alt="Live Show Awards Malawi"></a>
<a class="home-link" href="../index.php">← Back to Home</a>
</header>
<main>
<section class="heading">
<div class="eyebrow">Your vote matters</div>
<h1>Voting Categories</h1>
<p>Choose an award category below to view its nominees and cast your vote. Every vote helps recognise Malawi's talent.</p>
</section>
<section class="category-grid" aria-label="Award categories">
<?php foreach ($categories as $category): ?>
    <a class="category" href="<?php echo htmlspecialchars($category["slug"] === "artist-of-year" ? "artist-of-year.php" : $category["slug"] . ".php"); ?>">
        <div class="category-image" aria-hidden="true"></div>
        <div><h2><?php echo htmlspecialchars($category["title"]); ?></h2><span>VIEW CATEGORY →</span></div>
    </a>
<?php endforeach; ?>
</section>
</main>
<footer>&copy; <?php echo date('Y'); ?> Live Show Awards Malawi. All rights reserved.</footer>
</body>
</html>
