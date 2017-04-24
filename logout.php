<?php
session_start();
if(isset($_SESSION['userID'])){
    unset($_SESSION['userID']);
    unset($_SESSION['userName']);
    unset($_SESSION['userEmail']);

    header('Location: 1index.php');
}else{
    header('Location: 1index.php');
}