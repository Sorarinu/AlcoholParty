<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/18
     * Time: 23:50
     */
    if (!isset($_SESSION))
    {
        session_start();
    }

    //require_once 'chromelog.php';
    require_once 'leaveRoom.php';

    if (!isset($_SESSION["id"]))
    {
        $msg = "セッションがタイムアウトしました";
    } else
    {
        $msg = "ログアウトしました";
    }

    $_SESSION = array();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Alcohol Party</title>
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
        <p>

        <h1><a href="index.php">Alcohol Party</a></h1></p>
        <p>飲み会の待ち合わせで「お前ら何処だよ？？？」「お前こそ何処だよ？？？？」を解消するためのサービスです。</p>
    </div>
</div>

<div class="container text-center">
    <?php echo $msg ?><br>自動的ににトップページへ移動します．
</div>
</body>
</html>
