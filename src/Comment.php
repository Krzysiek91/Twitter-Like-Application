<?php

class Comment
{
    const NON_EXISTING_ID = -1;

    private $id;
    private $userID;
    private $tweetID;
    private $comment;
    private $creationDate;


    public function __construct()
    {
        $this->id = self::NON_EXISTING_ID;
        $this->userID = self::NON_EXISTING_ID;
        $this->tweetID = self::NON_EXISTING_ID;
        $this->comment = '';
        $this->creationDate = (date('Y-m-d H:i:S'));
    }


    public function getId()
    {
        return $this->id;
    }


    public function getUserID()
    {
        return $this->userID;
    }


    public function getTweetID()
    {
        return $this->tweetID;
    }


    public function getComment()
    {
        return $this->comment;
    }


    public function getCreationDate()
    {
        return $this->creationDate;
    }

    ///////////////////////////////////////


    public function setUserID($userID)
    {
        $this->userID = $userID;
    }


    public function setTweetID($tweetID)
    {
        $this->tweetID = $tweetID;
    }


    public function setComment($comment)
    {
        $this->comment = $comment;
    }


    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    //////////////////////////////////////////////

    static public function loadCommentById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Comments WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userID = $row['user_id'];
            $loadedComment->tweetID = $row['tweet_id'];
            $loadedComment->comment = $row['comment_text'];
            $loadedComment->creationDate = $row['creation_date'];

            return $loadedComment;
        }
        return null;
    }

    static public function loadAllCommentsByTweetID(PDO $conn, $tweetID)
    {
        $stmt = $conn->prepare('SELECT * FROM Comments WHERE tweet_id=:tweet_id');
        $result = $stmt->execute(['tweet_id' => $tweetID]);

        if ($result === true && $stmt->rowCount() > 0) {
            $ret = [];

            $arrayOfComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($arrayOfComments as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userID = $row['user_id'];
                $loadedComment->tweetID = $row['tweet_id'];
                $loadedComment->comment = $row['comment_text'];
                $loadedComment->creationDate = $row['creation_date'];
                $ret[] = $loadedComment;
            }

            return $ret;
        }
        return null;
    }

    public function saveToDB(PDO $conn)
    {
     if ($this->id == self::NON_EXISTING_ID){
         $stmt = $conn->prepare(
             'INSERT INTO Comments(user_id, tweet_id, comment_text, creation_date) VALUES (:userID, :tweetID, :comment, :creationDate)'
         );

         $result = $stmt->execute(
             [
                 'userID' => $this->userID,
                 'tweetID' => $this->tweetID,
                 'comment' => $this->comment,
                 'creationDate' => $this->creationDate
             ]
         );
         if($result === true){
             $this->id = $conn->lastInsertId();
             return true;
         }
     }else{
         echo 'you are not allowed to update your comment';
     }
    }
}