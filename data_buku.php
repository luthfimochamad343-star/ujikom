<?php
session_start();
include 'db/Koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// --- PROSES TAMBAH BUKU ---
if (isset($_POST['tambah_buku'])) {
    $judul    = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $stok     = $_POST['stok'];
    $kategori = $_POST['id_kategori'];

    $query = "INSERT INTO buku (id_kategori, judul_buku, penulis, penerbit, stok) 
              VALUES ('$kategori', '$judul', '$penulis', '$penerbit', '$stok')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: data_buku.php");
    }
}

// --- PROSES HAPUS BUKU ---
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM buku WHERE id = $id_hapus");
    header("Location: data_buku.php");
}

// --- AMBIL SEMUA DATA UNTUK TABEL (Minta Array) ---
$result = mysqli_query($koneksi, "SELECT buku.*, kategori.nama_kategori 
                                  FROM buku 
                                  LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori 
                                  ORDER BY buku.id DESC");
$semua_buku = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Buku | PerpusKu</title>
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

<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between mb-4">
            <h4><i class="fas fa-book me-2"></i> Kelola Data Buku</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Buku</button>
        </div>

        <div class="card shadow border-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($semua_buku as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><strong><?= $row['judul_buku']; ?></strong></td>
                            <td><?= $row['penulis']; ?></td>
                            <td><?= $row['penerbit']; ?></td>
                            <td class="text-center"><?= $row['stok']; ?></td>
                            <td class="text-center">
                                <a href="edit_buku.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="data_buku.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Buku</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="judul" class="form-control mb-2" placeholder="Judul" required>
                    <input type="text" name="penulis" class="form-control mb-2" placeholder="Penulis" required>
                    <input type="text" name="penerbit" class="form-control mb-2" placeholder="Penerbit" required>
                    <input type="number" name="stok" class="form-control mb-2" placeholder="Stok" required>
                    <select name="id_kategori" class="form-select">
                        <?php
                        $kats = mysqli_query($koneksi, "SELECT * FROM kategori");
                        while ($k = mysqli_fetch_assoc($kats)) : ?>
                            <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah_buku" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>