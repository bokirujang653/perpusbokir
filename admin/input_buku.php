<h4>📚 Tambah Data Buku</h4>

<form method="post" action="#" enctype="multipart/form-data" class="mt-3">
    <input name="judul_buku" type="text" class="form-control mb-2" placeholder="Judul Buku" required>
    <input name="pengarang" type="text" class="form-control mb-2" placeholder="Pengarang" required>
    <input name="penerbit" type="text" class="form-control mb-2" placeholder="Penerbit" required>
    <input name="tahun_terbit" type="number" maxlength="4" class="form-control mb-2" placeholder="Tahun Terbit" required>
    
    <div class="mb-3">
        <label class="small text-muted mb-1">Unggah Sampul Buku (JPG/PNG)</label>
        <input name="foto" type="file" class="form-control" accept="image/*" required>
    </div>

    <button name="tombol" type="submit" class="btn btn-primary">💾 SIMPAN DATA</button>
</form>

<?php
if(isset($_POST['tombol'])){
    include '../koneksi.php';

    // Mengamankan input teks
    $judul_buku   = mysqli_real_escape_string($koneksi, $_POST['judul_buku']);
    $pengarang    = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit     = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun_terbit = $_POST['tahun_terbit'];
    $status       = "tersedia";

    // 3. LOGIKA PROSES UPLOAD FOTO
    $foto_nama    = $_FILES['foto']['name'];
    $foto_tmp     = $_FILES['foto']['tmp_name'];
    $foto_size    = $_FILES['foto']['size'];

    // Ambil ekstensi file dan buat nama unik agar tidak bentrok
    $ekstensi     = pathinfo($foto_nama, PATHINFO_EXTENSION);
    $nama_baru    = "buku_" . time() . "_" . rand(100, 999) . "." . $ekstensi;
    $path_tujuan  = "../img/" . $nama_baru;

    // Validasi sederhana (Maksimal 2MB)
    if($foto_size > 2000000){
        echo "<script>alert('❌ Gagal: Ukuran file terlalu besar (Maks 2MB)');</script>";
    } else {
        // Pindahkan file ke folder img
        if(move_uploaded_file($foto_tmp, $path_tujuan)){
            
            // 4. SIMPAN KE DATABASE TERMASUK NAMA FILE FOTO
            $query = "INSERT INTO buku (judul_buku, pengarang, penerbit, tahun_terbit, status, foto) 
                      VALUES ('$judul_buku', '$pengarang', '$penerbit', '$tahun_terbit', '$status', '$nama_baru')";
            
            $data = mysqli_query($koneksi, $query);

            if($data){
                echo "<script>alert('✅ Data buku berhasil diarsipkan'); window.location.assign('?halaman=data_buku');</script>";
            } else {
                echo "<script>alert('😡 Gagal menyimpan data ke database');</script>";
            }
        } else {
            echo "<script>alert('❌ Gagal mengunggah gambar sampul');</script>";
        }
    }
}
?>