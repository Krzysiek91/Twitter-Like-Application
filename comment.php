<?php
session_start();
if (!isset($_SESSION['userID'])){
    header('Location: index.php');
}else{
    $userID = $_SESSION['userID'];
}
    require 'connection.php';
    require 'src/Tweet.php';
    require 'src/User.php';
    require 'src/Comment.php';


    $tweetID = $_GET['id'];
    $tweet = Tweet::loadTweetById($conn, $tweetID);
    $userOfTweetID = $tweet->getUserId();

    $userOfTweet = User::loadUserById($conn, $userOfTweetID);
$userOfTweetName = $userOfTweet->getUsername();

    $comments = Comment::loadAllCommentsByTweetID($conn, $tweetID);

    if($comments!=null) {
        $comments = array_reverse($comments);
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $comment = new Comment();

        $comment->setUserID($userID);
        $comment->setTweetID($tweetID);
        $comment->setComment($_POST['comment']);
        $comment->setCreationDate(date('Y-m-d H:i:s'));
        $comment->saveToDB($conn);
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

<div class="container-fluid col-md-6 col-md-offset-3">

    <?php

    echo '<div class="tweet">';
    //tweet
    echo '<a href="user.php?id=' . $tweet->getUserId() . '">' . '<span class="glyphicon glyphicon-user"></span>' . $userOfTweetName . ': </a><br>';

    echo '<em><b>' . $tweet->getText() . '</b></em><br>';

    echo '<small>' . '<span class="glyphicon glyphicon-calendar"></span>' . $tweet->getCreationDate() . '</small>';

    echo '</div>';

    ?>

    <form action="" method="POST">

        <textarea class="form-control" rows="2" name="comment" placeholder="Comment the Tweet"></textarea>
        <button type="submit" class="btn btn-basic btn-xs">Add your comment</button>

    </form>

    <?php
    //comment to tweet

    if($comments != null) {
        foreach ($comments as $comment) {

            $commentID = $comment->getID();
            $userOfCommentID = $comment->getUserID();
            $userOfComment = User::loadUserById($conn, $userOfCommentID);
            $userOfCommentName = $userOfComment->getUsername();

            echo '<div class="comment">';

            echo '<a href="user.php?id=' . $userOfCommentID . '">' . '<span class="glyphicon glyphicon-user"></span>' . $userOfCommentName . '</a><br>';

             echo $comment->getComment() . '<br>';

             echo '<span class="glyphicon glyphicon-calendar"></span>' . $comment->getCreationDate();

             echo '</div>';

        }
    }

    ?>

</div>

</body>
</html>