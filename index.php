<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Selamat Datang di Bajue</h1>
        <!-- <a href="logout.php" class="btn btn-danger">Logout</a> -->
        <nav class="mt-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="kategori/index.php">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="barang/index.php">Barang</a>
                </li>
            </ul>
        </nav>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
