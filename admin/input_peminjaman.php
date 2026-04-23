<?php
include'../koneksi.php';
// Ambil data anggota dan buku (Sertakan kolom foto)
$anggota = mysqli_query($koneksi, "SELECT id_anggota, nama_anggota, foto FROM anggota");
$buku    = mysqli_query($koneksi, "SELECT id_buku, judul_buku, foto FROM buku WHERE status='tersedia'");
?>

<h4>🛒 Tambah Peminjaman</h4>

<div class="row mt-3">
    <div class="col-md-8">
        <form method="post" action="#" class="card p-4 shadow-sm">
            <label class="small fw-bold">PILIH ANGGOTA</label>
            <select name="id_anggota" id="select_anggota" class="form-control mb-2" required onchange="tampilFotoAnggota()">
                <option value="" data-foto="default-user.png"> === 👥 Pilih Anggota === </option>
                <?php
                foreach($anggota as $data){
                    // Simpan nama file foto di atribut data-foto
                    echo"<option value='$data[id_anggota]' data-foto='$data[foto]'>$data[nama_anggota]</option>";
                }
                ?>
            </select>

            <label class="small fw-bold">PILIH BUKU</label>
            <select name="id_buku" id="select_buku" class="form-control mb-2" required onchange="tampilFotoBuku()">
                <option value="" data-foto="default-book.png"> === 📚 Pilih Buku === </option>
                <?php
                foreach($buku as $data){
                    // Simpan nama file foto di atribut data-foto
                    echo"<option value='$data[id_buku]' data-foto='$data[foto]'>$data[judul_buku]</option>";
                }
                ?>
            </select>

            <label class="small fw-bold">TANGGAL PINJAM</label>
            <input name="tgl_pinjam" type="datetime-local" class="form-control mb-3" required>
            
            <button name="tombol" type="submit" class="btn btn-primary w-100">💾 SIMPAN DATA PEMINJAMAN</button>
        </form>
    </div>

    <div class="col-md-4 text-center">
        <div class="card p-3 shadow-sm mb-2">
            <h6 class="small fw-bold">FOTO ANGGOTA</h6>
            <img id="preview_anggota" src="../img/default-user.png" class="img-thumbnail" style="height: 120px; width: 120px; object-fit: cover; border-radius: 50%;">
        </div>
        <div class="card p-3 shadow-sm">
            <h6 class="small fw-bold">SAMPUL BUKU</h6>
            <img id="preview_buku" src="../img/default-book.png" class="img-thumbnail" style="height: 150px; width: 110px; object-fit: cover;">
        </div>
    </div>
</div>

<script>
// Fungsi untuk mengganti foto anggota secara otomatis saat dipilih
function tampilFotoAnggota() {
    var select = document.getElementById("select_anggota");
    var foto = select.options[select.selectedIndex].getAttribute("data-foto");
    document.getElementById("preview_anggota").src = "../img/" + (foto ? foto : "default-user.png");
}

// Fungsi untuk mengganti foto buku secara otomatis saat dipilih
function tampilFotoBuku() {
    var select = document.getElementById("select_buku");
    var foto = select.options[select.selectedIndex].getAttribute("data-foto");
    document.getElementById("preview_buku").src = "../img/" + (foto ? foto : "default-book.png");
}
</script>

<?php
if(isset($_POST['tombol'])){
    $id_anggota       = $_POST['id_anggota'];
    $id_buku          = $_POST['id_buku'];
    $tgl_pinjam       = $_POST['tgl_pinjam'];
    $status_transaksi = "Peminjaman";

    include'../koneksi.php';
    $query = "INSERT INTO transaksi(id_anggota,id_buku,tgl_pinjam,status_transaksi) VALUES('$id_anggota','$id_buku','$tgl_pinjam','$status_transaksi')";
    $data  = mysqli_query($koneksi, $query);

    if($data){
        // Ubah status buku menjadi 'tidak' tersedia
        mysqli_query($koneksi, "UPDATE buku SET status='tidak' WHERE id_buku='$id_buku'");
        echo"<script>alert('✅ data peminjaman tersimpan'); window.location.assign('?halaman=data_peminjaman');</script>";
    }else{
        echo"<script>alert('😡 data gagal tersimpan'); window.location.assign('?halaman=input_peminjaman');</script>";
    }
}
?>