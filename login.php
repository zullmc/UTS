<?php
session_start();

// jika sudah login, arahkan ke dashboard
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // data login statis sesuai soal
    $valid_username = 'admin';
    $valid_password = '1234';

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === $valid_username && $password === $valid_password) {
        // set session dan redirect
        $_SESSION['username'] = $username;
        // optional: role
        $_SESSION['role'] = 'Dosen';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - POLGAN MART</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Bootstrap CDN untuk styling cepat -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f7f8fb; }
    .card { max-width:420px; margin:60px auto; padding:20px; border-radius:12px; }
    .brand { text-align:center; font-weight:700; color:#2b6ef6; margin-bottom:12px; }
  </style>
</head>
<body>
  <div class="card shadow-sm">
    <div class="brand">POLGAN MART</div>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" type="text" class="form-control" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <div class="d-grid gap-2">
        <button class="btn btn-primary" type="submit">Login</button>
        <a class="btn btn-outline-secondary" href="#" onclick="document.querySelector('input[name=password]').value=''; return false;">Batal</a>
      </div>
    </form>
    <p class="text-center mt-3 text-muted">© 2025 POLGAN MART</p>
  </div>
</body>
</html>
