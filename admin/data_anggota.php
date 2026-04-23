<h4>👥 Data Anggota</h4>
<a href="?halaman=input_anggota" class="btn btn-secondary">
    ➕ Tambah Data Anggota
</a>

<table class="table table-bordered mt-3 align-middle">
    <tr class="fw-bold text-center" style="background-color: #fdfbf7;">
        <td>No</td>
        <td>Foto</td> <td>NIS</td>
        <td>Nama Anggota</td>
        <td>Username</td>
        <td>Password</td>
        <td>Kelas</td>
        <td>Kelola</td>
    </tr>
    <?php
    $no = 1;
    include '../koneksi.php';
    $query = "SELECT * FROM anggota ORDER BY id_anggota DESC";
    $data  = mysqli_query($koneksi, $query);
    foreach($data as $anggota){ ?>
    <tr>
        <td class="text-center"><?= $no++; ?></td>
        
        <td class="text-center">
            <?php if (!empty($anggota['foto'])): ?>
                <img src="../img/<?= $anggota['foto'] ?>" alt="Profil" 
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #8d6e63;">
            <?php else: ?>
                <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; color: #6c757d; border: 1px dashed #ced4da;">
                    No Pic
                </div>
            <?php endif; ?>
        </td>

        <td><?= $anggota['nis'] ?></td>
        <td><?= $anggota['nama_anggota'] ?></td>
        <td><?= $anggota['username'] ?></td>
        <td><small class="text-muted"><?= $anggota['password'] ?></small></td>
        <td><?= $anggota['kelas'] ?></td>
        <td class="text-center">
            <div class="btn-group">
                <a class="btn btn-sm btn-warning" href="?halaman=edit_anggota&id=<?= $anggota['id_anggota'] ?>">📝 Edit</a>
                <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin data dihapus')" href="?halaman=hapus_anggota&id=<?= $anggota['id_anggota'] ?>">🗑️ Hapus</a>
            </div>
        </td>
    </tr>
    <?php } ?>
</table>