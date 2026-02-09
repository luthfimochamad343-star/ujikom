<?php
// Pengaturan Database
$host     = "localhost";
$user     = "root";      // Default di HP biasanya root
$password = "";          // Default di HP biasanya kosong
$database = "Db_perpus";

// Membuat Jembatan Koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Jika localhost gagal (beberapa HP butuh IP internal), coba pakai 127.0.0.1
if (!$koneksi) {
    $koneksi = mysqli_connect("127.0.0.1", $user, $password, $database);
}

// Cek akhir apakah benar-benar tersambung
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Set charset agar tidak ada karakter aneh saat tampil di web
mysqli_set_charset($koneksi, "utf8");
