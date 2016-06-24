<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/22
     * Time: 20:21
     */
    if(!isset($_SESSION))
    {
        session_start();
    }

    require_once 'chromelog.php';
    require_once 'db.php';

    $db = new db();

    $db->deleteRoom($_SESSION["roomName"], $_SESSION["id"]);

    $msg = "ルームを削除しました";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>飲み会やろうぜ</title>
    <meta http-equiv="refresh" content="1; url=index.php"> <!-- 自動的にログインページへ -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="jumbotron text-center">
        <p><h1><a href="index.php">飲み会やろうぜ 待ち合わせサイト</a></h1></p>
        <p>飲み会の待ち合わせで「お前ら何処だよ？？？」「お前こそ何処だよ？？？？」を解消するためのサービスです。</p>
    </div>
</div>

<div class="container text-center">
    <?php echo $msg ?><br>自動的ににトップページへ移動します．
</div>
</body>
</html>