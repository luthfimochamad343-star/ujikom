<?php
session_start();
// Sesuaikan path ini dengan letak file Koneksi.php kamu
include 'db/Koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// --- PROSES TAMBAH ANGGOTA ---
if (isset($_POST['tambah'])) {
    $nama           = $_POST['nama'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $alamat         = $_POST['alamat'];
    $no_telepon     = $_POST['no_telepon'];
    $email          = $_POST['email'];

    $query = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telepon, email) 
              VALUES ('$nama', '$jenis_kelamin', '$alamat', '$no_telepon', '$email')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: data_anggota.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// --- PROSES HAPUS ANGGOTA ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM anggota WHERE id=$id");
    header("Location: data_anggota.php");
}

// Ambil data anggota
$ambil_data = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Anggota | PerpusKu</title>
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

    <div class="sidebar p-3 text-white">
        <h3 class="text-center py-3">PerpusKu</h3>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="dashboard.php" class="nav-link text-white"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="data_buku.php" class="nav-link text-white"><i class="fas fa-book me-2"></i> Data Buku</a></li>
            <li class="nav-item"><a href="data_anggota.php" class="nav-link text-white bg-primary active"><i class="fas fa-users me-2"></i> Data Anggota</a></li>
            <li class="nav-item"><a href="transaksi.php" class="nav-link text-white"><i class="fas fa-exchange-alt me-2"></i> Transaksi</a></li>
            <li class="nav-item mt-5"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="fas fa-users me-2 text-primary"></i> Manajemen Anggota</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-1"></i> Tambah Anggota
            </button>
        </div>

        <div class="card shadow border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>No. Telp</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1;
                        while ($row = mysqli_fetch_assoc($ambil_data)) : ?>
                            <tr>
                                <td><?= $n++; ?></td>
                                <td class="text-start"><?= $row['nama']; ?></td>
                                <td><?= $row['jenis_kelamin']; ?></td>
                                <td><?= $row['no_telepon']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td>
                                    <a href="data_anggota.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content text-dark">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Anggota Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>