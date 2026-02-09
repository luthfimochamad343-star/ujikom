<?php
session_start();
include 'db/Koneksi.php';

// Cek Login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// --- AMBIL DATA STATISTIK ---
// Menggunakan @ untuk meredam error sementara agar navbar tetap muncul jika query gagal
$total_buku      = @mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM buku")) ?: 0;
$total_anggota   = @mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users")) ?: 0; // Ganti anggota ke users
$total_transaksi = @mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi")) ?: 0;

// Cek ulasan
$q_ulasan = @mysqli_query($koneksi, "SELECT * FROM ulasan");
$total_ulasan = ($q_ulasan) ? mysqli_num_rows($q_ulasan) : 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerpusKu | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
        }

        .sidebar {
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }

        .nav-link {
            color: #bdc3c7;
            margin-bottom: 10px;
            border-radius: 8px;
            padding: 12px;
            transition: 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background: #3498db;
        }

        .card-stat {
            border: none;
            border-radius: 12px;
            color: white;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="sidebar p-3">
        <h4 class="text-center py-3 fw-bold"><i class="fas fa-book-reader me-2"></i>PerpusKu</h4>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="dashboard.php" class="nav-link active"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="data_buku.php" class="nav-link"><i class="fas fa-book me-2"></i> Data Buku</a></li>
            <li class="nav-item"><a href="data_anggota.php" class="nav-link"><i class="fas fa-users me-2"></i> Data Anggota</a></li>
            <li class="nav-item"><a href="transaksi.php" class="nav-link"><i class="fas fa-exchange-alt me-2"></i> Transaksi</a></li>
            <li class="nav-item"><a href="ulasan.php" class="nav-link"><i class="fas fa-star me-2"></i> Ulasan</a></li>
        </ul>
        <hr>
        <a href="logout.php" class="btn btn-danger w-100 mt-auto"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Selamat Datang, <?= $_SESSION['user']; ?>!</h4>
            <div class="text-muted"><?= date('l, d F Y'); ?></div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card card-stat bg-primary">
                    <small>Total Buku</small>
                    <h2 class="fw-bold mb-0"><?= $total_buku; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat bg-success">
                    <small>Total Anggota</small>
                    <h2 class="fw-bold mb-0"><?= $total_anggota; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat bg-info text-white">
                    <small>Total Transaksi</small>
                    <h2 class="fw-bold mb-0"><?= $total_transaksi; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat bg-warning text-dark">
                    <small>Ulasan Masuk</small>
                    <h2 class="fw-bold mb-0"><?= $total_ulasan; ?></h2>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm">
            <i class="fas fa-info-circle me-2"></i> Gunakan menu di samping untuk mengelola data perpustakaan Anda.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>