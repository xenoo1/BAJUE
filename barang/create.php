<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

require '../db.php';

$query = $conn->prepare("SELECT * FROM kategori");
$query->execute();
$kategori = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $persen = $_POST['persen'];
    $kategori_id = $_POST['kategori_id'];

    $foto = $_FILES['foto']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($foto);
    move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);

    $query = $conn->prepare("INSERT INTO barang (nama_barang, harga, stok, persen, foto, kategori_id) VALUES (:nama_barang, :harga, :stok, :persen, :foto, :kategori_id)");
    $query->bindParam(':nama_barang', $nama_barang);
    $query->bindParam(':harga', $harga);
    $query->bindParam(':stok', $stok);
    $query->bindParam(':persen', $persen);
    $query->bindParam(':foto', $foto);
    $query->bindParam(':kategori_id', $kategori_id);
    $query->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Tambah Barang</h1>
        <form method="POST" action="create.php" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Barang:</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stok:</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Persen:</label>
                <input type="number" name="persen" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Foto:</label>
                <input type="file" name="foto" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategori_id" class="form-control" required>
                    <?php foreach ($kategori as $k): ?>
                    <option value="<?php echo $k['id']; ?>"><?php echo $k['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
