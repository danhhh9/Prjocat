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
                "address" => $_POST['address'],
                "date_of_birth" => $_POST['date_of_birth'],
            ];
            if($id){
                $sql = "UPDATE customers SET name=:name, email=:email,phone=:phone,address=:address,date_of_birth=:date_of_birth WHERE id=:id";
                $data['id'] = $id;
            }else{
                $sql = "INSERT INTO customers (name,email,phone,address,date_of_birth) VALUES (:name,:email,:phone,:address,:date_of_birth)";
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
    header('location: customers.php');
    die;
?>