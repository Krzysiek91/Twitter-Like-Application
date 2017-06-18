<?php
session_start();
if(
        isset($_SESSION['userID'])&&
        isset($_SESSION['userName'])&&
        isset($_SESSION['userEmail'])
){
    $userID = $_SESSION['userID'];
    $userName = $_SESSION['userName'];
    $userEmail = $_SESSION['userEmail'];
}else{
    $userID = null;
    $userName = null;
    $userEmail = null;
}

require 'connection.php';
require 'src/Tweet.php';
require 'src/User.php';
require 'src/Comment.php';
require 'src/Message.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['text']) && $userID != null) {

        $tweet = new Tweet();
        $tweet->setUserId($_SESSION['userID']);
        $tweet->setText($_POST['text']);
        $tweet->setCreationDate(date('Y-m-d H:i:s'));
        $tweet->saveToDB($conn);
    }

}
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

    <?php
    include ('includes/nav.php');
    ?>
    <div class="container-fluid col-md-4 col-md-offset-4">
        <h1>Twitter-Like Aplication</h1>
         <?php if($userName!=null) {
             echo '<h3 class="welcome"><kbd>Welcome ' . $userName . ' !</kbd></h3>';
    }
         ?>

        <form action="" method="POST">

            <textarea class="form-control" rows="3" name="text" placeholder="Lets Tweet Sth:)"></textarea><br>
            <button type="submit" class="btn btn-basic">Add your Tweet</button>

        </form>

        <h3 id="latestTweets">Latest Tweets</h3>

        <?php
        $Alltweets = Tweet::loadAllTweets($conn);

        foreach ($Alltweets as $tweet) {
            $currentUserObject = User::loadUserById($conn, $tweet->getUserId());
            $currentUserName = $currentUserObject->getUsername();

            echo '<div class="tweet">';

            echo '<a href="user.php?id=' . $tweet->getUserId() . '">' . '<span class="glyphicon glyphicon-user"></span>' . $currentUserName . ': </a><br>';

            echo '<em>' . $tweet->getText() . '</em><br>';

            echo '<small>' . '<span class="glyphicon glyphicon-calendar"></span>' . $tweet->getCreationDate() . '</small>';

            echo '<a id="comment" href="comment.php?id=' . $tweet->getID() . '"><span class="glyphicon glyphicon-hand-right"></span> leave a comment</a>';

            echo '</div>';
        }
        ?>

    </div>
    </body>
</html>

