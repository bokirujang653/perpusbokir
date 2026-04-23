<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Anggota - Perpustakaan Digital</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya Vintage untuk Anggota */
        body {
            background-color: #f4ecd8 !important;
            background-image: url('https://www.transparenttextures.com/patterns/aged-paper.png');
            font-family: 'Georgia', serif;
            color: #5d4037;
        }

        form {
            background-color: #fffdf7 !important;
            border: 2px solid #a1887f !important;
            border-radius: 0 !important; /* Menghilangkan rounded agar terlihat klasik */
            box-shadow: 12px 12px 0px #d7ccc8; /* Bayangan solid gaya retro */
            padding: 30px !important;
        }

        h4 {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            border-bottom: 2px solid #5d4037;
            display: inline-block;
            margin-bottom: 10px;
        }

        h5 {
            font-style: italic;
            font-size: 0.9rem;
            color: #8d6e63;
        }

        .form-control {
            background-color: #fdfaf3;
            border: 1px solid #a1887f;
            border-radius: 0;
            margin-bottom: 15px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #5d4037;
            background-color: #fff;
        }

        .btn-success {
            background-color: #8d6e63 !important;
            border: none !important;
            border-radius: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px;
        }

        .btn-success:hover {
            background-color: #5d4037 !important;
        }

        .link-vintage {
            color: #8d6e63;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .link-vintage:hover {
            color: #2e1a12;
            text-decoration: underline !important;
        }

        .library-stamp {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 5px;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <div class="vh-100 container d-flex justify-content-center align-items-center">
        <div class="col-md-4">
            <form method="post" action="#">
                <div class="library-stamp">📚</div>
                <div class="text-center mb-4">
                    <h4>Masuk Anggota</h4>
                    <h5>Literasi untuk Masa Depan</h5>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold text-uppercase">Nama Pengguna</label>
                    <input name="username" class="form-control" placeholder="Masukkan Username" required>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold text-uppercase">Kata Sandi</label>
                    <input name="password" type="password" class="form-control" placeholder="Masukkan Password" required>
                </div>

                <button type="submit" name="tombol" class="btn btn-success w-100 mb-3">Buka Koleksi</button>
                
                <div class="text-center">
                    <a href="login-admin.php" class="link-vintage text-decoration-none">💻 Akses Gerbang Admin</a>
                    <hr class="my-2" style="border-color: #d7ccc8;">
                    <a href="pendaftaran-anggota.php" class="link-vintage text-decoration-none fw-bold">👥 Belum punya kartu? Daftar di sini.</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php
if(isset($_POST['tombol'])){
    include 'koneksi.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM anggota WHERE username='$username' AND password='$password'";
    $data = mysqli_query($koneksi, $query);
    if(mysqli_num_rows($data) > 0){
        $data = mysqli_fetch_array($data);
        session_start();
        $_SESSION['id_anggota'] = $data['id_anggota'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_anggota'] = $data['nama_anggota'];
        header("Location:anggota/dashboard.php");
    }else{
        echo "<script>alert('Login Gagal, Username / Password Salah'); window.location.assign('login-anggota.php');</script>";
    }
}
?>