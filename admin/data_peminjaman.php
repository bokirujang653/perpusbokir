<h4>🛒 Data Peminjaman</h4>
<a href="?halaman=input_peminjaman" class="btn btn-secondary">
    ➕ Tambah Data Peminjaman
</a>
<table class="table table-bordered mt-3 align-middle">
    <tr class="fw-bold text-center" style="background-color: #fdfbf7;">
        <td>No</td>
        <td>Foto</td> <td>Peminjam & Buku</td> <td>Tanggal Pinjam</td>
        <td>Kelola</td>
    </tr>
    <?php
    include'../koneksi.php';
    $no = 1;
    // Query mengambil semua data termasuk foto anggota dan foto buku
    $query = "SELECT transaksi.*, buku.judul_buku, buku.foto AS foto_buku, anggota.nama_anggota, anggota.nis, anggota.foto AS foto_anggota 
              FROM transaksi, buku, anggota 
              WHERE buku.id_buku=transaksi.id_buku 
              AND anggota.id_anggota=transaksi.id_anggota 
              AND transaksi.status_transaksi='Peminjaman' 
              ORDER BY transaksi.id_transaksi DESC";
    $data  = mysqli_query($koneksi, $query);
    foreach($data as $pinjam){ ?>
    <tr>
        <td class="text-center"><?= $no++; ?></td>
        <td class="text-center">
            <img src="../img/<?= !empty($pinjam['foto_anggota']) ? $pinjam['foto_anggota'] : 'default-user.png' ?>" 
                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 1px solid #8d6e63;">
        </td>
        <td>
            <div class="d-flex align-items-center">
                <img src="../img/<?= !empty($pinjam['foto_buku']) ? $pinjam['foto_buku'] : 'default-book.png' ?>" 
                     style="width: 35px; height: 50px; object-fit: cover; margin-right: 10px; border: 1px solid #ddd;">
                <div>
                    <strong><?= $pinjam['nama_anggota'] ?></strong> <small>(<?= $pinjam['nis'] ?>)</small><br>
                    <span class="text-muted small">Buku: <?= $pinjam['judul_buku'] ?></span>
                </div>
            </div>
        </td>
        <td class="text-center"><?= $pinjam['tgl_pinjam'] ?></td>
        <td class="text-center">
            <?php
            $pesan ="✅ Pengembalian buku oleh $pinjam[nama_anggota], Buku $pinjam[judul_buku]";
            $isi   = "'$pesan', $pinjam[id_transaksi], $pinjam[id_buku]";
            ?>
            <a onclick="pengembalian(<?= $isi ?>)" class="btn btn-sm btn-success">✅ Kembali</a>
            
            <?php
            $pesan_hapus ="🗑️ Anda Yakin ingin menghapus data $pinjam[nama_anggota]?";
            $isi_hapus   = "'$pesan_hapus', $pinjam[id_transaksi], $pinjam[id_buku]";
            ?>
            <a onclick="hapus(<?= $isi_hapus ?>)" class="btn btn-sm btn-danger">🗑️</a>
        </td>
    </tr>
    <?php } ?>
</table>

<hr>

<h4>✅ Data Pengembalian</h4>
<table class="table table-bordered mt-3 align-middle">
    <tr class="fw-bold text-center" style="background-color: #fdfbf7;">
        <td>No</td>
        <td>Foto</td>
        <td>Informasi Anggota & Buku</td>
        <td>Waktu</td>
        <td>Kelola</td>
    </tr>
    <?php
    $no_k = 1;
    $query_k = "SELECT transaksi.*, buku.judul_buku, buku.foto AS foto_buku, anggota.nama_anggota, anggota.nis, anggota.foto AS foto_anggota 
                FROM transaksi, buku, anggota 
                WHERE buku.id_buku=transaksi.id_buku 
                AND anggota.id_anggota=transaksi.id_anggota 
                AND transaksi.status_transaksi='Pengembalian' 
                ORDER BY transaksi.id_transaksi DESC";
    $data_k  = mysqli_query($koneksi, $query_k);
    foreach($data_k as $kembali){ ?>
    <tr>
        <td class="text-center"><?= $no_k++; ?></td>
        <td class="text-center">
            <img src="../img/<?= !empty($kembali['foto_anggota']) ? $kembali['foto_anggota'] : 'default-user.png' ?>" 
                 style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%;">
        </td>
        <td>
            <strong><?= $kembali['nama_anggota'] ?></strong><br>
            <small class="text-success">📖 <?= $kembali['judul_buku'] ?></small>
        </td>
        <td class="small">
            Pinjam: <?= $kembali['tgl_pinjam'] ?><br>
            Kembali: <b><?= $kembali['tgl_kembali'] ?></b>
        </td>
        <td class="text-center">
            <?php
            $pesan ="🗑 Anda Yakin ingin menghapus data pengembalian ini?";
            $isi = "'$pesan', $kembali[id_transaksi], $kembali[id_buku]";
            ?>
            <a onclick="hapus(<?= $isi ?>)" class="btn btn-sm btn-outline-danger">🗑 Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

<script>
    function pengembalian(pesan,id_transaksi,id_buku){
        if(confirm(pesan)){
            window.location.href = '?halaman=proses_pengembalian&id='+id_transaksi+'&buku='+id_buku;
        }
    }
    function hapus(pesan,id_transaksi,id_buku){
        if(confirm(pesan)){
            window.location.href = '?halaman=hapus&id='+id_transaksi+'&buku='+id_buku;
        }
    }
</script>