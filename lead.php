<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header('location: logout.php');
    }
    include './includes/connection.php';


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        try {
            $id = $_POST['id'];
            $data = [
                "name" => $_POST['name'],
                "email" => $_POST['email'],
                "phone" => $_POST['phone'],
                "source" => $_POST['source'],
                "status" => $_POST['status'],
            ];
            if($id){
                $sql = "UPDATE leads SET name=:name, email=:email,phone=:phone,source=:source,status=:status WHERE id=:id";
                $data['id'] = $id;
            }else{
                $sql = "INSERT INTO leads (name,email,phone,source,status) VALUES (:name,:email,:phone,:source,:status)";
            }
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
    header('location: leads.php');
    die;
?>