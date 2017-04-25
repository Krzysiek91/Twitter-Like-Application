<?php
    require_once 'connection.php';
    require 'src/User.php';
    require 'src/Tweet.php';

    $userID = $_GET['id'];
    $user = User::loadUserById($conn, $userID);
    $userTweets = Tweet::loadAllTweetsByUserId($conn, $userID);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Page</title>
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include ('includes/nav.php');
?>

<div class="container">

    <div id="userInf">
        <h4><kbd>User Info<kbd></h4>
        <?php
        echo 'name: ' . $user->getUsername() . '<br>';
        echo 'email: ' . $user->getEmail();
        ?>
    </div>

    <div>
        <h4><kbd>All Tweets made by User</kbd></h4>
        <div class="tweets">
            <?php
                foreach ($userTweets as $tweet){
            echo $tweet->getText() . '<br><span style="font-size: 0.7em">' . $tweet->getCreationDate() . '</span>' . '<br><br>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>