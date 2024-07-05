<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

require '../db.php';

$id = $_GET['id'];

$query = $conn->prepare("DELETE FROM barang WHERE id = :id");
$query->bindParam(':id', $id);
$query->execute();

header("Location: index.php");
?>
