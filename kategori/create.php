<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kategori = $_POST['nama_kategori'];

    $query = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (:nama_kategori)");
    $query->bindParam(':nama_kategori', $nama_kategori);
    $query->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Tambah Kategori</h1>
        <form method="POST" action="create.php">
            <div class="form-group">
                <label>Nama Kategori:</label>
                <input type="text" name="nama_kategori" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
