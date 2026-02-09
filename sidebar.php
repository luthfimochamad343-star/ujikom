<div class="sidebar p-3">
    <h3 class="text-center py-3">PerpusKu</h3>
    <hr>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-primary active' : '' ?>">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="data_buku.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'data_buku.php' ? 'bg-primary active' : '' ?>">
                <i class="fas fa-book me-2"></i> Data Buku
            </a>
        </li>
        <li class="nav-item">
            <a href="data_anggota.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'data_anggota.php' ? 'bg-primary active' : '' ?>">
                <i class="fas fa-users me-2"></i> Data Anggota
            </a>
        </li>
        <li class="nav-item">
            <a href="transaksi.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'bg-primary active' : '' ?>">
                <i class="fas fa-exchange-alt me-2"></i> Transaksi
            </a>
        </li>
        <li class="nav-item">
            <a href="ulasan.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'ulasan.php' ? 'bg-primary active' : '' ?>">
                <i class="fas fa-star me-2"></i> Ulasan Buku
            </a>
        </li>
        <hr>
        <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </li>
    </ul>
</div>