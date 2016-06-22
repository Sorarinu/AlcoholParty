<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/22
     * Time: 14:04
     */

    require_once 'chromelog.php';
    require_once 'func.php';

    $func = new func();

    if (!isset($_SESSION))
    {
        session_start();
    }

    $func->removeRoomMember($_SESSION["nickName"], $_SESSION["roomName"]);
?>