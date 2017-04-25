<?php
class Message
{

    // for objects that are not in the database
    const NON_EXISTING_ID = -1;

    const READ_MSG = 1;
    const UNREAD_MSG = -1;

    private $id;
    private $senderID;
    private $recipientID;
    private $message;
    private $isRead;
    private $creationDate;



    function __construct()
    {
        $this->id = self::NON_EXISTING_ID;
        $this->senderID = self::NON_EXISTING_ID;
        $this->recipientID = self::NON_EXISTING_ID;
        $this->message = '';
        $this->isRead = self::UNREAD_MSG;
        $this->creationDate = '';

    }

 ///////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }


    public function getSenderID()
    {
        return $this->senderID;
    }


    public function getRecipientID()
    {
        return $this->recipientID;
    }


    public function getMessage()
    {
        return $this->message;
    }


    public function getIsRead()
    {
        return $this->isRead;
    }


    public function getCreationDate()
    {
        return $this->creationDate;
    }


///////////////////////////////////////////

    public function setSenderID($senderID)
    {
        $this->senderID = $senderID;
    }


    public function setRecipientID($recipientID)
    {
        $this->recipientID = $recipientID;
    }


    public function setMessage($message)
    {
        $this->message = $message;
    }


    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }


    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    static public function loadMessageByID(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Messages WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->senderID = $row['sender_id'];
            $loadedMessage->recipientID = $row['recipient_id'];
            $loadedMessage->message = $row['message_text'];
            $loadedMessage->isRead = $row['is_read'];
            $loadedMessage->creationDate = $row['creation_date'];

            return $loadedMessage;
        }
        return null;
    }

    static public function loadAllMessagesBySenderID(PDO $conn, $senderID)
    {
        $stmt = $conn->prepare('SELECT * FROM Messages WHERE sender_id=:sender_id');

        $result =$stmt->execute(['sender_id' => $senderID]);

        if($result !== false && $stmt->rowCount() != 0){

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderID = $row['sender_id'];
                $loadedMessage->recipientID = $row['recipient_id'];
                $loadedMessage->message = $row['message_text'];
                $loadedMessage->isRead = $row['is_read'];
                $loadedMessage->creationDate = $row['creation_date'];

                $ret[] = $loadedMessage;
            }
            return $ret;
        }
        }

    static public function loadAllMessagesByRecipientID(PDO $conn, $recipientID)
    {
        $stmt = $conn->prepare('SELECT * FROM Messages WHERE recipient_id=:recipient_id');

        $result =$stmt->execute(['recipient_id' => $recipientID]);

        if($result !== false && $stmt->rowCount() != 0){

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderID = $row['sender_id'];
                $loadedMessage->recipientID = $row['recipient_id'];
                $loadedMessage->message = $row['message_text'];
                $loadedMessage->isRead = $row['is_read'];
                $loadedMessage->creationDate = $row['creation_date'];

                $ret[] = $loadedMessage;
            }
            return $ret;
        }
    }


    public function saveToDB(PDO $conn)
    {
        if($this->id == self::NON_EXISTING_ID){
            $stmt = $conn->prepare(
                'INSERT INTO Messages(sender_id, recipient_id, message_text, is_read, creation_date) VALUES (:sender_id, :recipient_id, :message_text, :is_read, :creation_date)'
            );

            $result = $stmt->execute(
                [
                    'sender_id' => $this->senderID,
                    'recipient_id' => $this->recipientID,
                    'message_text' => $this->message,
                    'is_read' => $this->isRead,
                    'creation_date' => $this->creationDate
                ]
            );

            if($result === true){
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
    }
}