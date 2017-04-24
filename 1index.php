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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['text'])) {

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
    </head>
    <body>
        <a href="register.php">register</a>
        <a href="login.php">login</a>
        <a href="logout.php">logout</a>
        <h1>Twitter-Like Aplication</h1>
        <h2>WELCOME ON MAIN PAGE <?php echo $userName?></h2>
        <form action="" method="POST">

            <textarea name="text"></textarea><br>

            <input type="submit" value="Add tweet"/>

        </form>

        <h3>Latest Tweets</h3>

        <?php
        $Alltweets = Tweet::loadAllTweets($conn);

        foreach ($Alltweets as $tweet) {
            $currentUserObject = User::loadUserById($conn, $tweet->getUserId());
            $currentUserName = $currentUserObject->getUsername();
            echo $currentUserName . ': <br>';
            echo $tweet->getText();
            echo '<br />';
            echo '<small>' . $tweet->getCreationDate() . '</small>';
            echo '<br /><br />';
        }
        ?>

    </body>
</html>



<?php


//////////////////////// add user

   // $user1 = new User();

   // var_dump($user1);

   //  $user1->setUsername('Romek');
   // $user1->setPass('qwer');
   // $user1->setEmail('wq@example.com');

   // var_dump($user1);

   // $user1->saveToDB($conn);

   // var_dump($user1);


////////////////////// add tweet

// $tweet = new Tweet();
// $tweet->setUserId(1);
// $tweet->setText('siemka');
// $tweet->setCreationDate(date('Y-m-d H:i:s'));

// $tweet->saveToDB($conn);

// var_dump($tweet);


/////////////////////// load tweet by ID

//    $loadTweet = Tweet::loadTweetById($conn, 6);

//    var_dump($loadTweet);



/////////////////////// load All Tweets By UserId

//    $loadAlBuUserId = Tweet::loadAllTweetsByUserId($conn, 2);
//    var_dump($loadAlBuUserId);


/////////////////////// load All Tweets

 //   $loadAllUsers = Tweet::loadAllTweets($conn);
 //   var_dump($loadAllUsers);


     ///////////////// load by Email

//    $loadByEmail = User::loadUserByEmail($conn, 'k@example.com');
//    var_dump($loadByEmail);

    ///////////////////deleting tweet

 //       $loadTweet = Tweet::loadTweetById($conn, 6);

 //        $loadTweet->delete($conn);



/*
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$tweet = new Tweet();

$tweet->setUserId(1); //  Zmienić na id z sesji
$tweet->setText($_POST['text']); // NIEBEZPIECZNE!!!!!!!!
$tweet->setCreationDate(date('Y-m-d H:i:s')); // ?

$tweet->saveToDB($conn);

echo var_dump($tweet);
}

$tweets = Tweet::loadAllTweets($conn);

?>
<html>
    <body>
        <h1>Twitter App</h1>
        <h2>Main page</h2>
        <hr />

        <form action="" method="post">
            <textarea name="text"></textarea>
            <br />
            <input type="submit" value="Add tweet" />
        </form>
        <hr />

        <h4>Latest tweets</h4>
        <?php
        foreach ($tweets as $tweet) {
            /**
             * @var $tweet Tweet
             
            echo $tweet->getText();
            echo '<br />';
            echo '<small>' . $tweet->getCreationDate() . '</small>';
            echo '<br /><br />';
        }
        ?>
    </body>
</html>
*/