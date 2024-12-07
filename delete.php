<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header('location: logout.php');
}
include './includes/connection.php';
try {
    $id = $_GET['id'];
    $table = $_GET['table'];

    $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    
    $back = $_GET['back'];
    header("location: $back");
} catch (\Throwable $th) {
    die($th->getMessage());
}
die;

?>