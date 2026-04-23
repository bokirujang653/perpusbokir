<h4>📚 Data Buku</h4>
<a href="?halaman=input_buku" class="btn btn-secondary">
    ➕ Tambah Data Buku
</a>

<table class="table table-bordered mt-3 align-middle">
    <tr class="fw-bold text-center" style="background-color: #fdfbf7;">
        <td>No</td>
        <td>Sampul</td> <td>Judul Buku</td>
        <td>Pengarang</td>
        <td>Penerbit</td>
        <td>Tahun Terbit</td>
        <td>Status</td>
        <td>Kelola</td>
    </tr>
    <?php
    $no = 1;
    include '../koneksi.php';
    $query = "SELECT * FROM buku ORDER BY id_buku DESC";
    $data  = mysqli_query($koneksi, $query);
    foreach ($data as $buku) { ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>
            
            <td class="text-center">
                <?php if (!empty($buku['foto'])): ?>
                    <img src="../img/<?= $buku['foto'] ?>" alt="Sampul" 
                         style="width: 60px; height: 80px; object-fit: cover; border: 1px solid #8d6e63; padding: 2px; background: #fff;">
                <?php else: ?>
                    <small class="text-muted italic">Tidak ada foto</small>
                <?php endif; ?>
            </td>

            <td><?= $buku['judul_buku'] ?></td>
            <td><?= $buku['pengarang'] ?></td>
            <td><?= $buku['penerbit'] ?></td>
            <td class="text-center"><?= $buku['tahun_terbit'] ?></td>
            <td class="text-center">
                <span class="badge <?= $buku['status'] == 'tersedia' ? 'bg-success' : 'bg-danger' ?>">
                    <?= strtoupper($buku['status']) ?>
                </span>
            </td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-sm btn-warning" href="?halaman=edit_buku&id=<?= $buku['id_buku'] ?>">📝 Edit</a>
                    <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin data dihapus')" href="?halaman=hapus_buku&id=<?= $buku['id_buku'] ?>">🗑️ Hapus</a>
                </div>
            </td>
        </tr>
    <?php } ?>
</table>