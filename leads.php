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
            $sql = "SELECT * FROM leads WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $_SESSION["alert"]['type'] = "alert-danger";
            $_SESSION["alert"]['message'] = $th->getMessage();
            header('location: leads.php');
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
        <?php $page = "leads";
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
                            <th>source</th>
                            <th>status</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $search= $_GET['search'] ?? null;
                            if($search) {
                                $sql = "SELECT * FROM leads WHERE (name like ? or email like ? or phone like ? or status like ?)";
                                $data= ["%$search%", "%$search%", "%$search%", "%$search%"];
                            }else{
                                $sql = "SELECT * FROM leads";
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
                            <td><?= $item['source'] ?></td>
                            <td><?= $item['status'] ?></td>
                            <td>
                                <a href="interactions.php?lead=<?= $item['id'] ?>" class="btn btn-success" title="Interactions"><i class="fa fa-history"></i></a>
                                <a href="leads.php?id=<?= $item['id'] ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Are you sure?')" href="delete.php?back=leads.php&id=<?= $item['id'] ?>&table=leads" class="btn btn-danger"><i class="fa fa-times"></i></a>
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
                        <h5 class="modal-title" id="addNewItemLabel">Add New lead</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="lead.php" method="POST" id="add-form">
                            <input type="hidden" name="id" value="<?= isset($editItem) ? $editItem['id'] : '' ?>">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" required name="name" value="<?= isset($editItem) ? $editItem['name'] : '' ?>" class="form-control" placeholder="lead name">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" required name="email" value="<?= isset($editItem) ? $editItem['email'] : '' ?>" class="form-control" placeholder="lead email">
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input type="text" required name="phone" value="<?= isset($editItem) ? $editItem['phone'] : '' ?>" class="form-control" placeholder="lead phone">
                            </div>
                            <div class="form-group">
                                <label for="">Source</label>
                                <select required name="source" class="form-control">
                                    <option value="">Select Source</option>
                                    <option <?= isset($editItem) && $editItem['source'] == 'website'  ? 'selected' : '' ?> value="website">Website</option>
                                    <option <?= isset($editItem) && $editItem['source'] == 'facebook'  ? 'selected' : '' ?> value="facebook">Facebook</option>
                                    <option <?= isset($editItem) && $editItem['source'] == 'twitter'  ? 'selected' : '' ?> value="twitter">Twitter</option>
                                    <option <?= isset($editItem) && $editItem['source'] == 'instagram'  ? 'selected' : '' ?> value="instagram">Instagram</option>
                                    <option <?= isset($editItem) && $editItem['source'] == 'other'  ? 'selected' : '' ?> value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select required name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option <?= isset($editItem) && $editItem['status'] == 'new'  ? 'selected' : '' ?> value="new">new</option>
                                    <option <?= isset($editItem) && $editItem['status'] == 'contacted'  ? 'selected' : '' ?> value="contacted">contacted</option>
                                    <option <?= isset($editItem) && $editItem['status'] == 'qualified'  ? 'selected' : '' ?> value="qualified">qualified</option>
                                    <option <?= isset($editItem) && $editItem['status'] == 'closed'  ? 'selected' : '' ?> value="closed">closed</option>
                                </select>
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
                    window.location.href = "leads.php";
                }
            })
        });
    </script>
</body>

</html>