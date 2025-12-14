<?php
require 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kalau sudah login, langsung lempar ke stok
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: stok.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username !== '' && $password !== '') {
        // password di-db disimpan pakai SHA2(…,256)
        $stmt = $conn->prepare("
            SELECT * FROM users 
            WHERE username = ? 
              AND password = SHA2(?, 256)
        ");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: stok.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }

        $stmt->close();
    } else {
        $error = 'Harap isi username dan password.';
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Admin - Glacier Scent</title>

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
}

/* RESET */
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: radial-gradient(circle at top, #281E18, #281E18 65%);
  color: var(--text-main);
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* CARD LOGIN */
.login-wrapper {
  width: 100%;
  max-width: 380px;
  padding: 20px 18px;
}

.login-card {
  background: radial-gradient(circle at top, #3a2718, #281E18 70%);
  border-radius: 20px;
  border: 1px solid rgba(199, 142, 58, 0.6);
  padding: 20px 22px 22px;
  box-shadow: 0 22px 55px rgba(0,0,0,0.9);
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
}

.brand-logo {
  width: 32px;
  height: 32px;
  border-radius: 999px;
  background: radial-gradient(circle at 30% 10%, #FDFCD4, #E3B76A 45%, #572D0C 85%);
  box-shadow: 0 0 20px rgba(227, 183, 106, 0.8);
}

.brand-text {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.brand-name {
  font-size: 0.9rem;
  font-weight: 600;
  letter-spacing: 0.14em;
}

.brand-sub {
  font-size: 0.78rem;
  color: var(--text-muted);
}

.login-title {
  font-size: 1.1rem;
  margin-bottom: 4px;
}

.login-subtitle {
  font-size: 0.82rem;
  color: var(--text-muted);
  margin-bottom: 14px;
}

label {
  font-size: 0.8rem;
  display: block;
  margin-bottom: 4px;
  color: var(--text-muted);
  margin-top: 10px;
}

input {
  width: 100%;
  padding: 8px;
  border-radius: 10px;
  border: 1px solid rgba(199, 142, 58, 0.6);
  background: rgba(20, 13, 7, 0.95);
  color: var(--cream);
  font-size: 0.85rem;
}

input:focus {
  outline: none;
  border-color: var(--gold-soft);
  box-shadow: 0 0 0 1px rgba(227, 183, 106, 0.6);
}

button[type="submit"] {
  margin-top: 16px;
  width: 100%;
  padding: 9px;
  border-radius: 999px;
  border: none;
  background: linear-gradient(135deg, var(--gold-soft), var(--gold));
  color: #281E18;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 18px 40px rgba(199, 142, 58, 0.9);
}

button[type="submit"]:hover {
  filter: brightness(1.03);
}

.error {
  margin-top: 10px;
  font-size: 0.78rem;
  color: #FCA5A5;
}

.hint {
  margin-top: 12px;
  font-size: 0.75rem;
  color: var(--text-muted);
}
</style>
</head>
<body>

<div class="login-wrapper">
  <div class="login-card">
    <div class="brand">
      <div class="brand-logo"></div>
      <div class="brand-text">
        <div class="brand-name">GLACIER SCENT</div>
        <div class="brand-sub">Admin Panel</div>
      </div>
    </div>

    <div class="login-title">Login Admin</div>
    <div class="login-subtitle">Masuk untuk mengelola stok parfum &amp; data order.</div>

    <form method="POST">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Masuk</button>

      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="hint">
        *Credensial admin disimpan di tabel <code>users</code> pada database.
      </div>
    </form>
  </div>
</div>

</body>
</html>
