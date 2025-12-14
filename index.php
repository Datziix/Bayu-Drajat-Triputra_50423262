<?php
// index.php - landing page
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Glacier Scent - Exclusive Collection</title>

<style>
:root {
  --bg-main: #281E18;      /* Licorice */
  --surface: #572D0C;      /* Seal brown */
  --gold: #C78E3A;         /* Harvest gold */
  --gold-soft: #E3B76A;    /* Earth yellow */
  --cream: #FDFCD4;        /* Cream */
  --text-main: #FDFCD4;
  --text-muted: rgba(253, 252, 212, 0.75);
}

/* RESET */
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
  background: radial-gradient(circle at top, #281E18, #281E18 60%);
  color: var(--text-main);
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* HEADER */
header {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 20;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 40px;
  color: var(--cream);
}

header::after {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom,
    rgba(40, 30, 24, 0.95),
    rgba(40, 30, 24, 0.0)
  );
  z-index: -1;
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
}

.brand-logo {
  width: 32px;
  height: 32px;
  border-radius: 999px;
  background: radial-gradient(circle at 30% 10%, #FDFCD4, #E3B76A 45%, #572D0C 80%);
  box-shadow: 0 0 25px rgba(231, 192, 115, 0.8);
}

.brand-name {
  font-size: 0.9rem;
  font-weight: 600;
  letter-spacing: 0.14em;
}

.nav-links a {
  font-size: 0.8rem;
  margin-left: 16px;
  text-decoration: none;
  color: var(--cream);
  transition: color .18s ease;
}

.nav-links a:hover {
  color: var(--gold-soft);
}

/* HERO */
.hero {
  min-height: 100vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 40px;
  color: var(--cream);
}

.hero::before {
  content: "";
  position: absolute;
  inset: 0;
  background-image: url('images/hero.png'); /* pastikan namanya hero.png */
  background-size: cover;
  background-position: center;
  filter: brightness(0.6);
  z-index: -2;
}

.hero::after {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at center,
    rgba(40, 30, 24, 0.30),
    rgba(40, 30, 24, 0.92)
  );
  z-index: -1;
}

.hero-inner {
  max-width: 900px;
  text-align: center;
  padding-top: 40px;
}

.hero-kicker {
  font-size: 0.8rem;
  letter-spacing: 0.25em;
  text-transform: uppercase;
  margin-bottom: 10px;
  color: var(--text-muted);
}

.hero-title {
  font-size: clamp(2.4rem, 4vw, 3rem);
  letter-spacing: 0.04em;
  margin-bottom: 8px;
  color: var(--cream);
}

.hero-subtitle {
  font-size: 0.9rem;
  max-width: 540px;
  margin: 0 auto 24px;
  color: var(--text-muted);
}

/* BANNER KOLEKSI */
.collection-banner {
  width: 100%;
  max-width: 900px;
  overflow: hidden;
  border-radius: 18px;
  margin: 0 auto 22px;
  border: 1px solid rgba(199, 142, 58, 0.55);
  box-shadow:
    0 18px 40px rgba(0, 0, 0, 0.8),
    0 0 0 1px rgba(253, 252, 212, 0.06);
  background: radial-gradient(circle at top, rgba(87,45,12,0.6), rgba(40,30,24,0.9));
}

.collection-banner img {
  width: 100%;
  height: auto;
  display: block;
  object-fit: cover;
}

/* BUTTON */
.hero-actions {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.hero-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 28px;
  border-radius: 999px;
  border: none;
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  background: linear-gradient(135deg, var(--gold-soft), var(--gold));
  color: #281E18;
  box-shadow: 0 18px 45px rgba(199, 142, 58, 0.7);
  transition: transform .12s ease, box-shadow .12s ease, filter .12s ease;
}

.hero-button:hover {
  transform: translateY(-1px);
  filter: brightness(1.02);
  box-shadow: 0 20px 55px rgba(199, 142, 58, 0.85);
}

/* FOOTER */
footer {
  border-top: 1px solid rgba(199, 142, 58, 0.4);
  padding: 12px 0 16px;
  font-size: 0.78rem;
  color: rgba(253, 252, 212, 0.7);
  text-align: center;
  background: #281E18;
}
</style>
</head>
<body>

<header>
  <div class="brand">
    <div class="brand-logo"></div>
    <div class="brand-text">
      <div class="brand-name">GLACIER SCENT</div>
    </div>
  </div>
  <nav class="nav-links">
    <a href="#hero">Home</a>
    <a href="shop.php">Shop</a>
    <a href="login.php">Admin</a>
  </nav>
</header>

<section class="hero" id="hero">
  <div class="hero-inner">
    <div class="hero-kicker">WHERE LUXURY MEETS YOUR SENSES</div>
    <h1 class="hero-title">Exclusive Collection</h1>
    <p class="hero-subtitle">
      Temukan koleksi parfum pilihan dengan karakter mewah, dibuat dari bahan terbaik.
      Dari nuansa woody hangat hingga citrus segar, semua diracik untuk melengkapi gaya kamu.
    </p>

    <div class="collection-banner">
      <img src="images/collection-banner.jpg" alt="Parfum Collection">
    </div>

    <div class="hero-actions">
      <a href="shop.php" class="hero-button">SHOP NOW</a>
    </div>
  </div>
</section>

<footer>
  © <?= date('Y') ?> Glacier Scent · Mini sistem parfum dengan PHP &amp; MySQL
</footer>

</body>
</html>
