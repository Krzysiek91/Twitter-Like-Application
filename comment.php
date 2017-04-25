<?php
    require 'connection.php';
    require 'src/Tweet.php';
    require 'src/User.php';

    $tweetID = $_GET['id'];

    $tweet = Tweet::loadTweetById($conn, $tweetID);
    $userID = $tweet->getUserId();

    $user = User::loadUserById($conn, $userID);
    $userName = $user->getUsername();

?>

<html>
<head>
    <title>MyTwitter - Main Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid col-md-6 col-md-offset-3">

<?php

echo '<div class="tweet">';

echo '<a href="user.php?id=' . $tweet->getUserId() . '">' . '<span class="glyphicon glyphicon-user"></span>' . $userName . ': </a><br>';

echo '<em>' . $tweet->getText() . '</em><br>';

echo '<small>' . '<span class="glyphicon glyphicon-calendar"></span>' . $tweet->getCreationDate() . '</small>';

echo '</div>';

?>

    <form action="" method="POST">

        <textarea class="form-control" rows="2" name="text" placeholder="Comment the Tweet"></textarea>
        <button type="submit" class="btn btn-basic btn-xs">Add your comment</button>

    </form>

</div>

</body>
</html>