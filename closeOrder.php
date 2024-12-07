<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header('location: logout.php');
}
include './includes/connection.php';
try {
    $id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE orders SET status='completed' WHERE id = ?");
    $stmt->execute([$id]);
    $back = $_GET['back'];
    header("location: $back");
} catch (\Throwable $th) {
    die($th->getMessage());
}
die;

?>