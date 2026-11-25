<?php
// Live Show Awards Malawi — homepage
// This is the first visual version. Voting and live results will be connected later.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <meta name="description" content="Live Show Awards Malawi celebrates outstanding talent and achievement in Malawi's music and entertainment industry.">
    <title>Live Show Awards Malawi</title>
    <style>
        :root {
            --red: #c8102e;
            --red-dark: #a80d26;
            --gold: #d7ad45;
            --ink: #171717;
            --muted: #666;
            --paper: #fff;
            --soft: #f5f5f5;
        }
        * { box-sizing: border-box; }
        button, input, select, textarea { font: inherit; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            background: var(--paper);
            font-family: 'Poppins', sans-serif;
        }
        a { color: inherit; }
        .site-header {
            min-height: 82px;
            padding: 12px clamp(18px, 4vw, 46px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .brand-logo { width: 58px; height: 58px; object-fit: contain; display: block; }
        .brand-copy { display: flex; flex-direction: column; gap: 4px; }
        .brand-copy strong {
            color: var(--red);
            font-size: 14px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }
        .brand-copy small {
            color: #777;
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .brand-copy em { color: #999; font-size: 9px; font-style: normal; letter-spacing: .7px; }
        .menu-toggle {
            width: 44px;
            height: 44px;
            border: 0;
            border-radius: 0;
            background: #e8edf5;
            display: grid;
            place-content: center;
            gap: 5px;
            cursor: pointer;
        }
        .menu-toggle span { width: 23px; height: 2px; background: #24395f; display: block; }
        .main-nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            padding: 12px 22px 18px;
            background: #fff;
            box-shadow: 0 8px 18px rgba(0,0,0,.10);
        }
        .main-nav.is-open { display: grid; }
        .main-nav a {
            padding: 12px 2px;
            text-decoration: none;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            font-weight: 700;
        }
        .hero-banner {
            min-height: clamp(175px, 34vw, 310px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 18px;
            text-align: center;
            color: white;
            overflow: hidden;
            position: relative;
            isolation: isolate;
            background:
                radial-gradient(ellipse at 18% 25%, rgba(215,173,69,.72), transparent 30%),
                radial-gradient(ellipse at 82% 75%, rgba(255,255,255,.17), transparent 34%),
                linear-gradient(115deg, #171717 0%, #6e0c20 48%, #c8102e 100%);
        }
        .hero-banner::before, .hero-banner::after {
            content: "";
            position: absolute;
            z-index: -1;
            width: 230px;
            height: 230px;
            border: 1px solid rgba(255,255,255,.22);
            transform: rotate(45deg);
        }
        .hero-banner::before { left: -100px; top: -100px; }
        .hero-banner::after { right: -95px; bottom: -135px; width: 300px; height: 300px; }
        .banner-message {
            max-width: 760px;
            padding: 16px 22px;
            background: rgba(200,16,46,.92);
            border-left: 5px solid var(--gold);
            box-shadow: 0 8px 25px rgba(0,0,0,.18);
        }
        .banner-message small {
            display: block;
            margin-bottom: 7px;
            color: #f5d98e;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .banner-message strong {
            display: block;
            font-size: clamp(25px, 5vw, 48px);
            line-height: 1.05;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .intro {
            padding: 12px clamp(18px, 4vw, 46px) 38px;
            color: white;
            background: var(--red);
            position: relative;
            overflow: hidden;
        }
        .intro::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: -160px;
            top: 30px;
            border: 1px solid rgba(255,255,255,.13);
            transform: rotate(35deg);
        }
        .intro-inner { max-width: 1050px; margin: 0 auto; position: relative; }
        .intro h1 {
            margin: 0 0 28px;
            text-align: center;
            font-size: clamp(35px, 7vw, 66px);
            line-height: 1.08;
            font-weight: 900;
            letter-spacing: -1.5px;
        }
        .intro p {
            max-width: 780px;
            margin: 0 auto 20px;
            font-size: 15px;
            line-height: 1.7;
            font-weight: 500;
        }
        .vote-action { text-align: center; margin-top: 26px; }
        .vote-button {
            display: inline-block;
            padding: 14px 24px;
            color: #333;
            background: #fff;
            border-radius: 3px;
            text-decoration: none;
            font-size: 14px;
            transition: background .2s ease, transform .2s ease;
        }
        .vote-button:hover { background: #f4e6c4; transform: translateY(-2px); }
        .support-section {
            padding: 42px clamp(18px, 4vw, 46px);
            text-align: center;
            background: #fff;
        }
        .support-section h2 { margin: 0 0 10px; font-size: 25px; }
        .support-section p {
            max-width: 650px;
            margin: 0 auto 20px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.65;
        }
        .sponsor-link {
            display: inline-block;
            padding: 12px 20px;
            color: #fff;
            background: var(--ink);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }
        .partners {
            padding: 26px 18px 34px;
            text-align: center;
            background: var(--soft);
        }
        .partners h2 {
            margin: 0 0 20px;
            color: #555;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .partner-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: clamp(16px, 3vw, 32px);
            max-width: 1100px;
            margin: 0 auto;
        }
        .partner-logo {
            display: block;
            width: min(100%, 460px);
            flex: 1 1 320px;
            max-width: 460px;
            height: auto;
            object-fit: contain;
        }
        @media (max-width: 520px) {
            .partner-list { flex-direction: column; gap: 18px; }
            .partner-logo { width: min(100%, 420px); flex: 0 0 auto; }
        }
        .site-footer {
            padding: 20px;
            color: #bbb;
            background: #171717;
            text-align: center;
            font-size: 11px;
        }
        @media (min-width: 800px) {
            .site-header { padding-left: max(5vw, calc((100vw - 1180px)/2)); padding-right: max(5vw, calc((100vw - 1180px)/2)); }
            .menu-toggle { display: none; }
            .main-nav {
                display: flex;
                position: static;
                padding: 0;
                gap: 22px;
                background: transparent;
                box-shadow: none;
            }
            .main-nav a { padding: 8px 0; border: 0; font-size: 12px; }
            .main-nav a:hover { color: var(--red); }
            .intro { padding-top: 18px; padding-bottom: 48px; }
            .intro h1 { margin-bottom: 38px; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <a class="brand" href="index.php" aria-label="Live Show Awards Malawi home">
            <img class="brand-logo" src="assets/images/logo.png" alt="Live Show Awards logo">
            <span class="brand-copy">
                <strong>Live Show Awards</strong>             
                <em>Celebrating Salima's finest Talents</em>
            </span>
        </a>

        <button class="menu-toggle" id="menuToggle" aria-label="Open navigation" aria-expanded="false" aria-controls="mainNav">
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" id="mainNav">
            <a href="index.php">HOME</a>
            <a href="categories/">VOTE NOW</a>
            <a href="#sponsorship">SPONSORSHIP</a>
            <a href="#partners">PARTNERS</a>
            <a href="results/">LIVE RESULTS</a>
        </nav>
    </header>

    <main>
        <section class="hero-banner" aria-label="Live Show Awards Malawi">
            <div class="banner-message">
                <small>Celebrating Malawi's finest</small>
                <strong>Live Show Awards</strong>
            </div>
        </section>

        <section class="intro" id="about">
            <div class="intro-inner">
                <h1>Live Show Awards</h1>
                <p>
                    Live Show Awards celebrates outstanding talent, creativity and achievement
                    in Salima music and entertainment scene. The awards bring the
                    community together to recognise the artists and performers shaping our culture.
                </p>
                <div class="vote-action"><a class="vote-button" href="categories/">VOTE NOW</a></div>
            </div>
        </section>

        <section class="support-section" id="sponsorship">
            <h2>Partner with the Awards</h2>
            <p>
                Put your brand alongside Malawi's creative talent. We welcome organisations
                and businesses interested in supporting the awards and connecting with our audience.
            </p>
            <a class="sponsor-link" href="#sponsorship">Enquire About Sponsorship</a>
        </section>

        <section class="partners" id="partners">
            <h2>Our Partners</h2>
            <div class="partner-list">
                <img class="partner-logo" src="assets/images/dxlogo.png" alt="DijitalX Systems partner logo">
                <img class="partner-logo" src="assets/images/dzlogo.png" alt="Dolza Real Properties and Estate Agency partner logo">
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mainNav = document.getElementById('mainNav');

        menuToggle.addEventListener('click', function () {
            const isOpen = mainNav.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            menuToggle.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
        });
    </script>
</body>
</html>
