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

    function signUp($userId, $password, $nickName, $email)
    {
        $result = $this->pdo->prepare("INSERT INTO users (id, password, nickname, email) VALUES ('$userId', '$password', '$nickName', '$email')");
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

    function createRoom($nickName, $room, $password, $email)
    {
        $rows = $this->pdo->query("SELECT * FROM room WHERE room = '$room'");

        foreach($rows as $row)
        {
            if(isset($row['room']))
            {
                return -1;
            }
        }

        $result = $this->pdo->query("INSERT INTO room (nickname, room, password, email) VALUES ('$nickName', '$room', '$password', '$email')");
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

    /*function createTable()
    {
        return $this->pdo->query("CREATE TABLE my_table (id INTEGER NOT NULL, name VARCHAR(32), address VARCHAR(50), email VARCHAR(50))");
    }

    function deleteTable()
    {
        return $this->pdo->query("DROP TABLE my_table");
    }

    public function toInsert($name, $address, $email)
    {
        $stmt = $this->pdo->prepare("INSERT INTO my_table (name, address, email) VALUES (:name, :address, :email)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }

    public function getData()
    {
        $rows = $this->pdo->query("SELECT * FROM my_table");
        return $rows;
    }

    public function searchData($name, $address, $email)
    {
        $query = "SELECT * FROM my_table WHERE ";
        $option = "";

        if($name === "null" && $address === "null" && $email === "null")
        {
            $rows = $this->pdo->query("SELECT * FROM my_table");
            return $rows;
        }

        if($name !== "null")
        {
            $option .= ($option !== "") ? "and name like '%" . $name . "%' " : "name like '%" . $name . "%' ";
        }
        if($address !== "null")
        {
            $option .= ($option !== "") ? "and address like '%" . $address . "%' " : "address like '%" . $address . "%' ";
        }
        if($email !== "null")
        {
            $option .= ($option !== "") ? "and email like '%" . $email . "%' " : "email like '%" . $email . "%' ";
        }

        $rows = $this->pdo->query($query . $option);
        return $rows;
    }

    public function changeData($id, $name, $address, $email)
    {
        $this->pdo->query("update my_table set id='" . $id . "', name='" . $name . "', address='" . $address . "', email='" . $email . "' where id='" . $id . "'");
    }

    public function  deleteData($id)
    {
        $this->pdo->query("DELETE FROM my_table WHERE id LIKE '%" . $id . "%'");
    }*/
}
?>