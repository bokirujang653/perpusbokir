<?php
session_start();
if (empty($_SESSION['id_admin'])) {
    header("Location:../login-admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpustakaan Digital SMK KIANSANTANG</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya Dasar Vintage */
        body {
            background-color: #f4ecd8 !important;
            background-image: url('https://www.transparenttextures.com/patterns/aged-paper.png');
            font-family: 'Georgia', serif;
            color: #4e342e;
        }

        .header-vintage {
            border-bottom: 4px double #8d6e63;
            padding-bottom: 15px;
            margin-bottom: 25px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Navigasi Bergaya Tab Arsip */
        .nav-vintage {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-vintage {
            border-radius: 0;
            border: 2px solid #5d4037;
            background: #efebe9;
            color: #5d4037;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 10px 20px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-vintage:hover {
            background: #5d4037;
            color: #f4ecd8;
        }

        /* Tombol Aktif / Spesifik */
        .btn-active { background: #8d6e63; color: white; }
        .btn-logout { border-color: #7f0000; color: #7f0000; }
        .btn-logout:hover { background: #7f0000; color: white; }

        /* Konten Utama */
        .card-archive {
            background-color: #fff9eb !important;
            border: 2px solid #8d6e63 !important;
            border-radius: 0 !important;
            box-shadow: 8px 8px 0px rgba(93, 64, 55, 0.1);
            min-height: 400px;
        }

        .welcome-title {
            font-style: italic;
            border-left: 5px solid #8d6e63;
            padding-left: 15px;
            margin-bottom: 20px;
        }

        hr.vintage-hr {
            border-top: 2px dashed #8d6e63;
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="header-vintage">
            <small>Panel Kendali Administrasi</small>
            <h2 class="fw-bold">Perpustakaan SMK KIANSANTANG</h2>
        </div>

        <div class="nav-vintage mb-4">
            <a href="dashboard.php" class="btn-vintage <?= !isset($_GET['halaman']) ? 'btn-active' : '' ?>">📜 Beranda</a>
            <a href="?halaman=data_buku" class="btn-vintage <?= ($_GET['halaman'] ?? '') == 'data_buku' ? 'btn-active' : '' ?>">📚 Data Buku</a>
            <a href="?halaman=data_anggota" class="btn-vintage <?= ($_GET['halaman'] ?? '') == 'data_anggota' ? 'btn-active' : '' ?>">👥 Anggota</a>
            <a href="?halaman=data_peminjaman" class="btn-vintage <?= ($_GET['halaman'] ?? '') == 'data_peminjaman' ? 'btn-active' : '' ?>">✍️ Peminjaman</a>
            <a href="logout.php" class="btn-vintage btn-logout">🚪 Keluar</a>
        </div>

        <div class="card card-archive p-4">
            <?php
            $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';
            if (file_exists($halaman . ".php")) {
                include $halaman . ".php";
            } else {
            ?>
                <div class="welcome-section">
                    <h3 class="welcome-title">Selamat Datang, Kurator <?= $_SESSION['nama_admin']; ?>.</h3>
                    <hr class="vintage-hr">
                    <p class="lead" style="line-height: 1.8; text-align: justify;">
                        Sistem Informasi Perpustakaan Digital ini siap digunakan. Silakan kelola data koleksi buku, 
                        pantau keanggotaan siswa, serta catat setiap transaksi peminjaman melalui menu navigasi di atas. 
                        Pastikan semua arsip tercatat dengan teliti untuk menjaga kelestarian ilmu pengetahuan di SMK Kiansantang.
                    </p>
                    <div class="mt-5 text-end opacity-50">
                        <small><em>Dicetak secara digital pada: <?= date('d F Y'); ?></em></small>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>