<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota - Aplikasi Perpustakaan Digital Sekolah</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estetika Vintage Pendaftaran */
        body {
            background-color: #f4ecd8 !important;
            background-image: url('https://www.transparenttextures.com/patterns/aged-paper.png');
            font-family: 'Georgia', serif;
            color: #4e342e;
        }

        form {
            background-color: #fff9eb !important;
            border: 2px solid #8d6e63 !important;
            border-radius: 0 !important;
            box-shadow: 15px 15px 0px rgba(141, 110, 99, 0.2);
            position: relative;
        }

        form::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: linear-gradient(#e5dec7 1px, transparent 1px);
            background-size: 100% 2.5rem;
            pointer-events: none;
            opacity: 0.3;
        }

        h4 {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #5d4037;
            border-bottom: 3px double #8d6e63;
            display: inline-block;
            margin-bottom: 5px;
        }

        h5 {
            font-style: italic;
            font-size: 0.85rem;
            margin-bottom: 25px;
            color: #795548;
        }

        .form-control {
            background-color: transparent !important;
            border: none;
            border-bottom: 1px solid #8d6e63;
            border-radius: 0;
            padding-left: 5px;
            color: #3e2723;
            position: relative;
            z-index: 1;
        }

        .form-control:focus {
            box-shadow: none;
            border-bottom: 2px solid #5d4037;
        }

        .btn-success {
            background-color: #5d4037 !important;
            border: none !important;
            border-radius: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
            z-index: 1;
            position: relative;
        }

        .btn-success:hover {
            background-color: #3e2723 !important;
        }

        .link-vintage {
            font-size: 0.8rem;
            color: #8d6e63;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
            z-index: 1;
        }

        .link-vintage:hover {
            color: #3e2723;
            text-decoration: underline !important;
        }

        label {
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            color: #8d6e63;
            margin-bottom: -5px;
        }
    </style>
</head>

<body>
    <div class="vh-100 row justify-content-center align-items-center m-0">
        <form method="post" action="#" enctype="multipart/form-data" class="col-md-4 p-5">
            <div class="text-center">
                <h4>Formulir Anggota</h4>
                <h5>Registrasi Koleksi Digital SMK Kiansantang</h5>
            </div>

            <div class="mb-3">
                <label>Nomor Induk Siswa (NIS)</label>
                <input name="nis" type="number" class="form-control" placeholder="..." required>
            </div>

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input name="nama_anggota" type="text" class="form-control" placeholder="..." required>
            </div>

            <div class="mb-3">
                <label>Pas Foto (Format Gambar)</label>
                <input name="foto" type="file" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label>Identitas Pengguna (Username)</label>
                <input name="username" type="text" class="form-control" placeholder="..." required>
            </div>

            <div class="mb-3">
                <label>Kata Sandi</label>
                <input name="password" type="text" class="form-control" placeholder="..." required>
            </div>

            <div class="mb-4">
                <label>Kelas / Jurusan</label>
                <input name="kelas" type="text" class="form-control" placeholder="..." required>
            </div>

            <button type="submit" name="tombol" class="btn btn-success w-100 mb-3">Daftarkan Identitas</button>
            
            <div class="text-center">
                <a href="login-anggota.php" class="link-vintage">« Kembali ke Pintu Masuk</a><br>
                <a href="login-admin.php" class="link-vintage">Akses Kantor Administrasi »</a>
            </div>
        </form>
    </div>

</body>
</html>

<?php
if(isset($_POST['tombol'])){
    include 'koneksi.php';
    $nis           = $_POST['nis'];
    $nama_anggota  = $_POST['nama_anggota'];
    $username      = $_POST['username'];
    $password      = $_POST['password'];
    $kelas         = $_POST['kelas'];

    // 3. LOGIKA PROSES UPLOAD FOTO
    $foto_nama    = $_FILES['foto']['name'];
    $foto_tmp     = $_FILES['foto']['tmp_name'];
    
    // Memberikan nama unik pada file foto menggunakan NIS dan waktu
    $ekstensi     = pathinfo($foto_nama, PATHINFO_EXTENSION);
    $nama_foto_baru = "user_" . $nis . "_" . time() . "." . $ekstensi;
    $folder_tujuan  = "img/" . $nama_foto_baru;

    // Memindahkan file ke folder img
    if(move_uploaded_file($foto_tmp, $folder_tujuan)){
        // Query disesuaikan dengan penambahan kolom 'foto'
        $query = "INSERT INTO anggota(nis, nama_anggota, username, password, kelas, foto) 
                  VALUES('$nis', '$nama_anggota', '$username', '$password', '$kelas', '$nama_foto_baru')";
        $data = mysqli_query($koneksi, $query);

        if($data){
            session_start();
            $_SESSION['id_anggota']   = mysqli_insert_id($koneksi);
            $_SESSION['username']     = $username;
            $_SESSION['password']     = $password;
            $_SESSION['nama_anggota'] = $nama_anggota;
            echo "<script>alert('✅ Pendaftaran Berhasil Berkas Telah Diarsipkan'); window.location.assign('anggota/dashboard.php');</script>";
        }else{
            echo "<script>alert('❌ Pendaftaran Gagal Periksa Kembali Data Anda'); window.location.assign('pendaftaran-anggota.php');</script>";
        }
    } else {
        echo "<script>alert('❌ Gagal Mengunggah Foto Profil'); window.location.assign('pendaftaran-anggota.php');</script>";
    }
}
?>