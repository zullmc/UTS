<?php
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Proses login saat form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Login sederhana (username: admin, password: 123)
    if ($username === 'admin' && $password === '123') {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'Dosen';
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Form Login</h2>
    
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit">Login</button>
        <button type="reset">Batal</button>
    </form>
</div>

</body>
</html>
</body>
</html>
