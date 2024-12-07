<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header('location: logout.php');
    }
    include './includes/connection.php';
    
    $id = $_GET['id'] ?? null;
    $editItem=null;
    if($id){
        try {
            $sql = "SELECT * FROM customers WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $_SESSION["alert"]['type'] = "alert-danger";
            $_SESSION["alert"]['message'] = $th->getMessage();
            header('location: customers.php');
            die;
        }
    }
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
        <?php $page = "customers";
        include './includes/navbar.php'; ?>
        <div class="pt-4">
            <?php include './includes/alert.php' ?>
            <div class="container">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <form action="" class="form-inline">
                            <input type="search" placeholder="search" value="<?= $_GET['search'] ?? '' ?>" name="search" id="search" class="form-control border-right-none">
                            <button type="submit" class="btn btn-secondary border-left-none"><i class="fa fa-search-plus"></i></button>
                        </form>
                    </div>
                    <div class="col-md-6">
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
                            <th>name</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>address</th>
                            <th>date of birth</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $search= $_GET['search'] ?? null;
                            if($search) {
                                $sql = "SELECT * FROM customers WHERE (name like ? or email like ? or phone like ?)";
                                $data= ["%$search%", "%$search%", "%$search%"];
                            }else{
                                $sql = "SELECT * FROM customers";
                                $data = [];
                            }
                            $stmt = $conn->prepare($sql);
                            $stmt->execute($data);
                            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($items as $item):
                        ?>
                        <tr class="text-center">
                            <th><?= $item['id'] ?></th>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['email'] ?></td>
                            <td><?= $item['phone'] ?></td>
                            <td><?= $item['address'] ?></td>
                            <td><?= $item['date_of_birth'] ?></td>
                            <td>
                                <a href="orders.php?customer=<?= $item['id'] ?>" class="btn btn-success"><i class="fa fa-shopping-cart"></i></a>
                                <a href="customers.php?id=<?= $item['id'] ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Are you sure?')" href="delete.php?back=customers.php&id=<?= $item['id'] ?>&table=customers" class="btn btn-danger"><i class="fa fa-times"></i></a>
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
                        <h5 class="modal-title" id="addNewItemLabel">Add New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="customer.php" method="POST" id="add-form">
                            <input type="hidden" name="id" value="<?= isset($editItem) ? $editItem['id'] : '' ?>">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" required name="name" value="<?= isset($editItem) ? $editItem['name'] : '' ?>" class="form-control" placeholder="Customer name">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" required name="email" value="<?= isset($editItem) ? $editItem['email'] : '' ?>" class="form-control" placeholder="Customer email">
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input type="text" required name="phone" value="<?= isset($editItem) ? $editItem['phone'] : '' ?>" class="form-control" placeholder="Customer phone">
                            </div>
                            <div class="form-group">
                                <label for="">Date of birth</label>
                                <input type="date" required name="date_of_birth" value="<?= isset($editItem) ? $editItem['date_of_birth'] : '' ?>" class="form-control" placeholder="Customer birth date">
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" required name="address" value="<?= isset($editItem) ? $editItem['address'] : '' ?>" class="form-control" placeholder="Customer address">
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
    <script src="./assets/js/bootstrap.min.js"></script>
    
    <?php if($editItem): ?>
        <script>
            $(()=>{
                $('#addNewItem').modal('show')
            });
        </script>
    <?php endif ?>

    <script>
        $(()=> {
            $('#addNewItem').on('hidden.bs.modal', function (event) {
                var exists = window.location.href.indexOf('?')
                if(exists > 0){
                    window.location.href = "customers.php";
                }
            })
        });
    </script>
</body>

</html>