<?php
session_start();

// pastikan login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

// --- Data produk (commit 5) ---
$kode_barang = ['K001','K002','K003','K004','K005'];
$nama_barang = ['Chitato','Teh Pucuk','Sprite','Sukro','Indomie'];
$harga_barang = [3000, 5000, 4000, 1000, 7000]; // dalam Rupiah (integer)

// --- Logika penjualan random (commit 6) ---
// kita akan memilih acak apakah tiap barang dibeli (0/1) atau jumlah acak
$beli = [];   // apakah dibeli (true/false)
$jumlah = []; // jumlah pembelian per item
$total = [];  // total per item
$grandtotal = 0;

// Atur seed agar hasil acak bervariasi (opsional)
// srand((int)microtime(true) * 1000000);

for ($i = 0; $i < count($kode_barang); $i++) {
    // acak apakah dibeli (50% chance)
    $isBought = (rand(0,1) === 1);
    if ($isBought) {
        // jumlah acak antara 1 - 6 (sesuaikan)
        $q = rand(1,6);
    } else {
        $q = 0;
    }
    $beli[$i] = $isBought;
    $jumlah[$i] = $q;
    $total[$i] = $harga_barang[$i] * $q;
    $grandtotal += $total[$i];
}

// --- Hitung diskon sesuai ketentuan (commit 9) ---
// jika total < 50.000 -> diskon 5%
// antara 50.000 - 100.000 -> diskon 10%
// di atas 100.000 -> diskon 15%
$diskon = 0.0;
if ($grandtotal < 50000) {
    $diskon = 0.05;
} elseif ($grandtotal <= 100000) {
    $diskon = 0.10;
} else {
    $diskon = 0.15;
}
$diskon_rp = round($grandtotal * $diskon);
$total_bayar = $grandtotal - $diskon_rp;

// helper format rupiah
function rp($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard - POLGAN MART</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f1f3f6; padding:20px; }
    header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
    .brand { font-weight:700; color:#2b6ef6; }
    .card-area { background:white; padding:20px; border-radius:10px; box-shadow: 0 2px 6px rgba(0,0,0,0.04); }
    table th, table td { vertical-align:middle; }
  </style>
</head>
<body>
  <header>
    <div>
      <div class="brand">--POLGAN MART--</div>
      <small class="text-muted">Sistem Penjualan Sederhana</small>
    </div>
    <div class="text-end">
      <div>Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['username']); ?>!</strong></div>
      <div class="text-muted">Role: <?php echo htmlspecialchars($_SESSION['role']); ?></div>
      <a href="logout.php" class="btn btn-sm btn-outline-danger mt-2">Logout</a>
    </div>
  </header>

  <div class="card-area">
    <h5>Daftar Pembelian (acak)</h5>
    <p class="text-muted">Daftar pembelian dibuat secara acak tiap reload halaman.</p>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i=0; $i < count($kode_barang); $i++): ?>
            <tr>
              <td><?php echo $kode_barang[$i]; ?></td>
              <td><?php echo htmlspecialchars($nama_barang[$i]); ?></td>
              <td><?php echo rp($harga_barang[$i]); ?></td>
              <td><?php echo $jumlah[$i]; ?></td>
              <td><?php echo rp($total[$i]); ?></td>
            </tr>
          <?php endfor; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" class="text-end">Total Belanja</th>
            <th><?php echo rp($grandtotal); ?></th>
          </tr>
          <tr>
            <th colspan="4" class="text-end">Diskon (<?php echo ($diskon*100) . '%'; ?>)</th>
            <th><?php echo rp($diskon_rp); ?></th>
          </tr>
          <tr>
            <th colspan="4" class="text-end">Total Bayar</th>
            <th><?php echo '<strong>' . rp($total_bayar) . '</strong>'; ?></th>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="mt-3">
      <button class="btn btn-secondary" onclick="location.reload();">Generate Ulang (acak)</button>
      <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
  </div>
</body>
</html>
