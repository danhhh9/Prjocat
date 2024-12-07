<?php
session_start();

if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
    header('location: index.php');
}
include './includes/connection.php';
$page = "login";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = [];
    try {
        $data = [
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        ];

        $stmt = $conn->prepare("SELECT * FROM users where email=:email and password=:password");
        $stmt->execute($data);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && is_array($user)) {
            $_SESSION['user'] = $user;
            header('location: index.php');
            die;
        } else {
            $error = true;
        }
    } catch (\Throwable $th) {
        die($th->getMessage());
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
    <main class="app">

        <div class="container" style="height: 92vh;">
            <div class="row h-100">
                <div class="col-md-8 mx-auto h-100">
                    <div class="d-flex align-items-center w-100 h-100">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-around p-4 mb-3">
                                    <strong style="font-size: 60pt;">C</strong>
                                    <strong style="font-size: 60pt;color: #ab0808;">R</strong>
                                    <strong style="font-size: 60pt;">M</strong>
                                </div>
                                <form action="" method="POST">

                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" class="form-control">
                                        <?php if ($error == true): ?>
                                            <span style="color: #ff5555;">Invalid Credentials</span>
                                        <?php endif ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary w-100">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>
</body>

</html>