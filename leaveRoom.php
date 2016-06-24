<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/22
     * Time: 14:04
     */
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once 'chromelog.php';
    require_once 'db.php';

    $db = new db();

    $db->removeRoomMember($_SESSION["nickName"], isset($_SESSION["roomName"]) ? $_SESSION["roomName"] : null);
?>