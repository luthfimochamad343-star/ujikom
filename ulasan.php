<?php
session_start();
include 'db/Koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// --- PROSES SIMPAN ULASAN ---
if (isset($_POST['kirim_ulasan'])) {
    $id_buku    = $_POST['id_buku'];
    $nama       = $_POST['nama_pengulas'];
    $isi_ulasan = $_POST['ulasan'];
    $rating     = $_POST['rating'];

    $query = "INSERT INTO ulasan (id_buku, nama_pengulas, ulasan, rating) 
              VALUES ('$id_buku', '$nama', '$isi_ulasan', '$rating')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Ulasan berhasil dikirim!'); window.location='ulasan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Ambil data ulasan (JOIN dengan tabel buku untuk dapat Judulnya)
$sql_ulasan = "SELECT ulasan.*, buku.judul_buku 
               FROM ulasan 
               JOIN buku ON ulasan.id_buku = buku.id 
               ORDER BY tgl_ulasan DESC";
$ambil_ulasan = mysqli_query($koneksi, $sql_ulasan);

// Ambil data buku untuk pilihan di Form
$data_buku = mysqli_query($koneksi, "SELECT id, judul_buku FROM buku");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ulasan Buku | PerpusKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .sidebar {
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            width: 250px;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .nav-link {
            color: #bdc3c7;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .nav-link.active {
            background: #3498db;
            color: white;
        }

        .star-rating {
            color: #f1c40f;
        }
    </style>
</head>

<body>

    <div class="sidebar p-3">
        <h3 class="text-center py-3 fw-bold">PerpusKu</h3>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="data_anggota.php" class="nav-link"><i class="fas fa-users me-2"></i> Data Anggota</a></li>
            <li class="nav-item"><a href="transaksi.php" class="nav-link"><i class="fas fa-exchange-alt me-2"></i> Transaksi</a></li>
            <li class="nav-item"><a href="ulasan.php" class="nav-link active"><i class="fas fa-star me-2"></i> Ulasan</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><i class="fas fa-comments me-2"></i>Ulasan Pengunjung</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUlasan">
                <i class="fas fa-pen me-1"></i> Tulis Ulasan
            </button>
        </div>

        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($ambil_ulasan)) : ?>
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold text-primary"><?= $row['judul_buku']; ?></h6>
                                <div class="star-rating small">
                                    <?php for ($i = 1; $i <= 5; $i++) echo ($i <= $row['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                                </div>
                            </div>
                            <p class="mb-1 text-dark">"<?= $row['ulasan']; ?>"</p>
                            <hr class="my-2">
                            <small class="text-muted">Oleh: <b><?= $row['nama_pengulas']; ?></b> | <?= date('d/m/Y', strtotime($row['tgl_ulasan'])); ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="modal fade" id="modalUlasan" tabindex="-1">
        <div class="modal-dialog text-dark">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5>Tambah Ulasan</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Pilih Buku</label>
                            <select name="id_buku" class="form-select" required>
                                <?php while ($b = mysqli_fetch_assoc($data_buku)) : ?>
                                    <option value="<?= $b['id']; ?>"><?= $b['judul_buku']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nama Anda</label>
                            <input type="text" name="nama_pengulas" class="form-control" placeholder="Nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label>Rating</label>
                            <select name="rating" class="form-select">
                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                <option value="3">⭐⭐⭐ (Biasa)</option>
                                <option value="2">⭐⭐ (Kurang)</option>
                                <option value="1">⭐ (Buruk)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Ulasan</label>
                            <textarea name="ulasan" class="form-control" rows="3" placeholder="Apa pendapatmu tentang buku ini?" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="kirim_ulasan" class="btn btn-primary w-100">Simpan Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>