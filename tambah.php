<?php
error_reporting(E_ALL);
require_once 'koneksi.php';

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga_jual = mysqli_real_escape_string($conn, $_POST['harga_jual']);
    $harga_beli = mysqli_real_escape_string($conn, $_POST['harga_beli']);
    $stok       = mysqli_real_escape_string($conn, $_POST['stok']);

    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

    if ($file_gambar['error'] == 0) {
        
        $file_type = pathinfo($file_gambar['name'], PATHINFO_EXTENSION);
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($file_type), $allowed_types)) {
            
            $filename = uniqid() . '.' . $file_type;
            
            $destination = dirname(__FILE__) . '/gambar/' . $filename;

            if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
                $gambar = $filename;
            } else {

                echo "Gagal mengupload gambar.";
            }
        } else {
            echo "Jenis file gambar tidak valid.";
        }
    }

    $sql = "INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) 
            VALUES ('{$nama}', '{$kategori}', '{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

require_once 'header.php'; 
?>

<h1>Tambah Barang</h1>

<div class="main">

<form method="post" action="tambah.php" enctype="multipart/form-data">

    <div class="input">
        <label>Nama Barang</label>
        <input type="text" name="nama" required />
    </div>

    <div class="input">
        <label>Kategori</label>
        <select name="kategori" required>
            <option value="Komputer">Komputer</option>
            <option value="Elektronik">Elektronik</option>
            <option value="Hand Phone">Hand Phone</option>
        </select>
    </div>

    <div class="input">
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" required />
    </div>

    <div class="input">
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" required />
    </div>

    <div class="input">
        <label>Stok</label>
        <input type="number" name="stok" required />
    </div>

    <div class="input">
        <label>File Gambar</label>
        <input type="file" name="file_gambar" accept="image/*" /> 
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Simpan" />
    </div>

</form>

</div>

<?php
require_once 'footer.php';
?>