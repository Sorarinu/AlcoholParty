<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/22
     * Time: 20:21
     */
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once 'chromelog.php';
    require_once 'db.php';
    require_once 'mail.php';

    $db = new db();
    $mail = new snedMail();

    $db->deleteRoom($_SESSION["roomName"], $_SESSION["id"]);
    $mail->sendDeleteRoom($_SESSION["mail"], $_SESSION["nickName"], $_SESSION["roomName"]);

    unset($_SESSION["roomName"]);
    $msg = "ルームを削除しました";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>飲み会やろうぜ</title>
    <meta http-equiv="refresh" content="1; url=index.php"> <!-- 自動的にログインページへ -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="jumbotron text-center">
        <p>

        <h1><a href="index.php">飲み会やろうぜ 待ち合わせサイト</a></h1></p>
        <p>飲み会の待ち合わせで「お前ら何処だよ？？？」「お前こそ何処だよ？？？？」を解消するためのサービスです。</p>
    </div>
</div>

<div class="container text-center">
    <?php echo $msg ?><br>自動的ににトップページへ移動します．
</div>
</body>
</html>