<?php
session_start();
if(!isset($_SESSION['userID'])) {
    header('Location: index.php');
}

    require_once 'connection.php';
    require 'src/User.php';
    require 'src/Message.php';

    $userID = $_GET['id'];

    if($userID !== $_SESSION['userID']){
        header('Location: index.php');
    }

    $sentMessages = Message::loadAllMessagesBySenderID($conn, $userID);
    $receivedMessages = Message::loadAllMessagesByRecipientID($conn, $userID);


?>


    <html>
    <head>
        <title>Messages</title>
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
    <div id="receivedMSG" class="col-md-4 col-md-offset-4">
        <?php

            echo '<h3>Received Messages</h3>';

              if($receivedMessages != null) {
                  foreach ($receivedMessages as $message) {
                     echo '<span class="message-date"><span class="glyphicon glyphicon-calendar"></span> ' . $message->getCreationDate() . '<br>';
                     $senderID = $message->getSenderID();
                     echo 'Message from: ' .

                          '<a href ="user.php?id=' . $senderID . '">' .
                          User::loadUserById($conn, $message->getSenderID())->getUsername() .
                          '</a>';

                     echo '<p><b><em>' . $message->getMessage() . '</em></b></p>';
              }
          }else{
                  echo '<h>You haven\'t received any message</h>';
              }

              echo '<h3>Sent Messages</h3>';

              if($sentMessages != null) {
                  foreach ($sentMessages as $message) {
                      echo '<span class="message-date"><span class="glyphicon glyphicon-calendar"></span> ' . $message->getCreationDate() . '<br>';
                      $recipientID = $message->getRecipientID();
                      echo 'Message to: ' .

                           '<a href ="user.php?id=' . $recipientID . '">' .
                           User::loadUserById($conn, $recipientID)->getUsername() .
                           '</a>';

                      echo '<p><b><em>' . $message->getMessage() . '</em></b></p>';
                  }

          }else{
              echo '<h5>You haven\'t sent any message</h5>';
          }

        ?>
    </div>


    </body>
    </html>