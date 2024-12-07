<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header('location: logout.php');
    }
    include './includes/connection.php';

    $lead = $_GET['lead'];
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        try {
            $data = [
                "date" => $_POST['date'],
                "type" => $_POST['type'],
                "details" => $_POST['details'],
                "lead_id" => $lead,
            ];
            
            $sql = "INSERT INTO interactions (date,type,details,lead_id) VALUES (:date,:type,:details,:lead_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $data = [];
            $_SESSION["alert"]['type'] = "alert-success";
            $_SESSION["alert"]['message'] = "Data Saved successfully";
        } catch (\Throwable $th) {
            $_SESSION["alert"]['type'] = "alert-danger";
            $_SESSION["alert"]['message'] = $th->getMessage();
        }
       
    }
    header("location: interactions.php?lead=$lead");
    die;
?>