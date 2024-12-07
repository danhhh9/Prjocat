<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header('location: logout.php');
    }

    include './includes/connection.php';
    
    $id = $_GET['lead'] ?? null;
    if(!$id){
        header('location: leads.php');
        die;
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
                            <th>type</th>
                            <th>date</th>
                            <th>Lead</th>
                            <th>details</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT interactions.*, leads.name as lead FROM interactions INNER JOIN leads on leads.id = interactions.lead_id where lead_id=?";   
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([$id]);
                            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($items as $item):
                        ?>
                        <tr class="text-center">
                            <th><?= $item['id'] ?></th>
                            <td><?= $item['type'] ?></td>
                            <td><?= $item['date'] ?></td>
                            <td><?= $item['lead'] ?></td>
                            <td style="width: 45%;"><?= $item['details'] ?></td>
                            <td>
                                <?php
                                $back = urlencode("interactions.php?lead=$id");
                                ?>
                                <a onclick="return confirm('Are you sure?')" href="delete.php?back=<?= $back ?>&id=<?= $item['id'] ?>&table=interactions" class="btn btn-danger"><i class="fa fa-times"></i></a>
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
                        <h5 class="modal-title" id="addNewItemLabel">Add New interaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="interaction.php?lead=<?= $id ?>" method="POST" id="add-form">
                            <div class="form-group">
                                <label for="">Type</label>
                                <select required name="type" class="form-control">
                                    <option value="">Select type</option>
                                    <option value="email">email</option>
                                    <option value="call">call</option>
                                    <option value="sms">sms</option>
                                    <option value="whatsapp">whatsapp</option>
                                    <option value="meeting">meeting</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="">date</label>
                                <input type="datetime-local" required name="date" class="form-control" placeholder="interaction date">
                            </div>

                            <div class="form-group">
                                <label for="">details</label>
                                <textarea rows="5" required name="details" class="form-control" placeholder="interaction details"></textarea>
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