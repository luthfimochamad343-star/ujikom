<?php
session_start();
include 'db/Koneksi.php'; // Pastikan file ini ada

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// --- PROSES SIMPAN TRANSAKSI (PINJAM) ---
if (isset($_POST['pinjam'])) {
    $id_buku      = $_POST['id_buku'];
    $id_anggota   = $_POST['id_anggota'];
    $tgl_pinjam   = $_POST['tgl_pinjam'];
    $tgl_kembali  = $_POST['tgl_kembali'];

    // PERBAIKAN: Gunakan variabel $koneksi (sesuai file Koneksi.php)
    $query = "INSERT INTO transaksi (id_buku, id_anggota, tgl_pinjam, tgl_kembali, status) 
              VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', '$tgl_kembali', 'Pinjam')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Peminjaman Berhasil!'); window.location='transaksi.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

// --- PROSES PENGEMBALIAN BUKU ---
if (isset($_GET['kembali'])) {
    $id = $_GET['kembali'];
    mysqli_query($koneksi, "UPDATE transaksi SET status='Kembali' WHERE id=$id");
    header("Location: transaksi.php");
}

// --- PROSES HAPUS TRANSAKSI ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id=$id");
    header("Location: transaksi.php");
}

// Ambil data transaksi dengan JOIN
$query_transaksi = mysqli_query($koneksi, "SELECT transaksi.*, buku.judul_buku, anggota.nama 
                                        FROM transaksi 
                                        JOIN buku ON transaksi.id_buku = buku.id 
                                        JOIN anggota ON transaksi.id_anggota = anggota.id 
                                        ORDER BY transaksi.id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi Peminjaman | PerpusKu</title>
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

        .badge {
            font-size: 0.85rem;
        }
    </style>
</head>

<body class="bg-light text-dark">

    <div class="sidebar p-3">
        <h3 class="text-center py-3">PerpusKu</h3>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="dashboard.php" class="nav-link text-white"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="data_buku.php" class="nav-link text-white"><i class="fas fa-book me-2"></i> Data Buku</a></li>
            <li class="nav-item"><a href="data_anggota.php" class="nav-link text-white"><i class="fas fa-users me-2"></i> Data Anggota</a></li>
            <li class="nav-item"><a href="transaksi.php" class="nav-link text-white active bg-primary shadow-sm"><i class="fas fa-exchange-alt me-2"></i> Transaksi</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><i class="fas fa-exchange-alt me-2 text-primary"></i> Sirkulasi Peminjaman</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                <i class="fas fa-plus me-1"></i> Tambah Pinjaman
            </button>
        </div>

        <div class="card shadow border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        while ($row = mysqli_fetch_assoc($query_transaksi)) :
                        ?>
                            <tr>
                                <td><?= $n++; ?></td>
                                <td class="text-start"><?= $row['nama']; ?></td>
                                <td class="text-start"><?= $row['judul_buku']; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tgl_pinjam'])); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tgl_kembali'])); ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Pinjam') : ?>
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    <?php else : ?>
                                        <span class="badge bg-success">Kembali</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'Pinjam') : ?>
                                        <a href="transaksi.php?kembali=<?= $row['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Proses pengembalian buku?')">Kembali</a>
                                    <?php endif; ?>
                                    <a href="transaksi.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPinjam" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5>Tambah Peminjaman</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Pilih Anggota</label>
                            <select name="id_anggota" class="form-select" required>
                                <option value="">-- Pilih Anggota --</option>
                                <?php
                                $ang = mysqli_query($koneksi, "SELECT * FROM anggota");
                                while ($a = mysqli_fetch_assoc($ang)) :
                                ?>
                                    <option value="<?= $a['id']; ?>"><?= $a['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Pilih Buku</label>
                            <select name="id_buku" class="form-select" required>
                                <option value="">-- Pilih Buku --</option>
                                <?php
                                $buk = mysqli_query($koneksi, "SELECT * FROM buku");
                                while ($b = mysqli_fetch_assoc($buk)) :
                                ?>
                                    <option value="<?= $b['id']; ?>"><?= $b['judul_buku']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Tgl Pinjam</label>
                                <input type="date" name="tgl_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Tgl Kembali</label>
                                <input type="date" name="tgl_kembali" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="pinjam" class="btn btn-primary">Simpan Pinjaman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>