<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header('location: logout.php');
    }
    include './includes/connection.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $customer = $_POST['customer'];
        try {
            $data = [
                "date" => $_POST['date'],
                "status" => $_POST['status'],
                "shipping_address" => $_POST['shipping_address'],
                "customer_id" => $customer,
            ];
            
            $sql = "INSERT INTO orders (date,status,shipping_address,customer_id) VALUES (:date,:status,:shipping_address,:customer_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);

            $orderId = $conn->lastInsertId();

            $products = implode(",", $_POST['products']);

            $sql = "SELECT * FROM products WHERE id in ($products)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($products as $product){
                $data = [
                    "product_id" => $product['id'],
                    "order_id"=> $orderId,
                    "price"=> $product['price']
                ];

                $stmt = $conn->prepare("INSERT INTO order_products (product_id, order_id, price) VALUES (:product_id, :order_id, :price)");
                $stmt->execute($data);
            }
            $data = [];
            $_SESSION["alert"]['type'] = "alert-success";
            $_SESSION["alert"]['message'] = "Data Saved successfully";
        } catch (\Throwable $th) {
            $_SESSION["alert"]['type'] = "alert-danger";
            $_SESSION["alert"]['message'] = $th->getMessage();
        }
       
    }
    header("location: orders.php" . ($customer ? "?customer=$customer" : ''));
    die;
?>