<?php

class Tweet {

    const NON_EXISTING_ID = -1;

    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct()
    {
        $this->id = self::NON_EXISTING_ID;
        $this->userId = self::NON_EXISTING_ID;
        $this->text = '';
        $this->creationDate = (date('Y-m-d H:i:S'));
    }

    public function getId()
    {
        return $this->id;
    }


    public function getUserId()
    {
        return $this->userId;
    }


    public function setUserId($userId)
    {
        $this->userId = $userId;
    }


    public function getText()
    {
        return $this->text;
    }


    public function setText($text)
    {
        $this->text = $text;
    }


    public function getCreationDate()
    {
        return $this->creationDate;
    }


    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }


    static public function loadTweetById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Tweets WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedTweet = new Tweet();

            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['user_id'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creation_date'];

            return $loadedTweet;
        }

        return null;
    }



    static public function loadAllTweetsByUserId(PDO $conn, $userId)
    {
        $sql = "SELECT * FROM Tweets WHERE user_id = :user_id ORDER BY id DESC";

        $stmt = $conn->prepare($sql);

        $result = $stmt->execute([
            'user_id' => $userId
        ]);

        $ret = [];

        if ($result !== false && $stmt->rowCount() != 0) {

            $arrayOfTweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($arrayOfTweets as $row) {
                $loadTweet = new Tweet();
                $loadTweet->id = $row['id'];
                $loadTweet->userId = $row['user_id'];
                $loadTweet->text = $row['text'];
                $loadTweet->creationDate = $row['creation_date'];

                $ret[] = $loadTweet;
            }

            return $ret;
        }
    }



    static public function loadAllTweets(PDO $conn)
    {
        $sql = "SELECT * FROM Tweets ORDER BY id DESC";
        $ret = [];
        $result = $conn->query($sql);

        if ($result !== false && $result->rowCount() != 0) {
            foreach ($result as $row) {

                $loadedTweet = new Tweet();

                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creation_date'];

                $ret[] = $loadedTweet;
            }
        }

        return $ret;
    }



    public function saveToDB(PDO $conn)
    {
        if ($this->id == self::NON_EXISTING_ID) {
            //Saving new user to DB
            $stmt = $conn->prepare('INSERT INTO Tweets(user_id, text, creation_date) VALUES(:user_id, :text, :creation_date)');

            $result = $stmt->execute([
                'user_id' => $this->userId,
                'text' => $this->text,
                'creation_date' => $this->creationDate
            ]);

            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            // Updating existing user
            $stmt = $conn->prepare(
                    'UPDATE Tweets SET user_id=:user_id, text=:text, creation_date=:creation_date WHERE id=:id'
            );

            $result = $stmt->execute([
                'user_id' => $this->userId,
                'text' => $this->text,
                'creation_date' => $this->creationDate,
                'id' => $this->id
            ]);

            if ($result === true) {
                return true;
            }
        }

        return false;
    }



    public function delete(PDO $conn)
    {
        if ($this->id != self::NON_EXISTING_ID) {
            $stmt = $conn->prepare('DELETE FROM Tweets WHERE id=:id');
            $result = $stmt->execute(['id' => $this->id]);

            if ($result === true) {
                $this->id = self::NON_EXISTING_ID;

                return true;
            }

            return false;
        }

        return true;
    }

}
