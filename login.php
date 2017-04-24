<?php
session_start();
if(isset($_SESSION['userID'])){
    header('location: 1index.php');
}

require_once 'src/User.php';
require_once 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['email']) && isset($_POST['password'])) {

        $email = $_POST['email'];
        $pass = $_POST['password'];

        $user = User::loadUserByEmail($conn, $_POST['email']);

        if ($user != null && password_verify($pass, $user->getHashPass())) {

            $_SESSION['userID'] = $user->getId();
            $_SESSION['userName'] = $user->getUsername();
            $_SESSION['userEmail'] = $user->getEmail();

            header('Location: 1index.php');

        } else {
            echo 'wrong email or password';
        }
    }
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="register">
                    <form action="" method="post" role="form">
                        <label>Email
                        <input type="text" name="email" class="form-control">
                        </label>
                        <br>
                        <label> Password
                        <input type="password" name="password" class="form-control">
                        </label>
                        <br>
                        <button type="submit" class="btn btn-default">Register</button>
                    </form>
                <p>Don't have account yet? <a href="register.php">Register here</a></p>
                <p><a href="1index.php">Return to main page</a></p>
    </div>
</div>
</body>
</html>
