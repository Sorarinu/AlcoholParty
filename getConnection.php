<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/22
     * Time: 12:00
     */
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once 'db.php';
    require_once 'chromelog.php';

    $db = new db();

    if (isset($_POST)) {
        $rows = $db->getRoomMember($_SESSION["roomName"]);
        $html = "";

        foreach ($rows as $row) {
            $html .= "<li class=\"list-group-item\">" . $row["joinUser"] . "</li>";
        }

        echo $html;
    }
?>