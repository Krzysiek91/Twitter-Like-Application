<?php
session_start();
if(isset($_SESSION['userID'])){
    unset($_SESSION['userID']);
    unset($_SESSION['userName']);
    unset($_SESSION['userEmail']);

    header('Location: index.php');
}else{
    header('Location: index.php');
}