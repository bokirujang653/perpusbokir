<h4>👥 Tambah Data Anggota</h4>

<form method="post" action="#" enctype="multipart/form-data" class="mt-3">
    <input name="nis" type="number" class="form-control mb-2" placeholder="NIS" required>
    <input name="nama_anggota" type="text" class="form-control mb-2" placeholder="Nama Anggota" required>
    
    <div class="mb-2">
        <label class="small text-muted mb-1">Unggah Foto Profil (JPG/PNG)</label>
        <input name="foto" type="file" class="form-control" accept="image/*" required>
    </div>

    <input name="username" type="text" class="form-control mb-2" placeholder="Username" required>
    <input name="password" type="text" class="form-control mb-2" placeholder="Password" required>
    <input name="kelas" type="text" class="form-control mb-2" placeholder="Kelas" required>
    
    <button name="tombol" type="submit" class="btn btn-primary">💾 SIMPAN DATA</button>
</form>

<?php
if(isset($_POST['tombol'])){
    include '../koneksi.php';
    
    // Mengamankan input teks
    $nis          = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama_anggota = mysqli_real_escape_string($koneksi, $_POST['nama_anggota']);
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass         = mysqli_real_escape_string($koneksi, $_POST['password']);
    $kelas        = mysqli_real_escape_string($koneksi, $_POST['kelas']);

    // 3. LOGIKA PROSES UPLOAD FOTO
    $foto_nama    = $_FILES['foto']['name'];
    $foto_tmp     = $_FILES['foto']['tmp_name'];
    $foto_size    = $_FILES['foto']['size'];

    // Membuat nama file unik menggunakan NIS dan timestamp
    $ekstensi     = pathinfo($foto_nama, PATHINFO_EXTENSION);
    $nama_baru    = "user_" . $nis . "_" . time() . "." . $ekstensi;
    $path_tujuan  = "../img/" . $nama_baru;

    // Validasi ukuran (Maksimal 2MB)
    if($foto_size > 2000000){
        echo "<script>alert('❌ Gagal: Ukuran foto terlalu besar (Maks 2MB)');</script>";
    } else {
        // Pindahkan file ke folder img
        if(move_uploaded_file($foto_tmp, $path_tujuan)){
            
            // 4. SIMPAN KE DATABASE TERMASUK NAMA FILE FOTO
            $query = "INSERT INTO anggota (nis, nama_anggota, username, password, kelas, foto) 
                      VALUES ('$nis', '$nama_anggota', '$username', '$pass', '$kelas', '$nama_baru')";
            
            $data = mysqli_query($koneksi, $query);

            if($data){
                echo "<script>alert('✅ Data anggota berhasil disimpan'); window.location.assign('?halaman=data_anggota');</script>";
            } else {
                echo "<script>alert('😡 Gagal menyimpan data ke database');</script>";
            }
        } else {
            echo "<script>alert('❌ Gagal mengunggah foto profil');</script>";
        }
    }
}
?>