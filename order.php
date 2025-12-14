<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$customer_name = trim($_POST['customer_name'] ?? '');
$phone         = trim($_POST['phone'] ?? '');
$address       = trim($_POST['address'] ?? '');
$product_id    = (int)($_POST['product_id'] ?? 0);
$qty           = (int)($_POST['qty'] ?? 0);

$errors = [];

if ($customer_name === '') $errors[] = "Nama tidak boleh kosong.";
if ($phone === '')         $errors[] = "Nomor WhatsApp tidak boleh kosong.";
if ($address === '')       $errors[] = "Alamat / detail pengiriman tidak boleh kosong.";
if ($product_id <= 0)      $errors[] = "Produk tidak valid.";
if ($qty <= 0)             $errors[] = "Jumlah minimal 1.";

// ============= TEMA COKLAT EMAS UNTUK ERROR VALIDASI =============
if ($errors) { ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Order Gagal</title>
<style>
    body {
        background: radial-gradient(circle at top, #3a2718, #281E18 70%);
        color: #FDFCD4;
        font-family: system-ui, sans-serif;
        padding: 20px;
    }
    .card {
        max-width: 520px;
        margin: 40px auto;
        background: linear-gradient(145deg, #3a2718, #281E18);
        border-radius: 18px;
        border: 1px solid rgba(199,142,58,0.45);
        padding: 18px 20px 22px;
        box-shadow: 0 22px 50px rgba(40,30,24,0.8);
    }
    h1 { font-size: 1.3rem; margin-bottom: 10px; }
    ul { margin-left: 20px; color: #E3B76A; }
    a.button {
        display: inline-block; margin-top: 12px; padding: 8px 15px;
        border-radius: 999px; background: #C78E3A; color: #281E18;
        text-decoration: none; font-weight: 600;
    }
    a.button:hover { background: #E3B76A; }
</style>
</head>
<body>
<div class="card">
    <h1>Order gagal diproses</h1>
    <p>Beberapa data belum lengkap:</p>
    <ul>
    <?php foreach ($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
    <?php endforeach; ?>
    </ul>
    <a href="index.php" class="button">Kembali ke halaman toko</a>
</div>
</body>
</html>
<?php exit; }

// ============= AMBIL PRODUK =============
$stmt = $conn->prepare("SELECT id, name, price, stock FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

// ============= CEK STOK / PRODUK TIDAK DITEMUKAN =============
if (!$product) {
    $msg = "Produk tidak ditemukan.";
} elseif ($product['stock'] <= 0) {
    $msg = "Stok untuk produk ini sudah habis.";
} elseif ($qty > $product['stock']) {
    $msg = "Stok tidak mencukupi. Stok tersedia: " . $product['stock'];
}

// ============= TAMPILKAN PESAN ERROR DENGAN TEMA BARU =============
if (isset($msg)) { ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Order Gagal</title>
<style>
    body {
        background: radial-gradient(circle at top, #3a2718, #281E18 70%);
        color: #FDFCD4;
        font-family: system-ui, sans-serif;
        padding: 20px;
    }
    .card {
        max-width: 520px;
        margin: 40px auto;
        background: linear-gradient(145deg, #3a2718, #281E18);
        border-radius: 18px;
        border: 1px solid rgba(199,142,58,0.45);
        padding: 18px 20px 22px;
        box-shadow: 0 22px 50px rgba(40,30,24,0.8);
    }
    h1 { font-size: 1.3rem; margin-bottom: 10px; }
    p { color: #E3B76A; }
    a.button {
        display: inline-block; margin-top: 14px; padding: 8px 15px;
        border-radius: 999px; background: #C78E3A; color: #281E18;
        text-decoration: none; font-weight: 600;
    }
    a.button:hover { background: #E3B76A; }
</style>
</head>
<body>
<div class="card">
    <h1>Order gagal diproses</h1>
    <p><?= htmlspecialchars($msg) ?></p>
    <a href="index.php" class="button">Kembali ke halaman toko</a>
</div>
</body>
</html>
<?php
exit;
}

$total_price = $product['price'] * $qty;

// ============= SIMPAN ORDER + UPDATE STOK =============
$conn->begin_transaction();
try {
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, address, product_id, qty, total_price)
                            VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("sssiii", $customer_name, $phone, $address, $product_id, $qty, $total_price);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $stmt2->bind_param("ii", $qty, $product_id);
    $stmt2->execute();
    $stmt2->close();

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Order Gagal</title>
<style>
    body {
        background: radial-gradient(circle at top, #3a2718, #281E18 70%);
        color:#FDFCD4;
        font-family: system-ui, sans-serif;
        padding:20px;
    }
    .card {
        max-width:520px; margin:40px auto;
        background:linear-gradient(145deg,#3a2718,#281E18);
        border-radius:18px; border:1px solid rgba(199,142,58,0.45);
        padding:20px 20px 22px;
        box-shadow:0 22px 50px rgba(40,30,24,0.8);
    }
    h1 { color:#FDFCD4; margin-bottom:10px; }
    p { color:#E3B76A; }
    a.button {
        display:inline-block; padding:8px 15px; margin-top:14px;
        border-radius:999px; background:#C78E3A; color:#281E18;
        text-decoration:none; font-weight:600;
    }
</style>
</head>
<body>
<div class="card">
    <h1>Terjadi kesalahan</h1>
    <p>Order gagal disimpan. Silakan coba lagi.</p>
    <a href="index.php" class="button">Kembali ke halaman toko</a>
</div>
</body>
</html>
<?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Order Berhasil</title>
<style>
    body {
        font-family: system-ui, sans-serif;
        background: radial-gradient(circle at top, #3a2718, #281E18 70%);
        color: #FDFCD4;
        padding: 20px;
    }
    .card {
        max-width: 520px;
        margin: 40px auto;
        background: linear-gradient(145deg, #3a2718, #281E18);
        border-radius: 18px;
        border: 1px solid rgba(199,142,58,0.45);
        padding: 20px 20px 22px;
        box-shadow: 0 22px 50px rgba(40,30,24,0.8);
    }
    h1 {
        font-size: 1.4rem;
        margin-bottom: 6px;
        color: #FDFCD4;
    }
    .subtitle {
        font-size: 0.85rem;
        color: #E3B76A;
        margin-bottom: 14px;
    }
    .summary {
        font-size: 0.9rem;
        margin-bottom: 10px;
        line-height: 1.5;
    }
    .summary strong { color: #FDFCD4; }
    .total {
        margin-top: 8px;
        font-weight: 600;
        color: #C78E3A;
    }
    a.button {
        display: inline-block;
        margin-top: 14px;
        padding: 8px 15px;
        border-radius: 999px;
        background: #C78E3A;
        color: #281E18;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(199,142,58,0.4);
    }
    a.button:hover {
        background: #E3B76A;
    }
</style>
</head>
<body>
<div class="card">
    <h1>Order berhasil dibuat 🎉</h1>
    <div class="subtitle">
        Data order kamu sudah tersimpan di sistem. Silakan lakukan konfirmasi pembayaran / pengiriman.
    </div>
    <div class="summary">
        <div><strong>Nama:</strong> <?= htmlspecialchars($customer_name) ?></div>
        <div><strong>Nomor WA:</strong> <?= htmlspecialchars($phone) ?></div>
        <div><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($address)) ?></div>
        <hr style="border:none; border-top:1px solid rgba(199,142,58,0.4); margin:10px 0;">
        <div><strong>Produk:</strong> <?= htmlspecialchars($product['name']) ?></div>
        <div><strong>Jumlah:</strong> <?= $qty ?> pcs</div>
        <div class="total">Total: Rp <?= number_format($total_price, 0, ',', '.') ?></div>
    </div>
    <a href="index.php" class="button">Kembali ke halaman toko</a>
</div>
</body>
</html>