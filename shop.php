<?php
require 'config.php';

// Ambil produk
$result = $conn->query("SELECT * FROM products ORDER BY id ASC");

// Helper
function rupiah($n) {
    return "Rp " . number_format($n, 0, ',', '.');
}

// Gambar / detail untuk modal
$imageMap = [
    'Noir Sillage' => 'https://michelgermain.com/cdn/shop/files/michel-germain-paris-noir-men-cologne-fragrance-eau-de-toilette-100ml-bottle-glow_1200x1200.jpg?v=1714499111',
    'Velvet Bloom' => 'https://s13emagst.akamaized.net/products/52094/52093854/images/res_3fa352da525da8de24cdfd7a8db4945f.png',
    'Citrus Mist'  => 'https://snif.co/cdn/shop/files/Snif_Fragrance_Citrus_Circus_30ml_Product_1_1024x1024.jpg?v=1686187266',
    'Amber Luxe'   => 'https://bisniskosmetika.com/wp-content/uploads/2023/07/Amber-Elixir-eau-de-parfum.jpg',
    'Rosé Aura'    => 'https://fraguru.com/mdimg/secundar/o.53545.jpg',
    'Cloud Musk'   => 'https://myperfumeshome.com/wp-content/uploads/2024/07/Eau-de-parfum-Musk-Tahara-Ayat-P.jpg',
    'Royal Oud'    => 'https://cdn.shopify.com/s/files/1/1188/2592/products/100mlEDTLifestyleOudLifestyle_900x.jpg?v=1626948592',
    'Floral Dream' => 'https://i.pinimg.com/originals/54/63/81/5463811ae23ecf5beb5d34de88ffb0b4.png'
];

