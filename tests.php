<?php

require 'connection.php';
require 'src/User.php';

// TESTY komunikacji z bazą danych:)

$user = new User();

$user->setUsername('MariuszPudzianowski');

$user->setPass('asdfg');

$user->setEmail('asdfg@wp.pl');

$user->saveToDB($conn);

var_dump($user);


//$user->setUsername('krzysiek');

//$user->saveToDB($conn);

//$user = User::loadUser

//$user = User::loadAllUsers($conn);

//$user = User::loadUserById($conn, 21);

//$user->setUsername('PudzianowskiMMA');
//$user->setEmail('mario@wp.pl');
//$user->setPass('dupa');

//$user = User::loadUserById($conn, 21);

//$user -> delete($conn);

//$user->saveToDB($conn);

//var_dump($user);

