<?php
require 'connection.php';
require 'src/Tweet.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tweet = new Tweet();
    $tweet->setUserId(1); //docelowo id prawdziwego usera z sesji
    $tweet->setText($_POST['text']);
    $tweet->setCreationDate(date('Y-m-d H:i:s'));



    var_dump($tweet->getUserId());
    var_dump($tweet->getText());
    var_dump($tweet->getCreationDate());


    $tweet->saveToDB($conn);
    //var_dump($tweet);
    $tweets = Tweet::loadAllTweets($conn);
}
?>

<html>
    <head>
        <title>MyTwitter - Main Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Twitter-Like Aplication</h1>
        <h2>WELCOME ON MAIN PAGE</h2>

        <form action="" method="POST">

            <textarea name="text"></textarea><br>

            <input type="submit" value="Add tweet"/>

        </form>

        <h3>Latest Tweets</h3>
        <?php
        foreach ($tweets as $tweet) {
            echo $tweet->getText();
            echo '<br />';
            echo '<small>' . $tweet->getCreationDate() . '</small>';
            echo '<br /><br />';
        }
        ?>

    </body>
</html>



<?php

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