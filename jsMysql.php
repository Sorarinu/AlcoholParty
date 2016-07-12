<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/25
     * Time: 12:43
     */
    if(!isset($_SESSION))
    {
        session_start();
    }

    require_once 'chromelog.php';
    require_once 'db.php';
    $db = new db();

    if(isset($_POST))
    {
        ChromePhp::log("latitude=" . $_POST["latitude"] . " " . $_POST["longitude"]);
        ChromePhp::log("jsMysql.php: " . $_SESSION["nickName"]);
        $db->updatePosition($_SESSION["roomName"], $_SESSION["nickName"], $_POST["latitude"], $_POST["longitude"]);
        $users = array();

        foreach($db->getRoomMember($_SESSION["roomName"]) as $row)
        {
            foreach($db->getUserDataAsName($row["joinUser"]) as $userData)
            {
                $users[] = addList($row["joinUser"], $userData["img"], $row["latitude"], $row["longitude"]);
            }
        }
        echo json_encode($users, JSON_UNESCAPED_UNICODE);
    }

    function addList($user, $img, $latitude, $longitude)
    {
        return array("session" => $_SESSION["nickName"], "user" => $user, "img" => $img, "latitude" => $latitude, "longitude" => $longitude);
    }
?>

