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

        foreach($db->getRoomMember($_SESSION["roomName"]) as $row)
        {
            $users[] = addList($row["joinUser"], $row["latitude"], $row["longitude"]);
        }
        echo json_encode($users, JSON_UNESCAPED_UNICODE);
    }

    function addList($user, $latitude, $longitude)
    {
        return array("user" => $user, "latitude" => $latitude, "longitude" => $longitude);
    }
?>

