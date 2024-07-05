<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

require '../db.php';

$query = $conn->prepare("SELECT barang.*, kategori.nama_kategori FROM barang JOIN kategori ON barang.kategori_id = kategori.id");
$query->execute();
$barang = $query->fetchAll(PDO::FETCH_ASSOC);

include '../header.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barang</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Barang</h1>
        <a href="create.php" class="btn btn-primary mb-3">Tambah Barang</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Persen</th>
                    <th>Foto</th>
                    <th>Kategori</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $b): ?>
                <tr>
                    <td><?php echo $b['id']; ?></td>
                    <td><?php echo $b['nama_barang']; ?></td>
                    <td><?php echo $b['harga']; ?></td>
                    <td><?php echo $b['stok']; ?></td>
                    <td><?php echo $b['persen']; ?>%</td>
                    <td><img src="../uploads/<?php echo $b['foto']; ?>" alt="Foto Barang" width="50"></td>
                    <td><?php echo $b['nama_kategori']; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $b['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $b['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>

