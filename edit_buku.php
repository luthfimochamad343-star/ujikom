<?php
session_start();
include 'db/Koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 1. Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = $id");
$buku = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$buku) {
    header("Location: data_buku.php");
    exit;
}

// 2. Proses Update Data
if (isset($_POST['update_buku'])) {
    $judul    = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $stok     = $_POST['stok'];
    $kategori = $_POST['id_kategori'];

    $update = "UPDATE buku SET 
                judul_buku = '$judul', 
                penulis = '$penulis', 
                penerbit = '$penerbit', 
                stok = '$stok', 
                id_kategori = '$kategori' 
               WHERE id = $id";

    if (mysqli_query($koneksi, $update)) {
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location='data_buku.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Buku | PerpusKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            width: 260px;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
    </style>
</head>

<body class="bg-light">

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card shadow border-0 col-md-8 mx-auto">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="fas fa-edit me-2"></i> Edit Data Buku
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" value="<?= $buku['judul_buku']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="<?= $buku['penulis']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control" value="<?= $buku['penerbit']; ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $buku['stok']; ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" class="form-select">
                                <?php
                                $kats = mysqli_query($koneksi, "SELECT * FROM kategori");
                                while ($k = mysqli_fetch_assoc($kats)) :
                                ?>
                                    <option value="<?= $k['id_kategori']; ?>" <?= ($k['id_kategori'] == $buku['id_kategori']) ? 'selected' : ''; ?>>
                                        <?= $k['nama_kategori']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="data_buku.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="update_buku" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>