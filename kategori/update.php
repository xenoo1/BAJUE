<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_kategori = $_POST['nama_kategori'];

    $query = $conn->prepare("UPDATE kategori SET nama_kategori = :nama_kategori WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->bindParam(':nama_kategori', $nama_kategori);
    $query->execute();

    header("Location: index.php");
} else {
    $id = $_GET['id'];

    $query = $conn->prepare("SELECT * FROM kategori WHERE id = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    $kategori = $query->fetch
    (PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Kategori</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Kategori</h1>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo $kategori['id']; ?>">
            <div class="form-group">
                <label>Nama Kategori:</label>
                <input type="text" name="nama_kategori" class="form-control" value="<?php echo $kategori['nama_kategori']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
