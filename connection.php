<?php
$user = 'root';
$password = '';
$dbname = 'twitter';
$dsn = "mysql:host=127.0.0.1; dbname=$dbname; charset=utf8";

$conn = new PDO($dsn, $user, $password);

if ($conn->errorCode() != null) {
    die('Something went wrong with connection...');
}
