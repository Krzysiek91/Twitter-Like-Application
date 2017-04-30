<?php
session_start();
if(!isset($_SESSION['userID'])){
    header ('Location: index.php');
}else{
    $loggedUserID = $_SESSION['userID'];
}


    require_once 'connection.php';
    require 'src/User.php';
    require 'src/Tweet.php';
    require 'src/Message.php';

    //These are data of User that we are at page of (not logged one)
    $userID = $_GET['id'];
    $user = User::loadUserById($conn, $userID);
    $userTweets = Tweet::loadAllTweetsByUserId($conn, $userID);

    if($_SERVER['REQUEST_METHOD'] === 'POST')
        if(isset($_POST['message'])){
        $message = new Message;

        $message->setSenderID($loggedUserID);
        $message->setRecipientID($userID);
        $message->setMessage($_POST['message']);
        $message->setCreationDate(date('Y-m-d H:i:s'));

        $message->saveToDB($conn);

        $successMsg = 'Message has benn successfully sent';


    }


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

    <div class="col-md-4 col-md-offset-1">
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

    <div class="col-md-4 col-md-offset-1">
        <h4><kbd>Sent Message</kbd></h4>
      <?php
        echo '<form action="" method="post">';
        echo '<div class="form-group">';
        echo '<p><textarea placeholder="send message to this user" name="message" rows="4" class="form-control"></textarea></p>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-basic">Send</button>';
        echo '</form>';

      if (isset($successMessage)) {
          echo '<div class="alert alert-success">';
          echo $successMessage;
          echo '</div>';
      }
      ?>
    </div>

</div>
</body>
</html>