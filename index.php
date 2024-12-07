<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header('location: logout.php');
    }
    include './includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/font-awesome.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>CRM</title>
</head>

<body>
    <div class="app">
        <?php $page = "home";  include './includes/navbar.php'; ?>
        <div class="pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fa fa-users text-muted" style="font-size: 50pt;"></i>
                                </div>
                                <p class="text-center" style="font-size: 20pt;">
                                    <?php 
                                         $stmt = $conn->prepare("SELECT count(id) as count FROM customers");
                                         $stmt->execute();
                                         $item = $stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $item['count'];
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="customers.php" class="d-block p-2 text-center">Customers</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fa fa-bullhorn text-muted" style="font-size: 50pt;"></i>
                                </div>
                                <p class="text-center" style="font-size: 20pt;">
                                <?php 
                                         $stmt = $conn->prepare("SELECT count(id) as count FROM leads");
                                         $stmt->execute();
                                         $item = $stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $item['count'];
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="leads.php" class="d-block p-2 text-center">Leads</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fa fa-list-alt text-muted" style="font-size: 50pt;"></i>
                                </div>
                                <p class="text-center" style="font-size: 20pt;">
                                    <?php 
                                         $stmt = $conn->prepare("SELECT count(id) as count FROM orders");
                                         $stmt->execute();
                                         $item = $stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $item['count'];
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="orders.php" class="d-block p-2 text-center">Orders</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p class="text-center text-white">Copyright 2024<sup>&copy;</sup> All right reserved for CRM website</p>
    </div>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>

</html>