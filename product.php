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
                "price" => $_POST['price'],
                "description" => $_POST['description'],
            ];
            if($id){
                $sql = "UPDATE products SET name=:name, price=:price,description=:description WHERE id=:id";
                $data['id'] = $id;
            }else{
                $sql = "INSERT INTO products (name,price,description) VALUES (:name,:price,:description)";
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
    header('location: products.php');
    die;
?>