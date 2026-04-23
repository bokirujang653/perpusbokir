<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Aplikasi Perpustakaan Digital Sekolah SMK KIANSANTANG</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya Vintage Khusus Halaman Login */
        body {
            background-color: #f4ecd8 !important; /* Warna kertas lama */
            background-image: url('https://www.transparenttextures.com/patterns/aged-paper.png');
            font-family: 'Georgia', serif;
            color: #5d4037;
        }

        form {
            background-color: #fff9eb !important;
            border: 3px double #8d6e63 !important; /* Border ganda khas sertifikat lama */
            box-shadow: 10px 10px 0px rgba(93, 64, 55, 0.2);
            border-radius: 0 !important; /* Kotak kaku lebih vintage */
        }

        h4, h5 {
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }

        h4 {
            border-bottom: 2px solid #8d6e63;
            padding-bottom: 10px;
        }

        .form-control {
            background-color: #fdfaf3;
            border: 1px solid #8d6e63;
            border-radius: 0;
            color: #5d4037;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #5d4037;
            box-shadow: none;
            outline: 2px solid #8d6e63;
        }

        .btn-success {
            background-color: #5d4037 !important;
            border-color: #3e2723 !important;
            border-radius: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .btn-success:hover {
            background-color: #3e2723 !important;
        }

        a {
            color: #8d6e63;
            font-style: italic;
            font-size: 0.9rem;
        }

        a:hover {
            color: #5d4037;
            text-decoration: underline !important;
        }

        .stamp {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="vh-100 row justify-content-center align-items-center m-0">
        <form method="post" action="#" class="col-md-3 p-4">
            <div class="stamp">📜</div>
            <h4 class="text-center">Akses Admin</h4>
            <h6 class="text-center mb-4 mt-2">PERPUSTAKAAN DIGITAL<br>SMK KIANSANTANG</h6>
            
            <label class="small fw-bold">NAMA PENGGUNA</label>
            <input name="username" class="form-control mb-3" placeholder="Username" required>
            
            <label class="small fw-bold">KATA SANDI</label>
            <input name="password" type="password" class="form-control mb-3" placeholder="Password" required>
            
            <button type="submit" name="tombol" class="btn btn-success w-100 mb-3">Autentikasi</button>
            
            <div class="text-center">
                <a href="login-anggota.php" class="text-decoration-none small">« Masuk sebagai Anggota</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['tombol'])){
    include 'koneksi.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Catatan keamanan: Disarankan menggunakan password_hash di masa depan!
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $data = mysqli_query($koneksi, $query);

    if(mysqli_num_rows($data) > 0){
        $data = mysqli_fetch_array($data);
        session_start();
        $_SESSION['id_admin'] = $data['id_admin'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_admin'] = $data['nama_admin'];
        header("Location:admin/dashboard.php");
    }else{
        echo "<script>alert('Akses Ditolak: Username atau Password salah!')</script>";
    }
}
?>