$productDetails = [
    'Noir Sillage' => [
        'category' => 'Pria • Woody Amber',
        'notes'    => 'Top: Bergamot, Lavender • Heart: Iris, Geranium • Base: Amber, Cedarwood',
        'vibe'     => 'Malam hari, acara formal, dating elegan',
        'strength' => 'Tahan 8–10 jam, sillage kuat'
    ],
    'Velvet Bloom' => [
        'category' => 'Wanita • Floral Sweet',
        'notes'    => 'Top: Pear, Mandarin • Heart: Rose, Jasmine • Base: Vanilla, White Musk',
        'vibe'     => 'Feminim manis, cocok daily & hangout',
        'strength' => 'Tahan 6–8 jam, sillage sedang'
    ],
    'Citrus Mist' => [
        'category' => 'Unisex • Fresh Citrus',
        'notes'    => 'Top: Lemon, Mandarin • Heart: Green Tea, Neroli • Base: Musk, Cedar',
        'vibe'     => 'Seger habis mandi, cocok ke kampus atau kerja',
        'strength' => 'Tahan 5–7 jam, sillage soft–medium'
    ],
    'Amber Luxe' => [
        'category' => 'Pria • Warm Spicy Amber',
        'notes'    => 'Top: Saffron, Pink Pepper • Heart: Amberwood, Tonka • Base: Patchouli, Cedar',
        'vibe'     => 'Maskulin hangat, berasa parfum niche',
        'strength' => 'Tahan 8–10 jam, sillage kuat'
    ],
    'Rosé Aura' => [
        'category' => 'Wanita • Fruity Floral',
        'notes'    => 'Top: Red Berries, Lychee • Heart: Rose, Peony • Base: Vanilla, Sandalwood',
        'vibe'     => 'Ceria, romantis, cocok kencan & acara spesial',
        'strength' => 'Tahan 6–8 jam, sillage sedang'
    ],
    'Cloud Musk' => [
        'category' => 'Unisex • Musky Sweet',
        'notes'    => 'Top: Lactonic Notes • Heart: Powdery Violet • Base: Musk, Vanilla, Cashmeran',
        'vibe'     => 'Lembut, cozy, kayak selimut hangat',
        'strength' => 'Tahan 7–9 jam, sillage soft–medium'
    ],
    'Royal Oud' => [
      'category' => 'Pria • Oud Animalic',
      'notes'    => 'Top: Oud Wood • Heart: Amber, Saffron • Base: Amber, Vanilla, Iris',
      'vibe'     => 'Strong, Room filler fragrance, cocok untuk ceo & boss',
      'strength' => 'Tahan 10-12 jam, sillage strong'
    ],
    'Floral Dream' => [
      'category' => 'Unisex • Fresh Floral',
      'notes'    => 'Top: Jasmine, Citrus, Rose • Heart: Iso E Super • Base: Ambroxan',
      'vibe'     => 'Fresh Floral, Soapy kaya habis mandi',
      'strength' => 'Tahan 6–8 jam, sillage soft–medium'
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Shop - Glacier Scent</title>

<style>
:root {
  --bg-main: #281E18;
  --surface: #572D0C;
  --surface-soft: #3a2718;
  --border-soft: #C78E3A;
  --gold: #C78E3A;
  --gold-soft: #E3B76A;
  --cream: #FDFCD4;
  --text-main: #FDFCD4;
  --text-muted: rgba(253, 252, 212, 0.75);
  --danger: #FCA5A5;
  --safe: #6EE7B7;
}

/* RESET */
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
  background: radial-gradient(circle at top, #281E18, #281E18 65%);
  color: var(--text-main);
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* HEADER */
header {
  position: sticky;
  top: 0;
  z-index: 20;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 40px;
  background: rgba(40, 30, 24, 0.96);
  border-bottom: 1px solid rgba(199, 142, 58, 0.5);
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
}

.brand-logo {
  width: 28px;
  height: 28px;
  border-radius: 999px;
  background: radial-gradient(circle at 30% 10%, #FDFCD4, #E3B76A 45%, #572D0C 85%);
  box-shadow: 0 0 20px rgba(227, 183, 106, 0.8);
}

.brand-name {
  font-size: 0.8rem;
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

/* MAIN */
main {
  padding: 24px 16px 40px;
}

.shop-wrapper {
  max-width: 1000px;
  margin: 0 auto;
}

/* BEST SELLER */
.best-seller {
  display: grid;
  grid-template-columns: minmax(0,1.2fr) minmax(0,1.1fr);
  gap: 24px;
  align-items: center;
  margin-bottom: 28px;
  padding: 20px 20px 22px;
  border-radius: 22px;
  background: radial-gradient(circle at top left, #3d2616, #281E18 70%);
  border: 1px solid rgba(199, 142, 58, 0.55);
  box-shadow:
    0 20px 55px rgba(0,0,0,0.85),
    0 0 0 1px rgba(253, 252, 212, 0.04);
}

.best-seller-img-wrap {
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 18px 40px rgba(0,0,0,0.9);
}

.best-seller-img {
  width: 100%;
  height: 240px;
  object-fit: cover;
}

.best-seller-title {
  letter-spacing: 0.18em;
  font-size: 0.75rem;
  text-transform: uppercase;
  color: var(--text-muted);
  margin-bottom: 6px;
}

.best-seller-name {
  font-size: 1.5rem;
  margin-bottom: 6px;
  color: var(--cream);
}

.best-seller-text {
  font-size: 0.85rem;
  color: var(--text-muted);
  margin-bottom: 10px;
}

.best-seller-notes {
  font-size: 0.8rem;
  color: var(--text-muted);
  margin-bottom: 8px;
}

.best-seller-price {
  font-size: 0.9rem;
  color: var(--gold-soft);
  margin-bottom: 10px;
}

/* KOLEKSI GRID PANEL */
.panel {
  background: radial-gradient(circle at top, #3a2718, #281E18 70%);
  border-radius: 20px;
  padding: 16px 18px;
  border: 1px solid rgba(199, 142, 58, 0.55);
  box-shadow: 0 18px 45px rgba(0,0,0,0.9);
  height: 100%;
}

h2 {
  font-size: 1.2rem;
  margin-bottom: 4px;
  color: var(--cream);
}

.subtitle {
  font-size: 0.85rem;
  color: var(--text-muted);
  margin-bottom: 10px;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
  gap: 14px;
}

.card {
  border-radius: 16px;
  padding: 12px;
  border: 1px solid rgba(199, 142, 58, 0.55);
  background: radial-gradient(circle at top left, #3c2617, #281E18 75%);
  position: relative;
  overflow: hidden;
  box-shadow: 0 14px 35px rgba(0,0,0,0.9);
}

.pill {
  font-size: 0.7rem;
  border: 1px solid rgba(253, 252, 212, 0.35);
  display: inline-flex;
  padding: 3px 8px;
  border-radius: 999px;
  margin-bottom: 8px;
  color: var(--cream);
  background: rgba(199, 142, 58, 0.2);
}

.image-btn {
  display: block;
  border: none;
  padding: 0;
  margin: 0;
  background: transparent;
  cursor: pointer;
}

.product-img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 12px;
  margin-bottom: 8px;
  box-shadow: 0 12px 30px rgba(0,0,0,0.9);
}

.name { font-size: 1rem; font-weight: 600; margin-bottom: 2px; }
.meta { font-size: 0.78rem; color: var(--text-muted); margin-bottom: 5px; }
.price { font-size: 0.95rem; color: var(--gold-soft); margin-bottom: 6px; }

.stok { font-size: 0.8rem; }
.stok.habis { color: var(--danger); }
.stok.tipis { color: #FDE68A; }
.stok.aman  { color: var(--safe); }

@media (max-width: 900px) {
  .best-seller { grid-template-columns: 1fr; }
}

/* FLOATING CART BUTTON */
.cart-button {
  position: fixed;
  right: 24px;
  bottom: 24px;
  width: 52px;
  height: 52px;
  border-radius: 999px;
  border: none;
  background: radial-gradient(circle at top, var(--gold-soft), var(--gold));
  box-shadow: 0 16px 40px rgba(199, 142, 58, 0.85);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 50;
}

.cart-button span {
  font-size: 1.4rem;
  color: #281E18;
}

/* MODAL DETAIL PRODUK */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(10, 6, 3, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
  pointer-events: none;
  transition: opacity .2s ease;
  z-index: 40;
}

.modal-backdrop.show {
  opacity: 1;
  pointer-events: auto;
}

.modal {
  background: radial-gradient(circle at top, #3b2617, #281E18 70%);
  border-radius: 20px;
  border: 1px solid rgba(199, 142, 58, 0.6);
  padding: 16px 18px 18px;
  max-width: 420px;
  width: 90%;
  box-shadow: 0 24px 60px rgba(0,0,0,0.9);
  position: relative;
}

.modal-img {
  width: 100%;
  max-height: 220px;
  object-fit: cover;
  border-radius: 14px;
  margin-bottom: 10px;
}

.modal-title { font-size: 1.1rem; margin-bottom: 2px; }
.modal-category { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px; }
.modal-price { font-size: 0.95rem; color: var(--gold-soft); margin-bottom: 8px; }

.modal-section-title {
  font-size: 0.8rem;
  font-weight: 600;
  margin-top: 6px;
  margin-bottom: 2px;
}
.modal-text { font-size: 0.8rem; color: var(--text-muted); }

.modal-close {
  position: absolute;
  top: 8px;
  right: 10px;
  border: none;
  background: transparent;
  color: var(--cream);
  font-size: 1.3rem;
  cursor: pointer;
}

/* MODAL KERANJANG (FORM ORDER) */
.cart-modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(10, 6, 3, 0.85);
  display: flex;
  justify-content: flex-end;
  align-items: stretch;
  opacity: 0;
  pointer-events: none;
  transition: opacity .2s ease;
  z-index: 45;
}

.cart-modal-backdrop.show {
  opacity: 1;
  pointer-events: auto;
}

.cart-modal {
  width: 100%;
  max-width: 380px;
  background: radial-gradient(circle at top, #3a2718, #281E18 70%);
  border-left: 1px solid rgba(199, 142, 58, 0.6);
  padding: 18px 18px 20px;
  box-shadow: -18px 0 40px rgba(0,0,0,0.9);
  position: relative;
}

.cart-modal-title {
  font-size: 1.05rem;
  margin-bottom: 4px;
}

.cart-modal-sub {
  font-size: 0.8rem;
  color: var(--text-muted);
  margin-bottom: 10px;
}

.cart-modal-close {
  position: absolute;
  top: 8px;
  right: 12px;
  border: none;
  background: transparent;
  color: var(--cream);
  font-size: 1.3rem;
  cursor: pointer;
}

label {
  font-size: 0.8rem;
  display: block;
  margin-bottom: 4px;
  color: var(--text-muted);
  margin-top: 10px;
}

input, textarea, select {
  width: 100%;
  padding: 8px;
  border-radius: 10px;
  border: 1px solid rgba(199, 142, 58, 0.6);
  background: rgba(20, 13, 7, 0.95);
  color: var(--cream);
  font-size: 0.85rem;
}

input:focus, textarea:focus, select:focus {
  outline: none;
  border-color: var(--gold-soft);
  box-shadow: 0 0 0 1px rgba(227, 183, 106, 0.6);
}

textarea {
  min-height: 70px;
  max-height: 120px;
  resize: vertical;
}

button[type="submit"] {
  margin-top: 14px;
  padding: 10px;
  border-radius: 999px;
  border: none;
  background: linear-gradient(135deg, var(--gold-soft), var(--gold));
  color: #281E18;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  box-shadow: 0 18px 40px rgba(199, 142, 58, 0.85);
}

button[type="submit"]:hover {
  filter: brightness(1.03);
}

.hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }

/* FOOTER */
footer {
  border-top: 1px solid rgba(199, 142, 58, 0.5);
  padding: 12px 0 16px;
  font-size: 0.78rem;
  color: var(--text-muted);
  text-align: center;
  background: #281E18;
  margin-top: 20px;
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
    <a href="index.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="login.php">Admin</a>
  </nav>
</header>

<main>
  <div class="shop-wrapper">

    <!-- BEST SELLER -->
    <section class="best-seller">
      <div class="best-seller-img-wrap">
        <img src="images/citrus-circus.png" alt="Citrus Circus" class="best-seller-img">
      </div>
      <div>
        <div class="best-seller-title">BEST SELLER</div>
        <div class="best-seller-name">Citrus Circus</div>
        <p class="best-seller-text">
          Parfum citrus segar dengan karakter fun &amp; energik, cocok untuk kamu yang aktif seharian.
          Manis tipis, seger, dan gampang diterima hidung orang sekitar.
        </p>
        <p class="best-seller-notes">
          Notes: Orange zest, grapefruit, sparkling bergamot, soft musk di base.
        </p>
        <div class="best-seller-price">Mulai dari <?= rupiah(189000) ?></div>
        <p style="font-size:0.8rem;color:var(--text-muted);">
          Tersedia juga varian lain di koleksi di bawah.
        </p>
      </div>
    </section>

    <!-- KOLEKSI PARFUM -->
    <section class="panel">
      <h2>Koleksi Parfum</h2>
      <div class="subtitle">Klik gambar untuk lihat detail notes &amp; vibe parfum.</div>

      <div class="grid">
        <?php
        $result2 = $conn->query("SELECT * FROM products ORDER BY id ASC");
        while ($row = $result2->fetch_assoc()):
          $stok = (int)$row['stock'];
          if ($stok == 0) { $stokClass = "habis"; $stokLabel = "Stok: Habis"; }
          elseif ($stok <= 3) { $stokClass = "tipis"; $stokLabel = "Stok: $stok pcs (Menipis)"; }
          else { $stokClass = "aman"; $stokLabel = "Stok: $stok pcs"; }

          $gender = $row['gender'] === 'pria' ? "Pria" : ($row['gender']==='wanita'?"Wanita":"Unisex");
          $name = $row['name'];
          $detail = $productDetails[$name] ?? null;

          $img = $imageMap[$name]
              ?? $row['image_url']
              ?? 'https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg?auto=compress&cs=tinysrgb&w=800';

          $category = $detail['category'] ?? ($gender . ' • EDP');
          $notes    = $detail['notes']    ?? 'Detail notes belum diisi.';
          $vibe     = $detail['vibe']     ?? '-';
          $strength = $detail['strength'] ?? '-';
        ?>
        <article class="card">
          <div class="pill"><?= $gender ?></div>

          <button type="button"
                  class="image-btn product-detail-trigger"
                  data-name="<?= htmlspecialchars($name) ?>"
                  data-category="<?= htmlspecialchars($category) ?>"
                  data-price="<?= rupiah($row['price']) ?>"
                  data-notes="<?= htmlspecialchars($notes) ?>"
                  data-vibe="<?= htmlspecialchars($vibe) ?>"
                  data-strength="<?= htmlspecialchars($strength) ?>"
                  data-img="<?= htmlspecialchars($img) ?>">
            <img src="<?= htmlspecialchars($img) ?>"
                 alt="<?= htmlspecialchars($name) ?>"
                 class="product-img">
          </button>

          <div class="name"><?= htmlspecialchars($name) ?></div>
          <div class="meta"><?= $gender ?> • EDP</div>
          <div class="price"><?= rupiah($row['price']) ?></div>
          <div class="stok <?= $stokClass ?>"><?= $stokLabel ?></div>
        </article>
        <?php endwhile; ?>
      </div>
    </section>
  </div>
</main>

<!-- FLOATING CART BUTTON -->
<button class="cart-button" id="cart-button" title="Buka Form Order">
  <span>🛒</span>
</button>

<!-- MODAL DETAIL PRODUK -->
<div class="modal-backdrop" id="product-modal">
  <div class="modal">
    <button class="modal-close" type="button" data-close-modal>&times;</button>
    <img src="" alt="" class="modal-img" id="modal-img">
    <div class="modal-title" id="modal-name"></div>
    <div class="modal-category" id="modal-category"></div>
    <div class="modal-price" id="modal-price"></div>

    <div class="modal-section-title">Notes</div>
    <div class="modal-text" id="modal-notes"></div>

    <div class="modal-section-title">Vibe</div>
    <div class="modal-text" id="modal-vibe"></div>

    <div class="modal-section-title">Performa</div>
    <div class="modal-text" id="modal-strength"></div>
  </div>
</div>

<!-- MODAL KERANJANG / FORM ORDER -->
<div class="cart-modal-backdrop" id="cart-modal">
  <div class="cart-modal">
    <button class="cart-modal-close" type="button" data-close-cart>&times;</button>
    <div class="cart-modal-title">Form Order</div>
    <div class="cart-modal-sub">
      Pilih parfum, isi data, lalu kirim. Order tersimpan di sistem & stok otomatis berkurang.
    </div>

    <form action="order.php" method="POST">
      <label for="product_id">Pilih Parfum</label>
      <select name="product_id" id="product_id" required>
        <option value="">-- pilih parfum --</option>
        <?php
          $prod = $conn->query("SELECT * FROM products ORDER BY name ASC");
          while ($p = $prod->fetch_assoc()):
            $stok = (int)$p['stock'];
            $label = $stok == 0 ? ' (HABIS)' : ' (stok: '.$stok.')';
        ?>
          <option value="<?= $p['id'] ?>" <?= $stok==0 ? 'disabled' : '' ?>>
            <?= htmlspecialchars($p['name']).$label ?>
          </option>
        <?php endwhile; ?>
      </select>

      <label for="qty">Jumlah</label>
      <input type="number" name="qty" id="qty" min="1" value="1" required>

      <label for="customer_name">Nama Lengkap</label>
      <input type="text" name="customer_name" id="customer_name" placeholder="Contoh: Rani Putri" required>

      <label for="phone">Nomor WhatsApp</label>
      <input type="tel" name="phone" id="phone" placeholder="08xxxxxxxxxx" required>

      <label for="address">Alamat / Detail Pengiriman</label>
      <textarea name="address" id="address" placeholder="Alamat lengkap, patokan, jam kirim, dll." required></textarea>

      <button type="submit">Kirim Order</button>
      <p class="hint">
        *Konfirmasi pembayaran &amp; pengiriman masih dilakukan manual lewat WhatsApp / chat.
      </p>
    </form>
  </div>
</div>

<footer>
  © <?= date('Y') ?> Glacier Scent · Mini sistem parfum dengan PHP &amp; MySQL
</footer>

<script>
// MODAL DETAIL PRODUK
const modal       = document.getElementById('product-modal');
const modalImg    = document.getElementById('modal-img');
const modalName   = document.getElementById('modal-name');
const modalCat    = document.getElementById('modal-category');
const modalPrice  = document.getElementById('modal-price');
const modalNotes  = document.getElementById('modal-notes');
const modalVibe   = document.getElementById('modal-vibe');
const modalStr    = document.getElementById('modal-strength');

function openModalFromButton(btn) {
  modalImg.src      = btn.dataset.img;
  modalImg.alt      = btn.dataset.name;
  modalName.textContent  = btn.dataset.name;
  modalCat.textContent   = btn.dataset.category;
  modalPrice.textContent = btn.dataset.price;
  modalNotes.textContent = btn.dataset.notes;
  modalVibe.textContent  = btn.dataset.vibe;
  modalStr.textContent   = btn.dataset.strength;
  modal.classList.add('show');
}

function closeModal() {
  modal.classList.remove('show');
}

document.querySelectorAll('.product-detail-trigger').forEach(btn => {
  btn.addEventListener('click', () => openModalFromButton(btn));
});

document.querySelectorAll('[data-close-modal]').forEach(el => {
  el.addEventListener('click', closeModal);
});

modal.addEventListener('click', (e) => {
  if (e.target === modal) closeModal();
});

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeModal();
    closeCartModal();
  }
});

// CART MODAL
const cartBtn   = document.getElementById('cart-button');
const cartModal = document.getElementById('cart-modal');

function openCartModal() {
  cartModal.classList.add('show');
}

function closeCartModal() {
  cartModal.classList.remove('show');
}

cartBtn.addEventListener('click', openCartModal);
document.querySelectorAll('[data-close-cart]').forEach(el => {
  el.addEventListener('click', closeCartModal);
});

cartModal.addEventListener('click', (e) => {
  if (e.target === cartModal) closeCartModal();
});
</script>

</body>
</html>