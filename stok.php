<?php
require 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// cek login admin
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// handle update stok
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
    $id   = (int)($_POST['id'] ?? 0);
    $stok = (int)($_POST['stock'] ?? 0);

    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $stok, $id);
        if ($stmt->execute()) {
            $msg = "Stok berhasil diperbarui.";
        } else {
            $msg = "Gagal update stok.";
        }
        $stmt->close();
    }
}

// ambil data produk
$products = $conn->query("SELECT * FROM products ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Stok - Glacier Scent</title>

<style>
:root {
  --bg-main: #281E18;
  --surface: #572D0C;
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
  z-index: 10;
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

.brand-sub {
  font-size: 0.75rem;
  color: var(--text-muted);
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
  padding: 22px 20px 32px;
}

.admin-wrapper {
  max-width: 1000px;
  margin: 0 auto;
}

.panel {
  background: radial-gradient(circle at top, #3a2718, #281E18 70%);
  border-radius: 20px;
  border: 1px solid rgba(199, 142, 58, 0.6);
  padding: 18px 20px 20px;
  box-shadow: 0 22px 55px rgba(0,0,0,0.9);
}

.panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.panel-title {
  font-size: 1.1rem;
}

.panel-sub {
  font-size: 0.8rem;
  color: var(--text-muted);
}

.msg {
  margin-bottom: 10px;
  font-size: 0.8rem;
  color: var(--safe);
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-size: 0.85rem;
}

th, td {
  padding: 8px 6px;
  border-bottom: 1px solid rgba(199, 142, 58, 0.3);
}

th {
  text-align: left;
  font-size: 0.78rem;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: var(--text-muted);
}

tbody tr:nth-child(odd) {
  background: rgba(20, 13, 7, 0.7);
}

tbody tr:nth-child(even) {
  background: rgba(20, 13, 7, 0.5);
}

input[type="number"] {
  width: 70px;
  padding: 4px;
  border-radius: 8px;
  border: 1px solid rgba(199, 142, 58, 0.6);
  background: rgba(12, 8, 5, 0.95);
  color: var(--cream);
  font-size: 0.8rem;
}

.btn {
  padding: 5px 10px;
  border-radius: 999px;
  border: none;
  font-size: 0.78rem;
  cursor: pointer;
}

.btn-primary {
  background: linear-gradient(135deg, var(--gold-soft), var(--gold));
  color: #281E18;
  box-shadow: 0 10px 25px rgba(199, 142, 58, 0.8);
}

.btn-primary:hover {
  filter: brightness(1.03);
}

.tag-stok {
  font-size: 0.78rem;
  padding: 3px 8px;
  border-radius: 999px;
}

.tag-stok.habis { background: rgba(248, 113, 113, 0.25); color: var(--danger); }
.tag-stok.tipis { background: rgba(253, 224, 71, 0.25); color: #FDE68A; }
.tag-stok.aman  { background: rgba(22, 163, 74, 0.25); color: var(--safe); }

footer {
  margin-top: 22px;
  border-top: 1px solid rgba(199, 142, 58, 0.5);
  padding: 10px 0 14px;
  font-size: 0.78rem;
  text-align: center;
  color: var(--text-muted);
  background: #281E18;
}
</style>
</head>
<body>

<header>
  <div class="brand">
    <div class="brand-logo"></div>
    <div>
      <div class="brand-name">GLACIER SCENT</div>
      <div class="brand-sub">Admin Panel</div>
    </div>
  </div>
  <nav class="nav-links">
    <a href="index.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<main>
  <div class="admin-wrapper">
    <section class="panel">
      <div class="panel-header">
        <div>
          <div class="panel-title">Kelola Stok Parfum</div>
          <div class="panel-sub">Update stok produk langsung dari panel ini.</div>
        </div>
        <div style="font-size:0.8rem;color:var(--text-muted);">
          Admin: <strong><?= htmlspecialchars($_SESSION['admin_username'] ?? '-') ?></strong>
        </div>
      </div>

      <?php if ($msg): ?>
        <div class="msg"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Gender</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Update</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $products->fetch_assoc()):
            $stok = (int)$row['stock'];
            if ($stok == 0) { $tagClass = "habis"; $tagLabel = "Habis"; }
            elseif ($stok <= 3) { $tagClass = "tipis"; $tagLabel = "Tipis"; }
            else { $tagClass = "aman"; $tagLabel = "Aman"; }
          ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['gender']) ?></td>
            <td><?= "Rp " . number_format($row['price'], 0, ',', '.') ?></td>
            <td>
              <span class="tag-stok <?= $tagClass ?>"><?= $tagLabel ?></span>
              (<?= $stok ?> pcs)
            </td>
            <td>
              <form method="POST" style="display:flex;gap:6px;align-items:center;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="number" name="stock" min="0" value="<?= $stok ?>">
                <button type="submit" name="update_stock" class="btn btn-primary">Simpan</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </section>
  </div>
</main>

<footer>
  © <?= date('Y') ?> Glacier Scent · Admin Panel
</footer>

</body>
</html>
