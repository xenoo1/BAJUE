<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $persen = $_POST['persen'];
    $kategori_id = $_POST['kategori_id'];

    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);

        $query = $conn->prepare("UPDATE barang SET nama_barang = :nama_barang, harga = :harga, stok = :stok, persen = :persen, foto = :foto, kategori_id = :kategori_id WHERE id = :id");
        $query->bindParam(':foto', $foto);
    } else {
        $query = $conn->prepare("UPDATE barang SET nama_barang = :nama_barang, harga = :harga, stok = :stok, persen = :persen, kategori_id = :kategori_id WHERE id = :id");
    }

    $query->bindParam(':id', $id);
    $query->bindParam(':nama_barang', $nama_barang);
    $query->bindParam(':harga', $harga);
    $query->bindParam(':stok', $stok);
    $query->bindParam(':persen', $persen);
    $query->bindParam(':kategori_id', $kategori_id);
    $query->execute();

    header("Location: index.php");
} else {
    $id = $_GET['id'];

    $query = $conn->prepare("SELECT * FROM barang WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $barang = $query->fetch(PDO::FETCH_ASSOC);

    $query = $conn->prepare("SELECT * FROM kategori");
    $query->execute();
    $kategori = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Barang</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Barang</h1>
        <form method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $barang['id']; ?>">
            <div class="form-group">
                <label>Nama Barang:</label>
                <input type="text" name="nama_barang" class="form-control" value="<?php echo $barang['nama_barang']; ?>" required>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" class="form-control" value="<?php echo $barang['harga']; ?>" required>
            </div>
            <div class="form-group">
                <label>Stok:</label>
                <input type="number" name="stok" class="form-control" value="<?php echo $barang['stok']; ?>" required>
            </div>
            <div class="form-group">
                <label>Persen:</label>
                <input type="number" name="persen" class="form-control" value="<?php echo $barang['persen']; ?>" required>
            </div>
            <div class="form-group">
                <label>Foto:</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategori_id" class="form-control" required>
                    <?php foreach ($kategori as $k): ?>
                    <option value="<?php echo $k['id']; ?>" <?php echo $k['id'] == $barang['kategori_id'] ? 'selected' : ''; ?>><?php echo $k['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
