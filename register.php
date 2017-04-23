<?php
session_start();
if(isset($_SESSION['userID'])){
    header('location: 1index.php');
}

require_once 'src/User.php';
require_once 'connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((User::loadUserByEmail($conn, $_POST['email'])) == null){
        if(isset($_POST['username']) && isset($_POST['email'])&& $_POST['password']) {
            $user = new User();

            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPass('password');

            $user->saveToDB($conn);

            $_SESSION['userID'] = $user->getId();

            header('Location: 1index.php');
        }else{
            echo 'Missing or wrong data';
        }
    }else{
        echo 'Acount with that email already exist';
    }
}


?>






<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="register">
                    <form action="" method="post" role="form">
                        <label>Username
                        <input type="text" name="username" class="form-control">
                        </label>
                        <br>
                        <label> Email
                        <input type="text" name="email" class="form-control">
                        </label>
                        <br>
                        <label> Password
                        <input type="password" name="password" class="form-control">
                        </label>
                        <br>
                        <button type="submit" class="btn btn-default">Register</button>
                    </form>
                <p>Already have account? <a href="login.php">Log in here</a></p>
                <p><a href="1index.php">Return to main page</a></p>
    </div>
</div>
</body>
</html>