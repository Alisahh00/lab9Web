<?php
// modules/barang_list.php
// Logika tampil data
include_once 'koneksi.php';

$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);
?>

<h2>Daftar Barang</h2>
<table>
    <tr>
        <th>Gambar</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Harga Jual</th>
        <th>Harga Beli</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

    <?php if($result && mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_array($result)): ?>
        <tr>
            <td>
                <?php if (!empty($row['gambar'])): ?>
                    <img src="gambar/<?= $row['gambar']; ?>" alt="<?= $row['nama']; ?>">
                <?php else: ?>
                    <span>Tidak ada gambar</span>
                <?php endif; ?>
            </td>

            <td><?= $row['nama']; ?></td>
            <td><?= $row['kategori']; ?></td>
            <td><?= $row['harga_jual']; ?></td>
            <td><?= $row['harga_beli']; ?></td>
            <td><?= $row['stok']; ?></td>

            <td>
                <a href="index.php?page=ubah&id=<?= $row['id_barang']; ?>" class="btn-edit">Edit</a> |
                <a href="index.php?page=hapus&id=<?= $row['id_barang']; ?>" class="btn-hapus" onclick="return confirm('Yakin hapus data?')">Hapus</a>
            </td>

        </tr>
        <?php endwhile; ?>
    <?php else: ?>
    <tr>
        <td colspan="7">Belum ada data</td>
    </tr>
    <?php endif; ?>
</table>