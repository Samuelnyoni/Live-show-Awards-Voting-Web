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
header{min-height:82px;padding:12px clamp(18px,4vw,46px);display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #eee;gap:14px}
.brand{display:flex;align-items:center;gap:11px;text-decoration:none}
.brand img{display:block;width:54px;height:54px;object-fit:contain}
.brand-copy{display:flex;flex-direction:column;gap:4px}
.brand-copy strong{color:var(--red);font-size:13px;letter-spacing:1px;text-transform:uppercase}
.brand-copy small{color:#777;font-size:9px;letter-spacing:1px;text-transform:uppercase}
.brand-copy em{color:#999;font-size:9px;font-style:normal}
.home-link{font-size:12px;font-weight:700;text-decoration:none;white-space:nowrap}
main{max-width:1160px;margin:auto;padding:42px 20px 64px}
.heading{text-align:center;margin:0 auto 34px;max-width:680px}
.eyebrow{color:var(--red);font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase}
h1{font-size:clamp(30px,5vw,46px);margin:10px 0}
.heading p{color:var(--muted);font-size:14px;line-height:1.7;margin:0}
.category-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px}
.category{position:relative;overflow:hidden;display:flex;flex-direction:column;text-decoration:none;background:#fff;border:1px solid #e9e5dc;box-shadow:0 4px 14px rgba(0,0,0,.045);transition:transform .2s,box-shadow .2s,border-color .2s}
.category:hover{transform:translateY(-4px);border-color:var(--gold);box-shadow:0 10px 24px rgba(0,0,0,.10)}
.category-image{width:100%;aspect-ratio:1/1;background:#171717 url("../assets/images/logobg.jpg") center/cover no-repeat;position:relative}
.category-image:after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,10,10,.02) 25%,rgba(10,10,10,.68) 100%)}
.category-content{min-height:102px;padding:15px 15px 16px;display:flex;flex-direction:column;justify-content:space-between;gap:13px;border-top:3px solid var(--gold)}
.category h2{font-size:15px;line-height:1.35;margin:0;font-weight:800}
.category span{font-size:10px;font-weight:800;color:var(--red);letter-spacing:1px}
footer{text-align:center;padding:20px;background:#171717;color:#bbb;font-size:11px}
@media(min-width:700px){.category-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.category{padding:12px}}
@media(min-width:1000px){.category-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
</style>
</head>
<body>
<header>
<a class="brand" href="../index.php">
<img src="../assets/images/logo.png" alt="Live Show Awards logo">
<span class="brand-copy"><strong>Live Show Awards</strong><small>Salima District, Malawi</small><em>Celebrating Salima's finest</em></span>
</a>
<a class="home-link" href="../index.php">← Back to Home</a>
</header>
<main>
<section class="heading">
<div class="eyebrow">Salima District · Your vote matters</div>
<h1>Explore the Categories</h1>
<p>Choose an award category to meet the nominees and cast your vote. Your vote helps celebrate the talent and creativity of Salima District.</p>
</section>
<section class="category-grid" aria-label="Award categories">
<?php foreach ($categories as $category): ?>
    <a class="category" href="<?php echo htmlspecialchars($category["slug"] === "artist-of-year" ? "artist-of-year.php" : $category["slug"] . ".php"); ?>">
        <div class="category-image" aria-hidden="true"></div>
        <div class="category-content"><h2><?php echo htmlspecialchars($category["title"]); ?></h2><span>EXPLORE CATEGORY&nbsp; →</span></div>
    </a>
<?php endforeach; ?>
</section>
</main>
<footer>&copy; <?php echo date('Y'); ?> Live Show Awards · Salima District, Malawi. All rights reserved.</footer>
</body>
</html>
