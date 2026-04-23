<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan Digital Sekolah - Vintage</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Kustomisasi Tema Vintage */
        body {
            background-color: #f4ecd8 !important; /* Warna kertas lama */
            background-image: url('https://www.transparenttextures.com/patterns/aged-paper.png'); /* Efek tekstur kertas */
            font-family: 'Georgia', serif;
            color: #5d4037;
        }

        .card {
            background-color: #fff9eb;
            border: 2px solid #8d6e63;
            border-radius: 0; /* Siku tajam lebih terasa retro */
            box-shadow: 5px 5px 0px #8d6e63;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        h5 {
            letter-spacing: 2px;
            font-weight: bold;
            border-bottom: 1px solid #d7ccc8;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #795548 !important;
            border-color: #5d4037 !important;
            border-radius: 0;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background-color: #5d4037 !important;
            box-shadow: inset 2px 2px 5px rgba(0,0,0,0.2);
        }

        .icon-vintage {
            font-size: 3rem;
            filter: sepia(1); /* Membuat emoji terasa lebih menyatu dengan tema */
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="vh-100 container d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            
            <div class="col-md-3 m-2">
                <div class="card p-4 text-center">
                    <div class="icon-vintage">💻</div>
                    <h5>ARSIP ADMIN</h5>
                    <p class="small text-muted">Akses Manajemen Sistem</p>
                    <a href="login-admin.php" class="btn btn-primary">MASUK ADMIN</a>
                </div>
            </div>

            <div class="col-md-3 m-2">
                <div class="card p-4 text-center">
                    <div class="icon-vintage">👥</div>
                    <h5>RUANG ANGGOTA</h5>
                    <p class="small text-muted">Akses Koleksi Buku</p>
                    <a href="login-anggota.php" class="btn btn-primary">MASUK ANGGOTA</a>
                </div>
            </div>

        </div>
    </div>
</body>

</html>