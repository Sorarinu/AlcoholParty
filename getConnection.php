<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/22
     * Time: 12:00
     */
    if(!isset($_SESSION))
    {
        session_start();
    }

    require_once 'func.php';
    require_once 'chromelog.php';

    $func = new func();

    if (isset($_POST))
    {
        $rows = $func->getRoomMember($_SESSION["roomName"]);
        $html = "";

        foreach ($rows as $row)
        {
            $html .= "<li class=\"list-group-item\">" . $row["joinUser"] . "</li>";
        }

        echo $html;
    }
?>