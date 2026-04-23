<?php
include'../koneksi.php';
session_start();
if (empty($_SESSION['id_anggota'])) {
    header("Location:../login-anggota.php");
}

// AMBIL DATA ANGGOTA TERBARU TERMASUK FOTO
$id_anggota = $_SESSION['id_anggota'];
$query_user = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$id_anggota'");
$user = mysqli_fetch_array($query_user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota - Aplikasi Perpustakaan Sekolah Digital</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estetika Vintage Anggota */
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
        }

        /* Navigasi Tombol Vintage */
        .btn-vintage {
            background-color: #8d6e63 !important;
            color: #f4ecd8 !important;
            border-radius: 0;
            border: 1px solid #5d4037;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-right: 5px;
            transition: 0.3s;
        }

        .btn-vintage:hover {
            background-color: #5d4037 !important;
            box-shadow: 4px 4px 0px rgba(0,0,0,0.1);
        }

        /* FOTO PROFIL STYLE */
        .img-profile {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 3px solid #8d6e63;
            box-shadow: 5px 5px 0px rgba(141, 110, 99, 0.2);
        }

        /* FOTO SAMPUL BUKU STYLE */
        .img-cover {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #a1887f;
            margin-bottom: 10px;
        }

        /* Kartu Utama */
        .card-main {
            background-color: #fff9eb !important;
            border: 2px solid #8d6e63 !important;
            border-radius: 0 !important;
            box-shadow: 10px 10px 0px rgba(141, 110, 99, 0.1);
        }

        /* Gaya Kartu Koleksi Buku */
        .book-card {
            background-color: #fffdf7 !important;
            border: 1px solid #a1887f !important;
            border-radius: 0 !important;
            transition: transform 0.2s;
            height: 100%;
            overflow: hidden; /* Agar foto tidak keluar border */
        }
        .book-card:hover {
            transform: scale(1.02);
            border-color: #5d4037 !important;
        }

        .search-box {
            background-color: #fdfaf3;
            border: 1px solid #8d6e63;
            border-radius: 0;
            font-style: italic;
        }

        hr {
            border-top: 2px dashed #8d6e63;
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5">
        <div class="header-vintage">
            <h2 class="fw-bold">PERPUSTAKAAN SMK KIANSANTANG</h2>
            <small>Ruang Baca Anggota Digital</small>
        </div>

        <div class="mb-3">
            <a href="dashboard.php" class="btn btn-vintage">📖 Beranda</a>
            <a href="?halaman=history" class="btn btn-vintage">📜 Riwayat</a>
            <a href="logout.php" class="btn btn-vintage" style="background-color: #a1887f !important;">🚪 Keluar</a>
        </div>

        <div class="card card-main p-4">
            <?php
            $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';
            if (file_exists($halaman . ".php")) {
                include $halaman . ".php";
            } else {
            ?>
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <?php if(!empty($user['foto'])){ ?>
                            <img src="../img/<?= $user['foto']; ?>" class="img-profile">
                        <?php } else { ?>
                            <img src="../img/default-user.png" class="img-profile">
                        <?php } ?>
                    </div>
                    <div>
                        <h4 class="mb-0">Salam Literasi, <u><?= $_SESSION['nama_anggota']; ?></u> 👋</h4>
                        <small class="text-muted italic">ID Anggota: #<?= $id_anggota; ?></small>
                    </div>
                </div>
                
                <form action="?halaman=cari" method="post" class="mb-4">
                    <label class="small fw-bold text-uppercase mb-1">Cari Koleksi Arsip</label>
                    <div class="input-group">
                        <input type="text" name="kunci" class="form-control search-box" required placeholder="Tulis judul buku yang ingin Anda baca...">
                        <button type="submit" class="btn btn-vintage">Cari</button>
                    </div>
                </form>
                
                <hr>

                <h5 class="mb-3">📌 Buku Dalam Genggaman :</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="text-uppercase small fw-bold">
                            <tr>
                                <th>No</th>
                                <th>Sampul</th>
                                <th>Judul Koleksi</th>
                                <th>Waktu Pinjam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM transaksi, buku WHERE buku.id_buku = transaksi.id_buku AND 
                            transaksi.id_anggota = '".$_SESSION['id_anggota']."' AND status_transaksi = 'Peminjaman'";
                            $data = mysqli_query($koneksi, $query);
                            if(mysqli_num_rows($data) == 0){
                                echo "<tr><td colspan='5' class='text-center text-muted'>Tidak ada buku yang sedang dipinjam.</td></tr>";
                            }
                            foreach ($data as $peminjaman) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="text-center">
                                        <img src="../img/<?= $peminjaman['foto'] ?>" style="width: 40px; height: 50px; object-fit: cover; border: 1px solid #8d6e63;">
                                    </td>
                                    <td class="fw-bold text-uppercase"><?= $peminjaman['judul_buku'] ?></td>
                                    <td><?= $peminjaman['tgl_pinjam'] ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-success rounded-0" href="?halaman=pengembalian&id=<?= $peminjaman['id_transaksi'] ?>&buku=<?= $peminjaman['id_buku'] ?>" 
                                        onclick="return confirm('Kembalikan buku ini ke perpustakaan?')">
                                            ✅ Kembalikan
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <hr class="mt-5">

                <h5 class="mb-3">📚 Galeri Koleksi Terbaru :</h5>
                <div class="row g-3">
                    <?php
                    $data_buku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
                    foreach ($data_buku as $buku) {
                    ?>
                        <div class="col-md-3">
                            <div class="card book-card shadow-sm">
                                <?php if(!empty($buku['foto'])){ ?>
                                    <img src="../img/<?= $buku['foto'] ?>" class="img-cover">
                                <?php } else { ?>
                                    <div class="img-cover d-flex align-items-center justify-content-center bg-light text-muted small">Tanpa Sampul</div>
                                <?php } ?>

                                <div class="p-3">
                                    <h6 class="fw-bold text-uppercase mb-1"><?= $buku['judul_buku'] ?></h6>
                                    <div class="small text-muted mb-2">
                                        Penerbit: <?= $buku['penerbit'] ?><br>
                                        Tahun: <?= $buku['tahun_terbit'] ?>
                                    </div>
                                    
                                    <?php if($buku['status']=="tersedia"){ ?>
                                        <span class="badge bg-success rounded-0 mb-2 w-100">Tersedia</span>
                                        <a href="?halaman=peminjaman&id=<?= $buku['id_buku'] ?>" class="btn btn-sm btn-outline-dark rounded-0 w-100" 
                                        onclick="return confirm('Pinjam buku ini?')">Pinjam Buku</a>
                                    <?php }else{ ?>
                                        <span class="badge bg-danger rounded-0 mb-2 w-100">Dipinjam</span>
                                        <button class="btn btn-sm btn-outline-secondary rounded-0 w-100" disabled>Tidak Tersedia</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>