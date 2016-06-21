<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/17
     * Time: 17:08
     */

require_once 'chromelog.php';

class func
{
    function __construct()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=nxtg-t.net;dbname=projectP;charset=utf8;', 'projectP', 'projectP', array(PDO::ATTR_EMULATE_PREPARES => false));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch (PDOException $ex)
        {
            exit('Connection Error...' . $ex->getMessage());
        }
    }

    function checkUserId($userId)
    {
        $rows = $this->pdo->query("SELECT * FROM users WHERE id = '$userId'");

        foreach($rows as $row)
        {
            if(isset($row["id"]))
            {
                return -1;
            }
        }
        return 0;
    }

    function signUp($userId, $password, $nickName, $email)
    {
        $result = $this->pdo->query("INSERT INTO users (id, password, nickname, email) VALUES ('$userId', '$password', '$nickName', '$email')");
        return $result;
    }

    function login($userId, $password)
    {
        $rows = $this->pdo->query("SELECT * FROM users WHERE id = '$userId' AND password = '$password'");

        foreach($rows as $row)
        {
            if(isset($row['id']))
            {
                return $row;
            }
            return false;
        }
    }

    function createRoom($id, $nickname, $room, $password, $email)
    {
        $rows = $this->pdo->query("SELECT * FROM room WHERE room = '$room'");

        foreach($rows as $row)
        {
            if(isset($row["room"]))
            {
                return -1;
            }
        }

        $result = $this->pdo->query("INSERT INTO room (id, nickname, room, password, email) VALUES ('$id', '$nickname', '$room', '$password', '$email')");
        return $result;
    }

    function getRoomInfo($room)
    {
        $rows = $this->pdo->query("SELECT * FROM room WHERE room = '$room'");

        foreach($rows as $row)
        {
            return $row;
        }
    }

    function join($room, $password)
    {
        $rows = $this->pdo->query("SELECT * FROM room WHERE room = '$room' AND password = '$password'");

        foreach ($rows as $row)
        {
            if(isset($row["room"]))
            {
                return $row;
            }
            return null;
        }
    }

    function updateRoomInfo($room, $place, $date, $budget, $note)
    {
        $result = $this->pdo->query("UPDATE room SET place = '$place', date = '$date', budget = '$budget', note = '$note' WHERE room = '$room'");

        return $result;
    }
}
?>