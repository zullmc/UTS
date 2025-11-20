<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<link rel="stylesheet" href="style.css">

<div class="dashboard-box">
    <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
    <p>Role: <?php echo $_SESSION['role']; ?></p>

    <a href="logout.php">
        <button>Logout</button>
    </a>
</div>

</body>
</html>
