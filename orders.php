<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header('location: logout.php');
    }

    include './includes/connection.php';
    
    $id = $_GET['customer'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/select2.min.css">
    <link rel="stylesheet" href="./assets/css/font-awesome.css">
<link rel="stylesheet" href="./assets/css/style.css">
    <title>CRM</title>
</head>

<body>
    <div class="app">
        <?php $page = "orders";
        include './includes/navbar.php'; ?>
        <div class="pt-4">
            <?php include './includes/alert.php' ?>
            <div class="container">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewItem">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>customer</th>
                            <th>date</th>
                            <th>status</th>
                            <th>products</th>
                            <th>shipping address</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $data = [];
                            try {
                                $sql = "SELECT orders.*, (select count(product_id) from order_products where order_products.order_id = orders.id) as products, customers.name as customer FROM orders 
                                        INNER JOIN customers on customers.id = orders.customer_id ";   
                                if($id){
                                    $sql .= " WHERE customer_id = ?";
                                    $data=[$id];
                                }
                                $stmt = $conn->prepare($sql);
                                $stmt->execute($data);
                                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } catch (\Throwable $th) {
                                die($th->getMessage());
                            }
                            
                            foreach($items as $item):
                        ?>
                        <tr class="text-center">
                            <th><?= $item['id'] ?></th>
                            <td><?= $item['customer'] ?></td>
                            <td><?= $item['date'] ?></td>
                            <td style="background:<?= $item['status'] == 'pending' ? '#a86645' : '#338833' ?>"><?= $item['status'] ?></td>
                            <td><?= $item['products'] ?></td>
                            <td style="width: 20%;"><?= $item['shipping_address'] ?></td>
                            <td>
                                <?php
                                $back = urlencode("orders.php". ($id ? "?customer=$id" : ''));
                                if($item['status'] == "pending"):
                                ?>
                                <a onclick="return confirm('close the order?')" href="closeOrder.php?back=<?= $back ?>&id=<?= $item['id'] ?>" class="btn btn-info"><i class="fa fa-check"></i></a>
                                <?php endif ?>
                                <a onclick="return confirm('Are you sure?')" href="delete.php?back=<?= $back ?>&id=<?= $item['id'] ?>&table=orders" class="btn btn-danger"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNewItem" tabindex="-1" aria-labelledby="addNewItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewItemLabel">Add New order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="order.php" method="POST" id="add-form">
                            
                            <div class="form-group">
                                <label for="">Customers</label>
                                <select required name="customer" class="form-control">
                                    <?php
                                        $stmt = $conn->prepare('SELECT * FROM customers');
                                        $stmt->execute();
                                        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($customers as $user):
                                    ?>
                                    <option <?= $id == $user['id'] ? 'selected' : '' ?> value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Product</label>
                                <select required name="products[]" multiple class="form-control select-two">
                                    <?php
                                        $stmt = $conn->prepare('SELECT * FROM products');
                                        $stmt->execute();
                                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($products as $product):
                                    ?>
                                    <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select required name="status" class="form-control">
                                    <option value="">Select status</option>
                                    <option value="pending">pending</option>
                                    <option value="completed">completed</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="">date</label>
                                <input type="datetime-local" required name="date" class="form-control" placeholder="order date">
                            </div>

                            <div class="form-group">
                                <label for="">shipping address</label>
                                <textarea rows="2" required name="shipping_address" class="form-control" placeholder="order shipping address"></textarea>
                            </div>
                           
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" form="add-form" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p class="text-center text-white">Copyright 2024<sup>&copy;</sup> All right reserved for CRM website</p>
    </div>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/select2.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
   
    <script>
        $(()=>{
            $(".select-two").select2();
        });
    </script>
   
</body>

</html>