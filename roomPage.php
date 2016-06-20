<?php
/**
 * Created by PhpStorm.
 * User: Sorarinu
 * Date: 2016/06/20
 * Time: 23:56
 */

    require_once 'chromelog.php';
    require_once 'func.php';

    $func = new func();

    if(!isset($_SESSION))
    {
        session_start();
    }

    $roomInfo = $func->getRoomInfo($_SESSION["roomName"]);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>飲み会やろうぜ</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>

        <script type="text/javascript">
            $(function() {
                $('#datetimepicker1').datetimepicker(
                    {
                        format: 'yyyy/MM/dd hh:mm:ss'
                    }
                );
            });
        </script>
    </head>

    <body>
        <div class="container">
            <div class="jumbotron text-center">
                <p><h1><a href="index.php">飲み会やろうぜ 待ち合わせサイト</a></h1></p>
                <p>飲み会の待ち合わせで「お前ら何処だよ？？？」「お前こそ何処だよ？？？？」を解消するためのサービスです。</p>
            </div>
        </div>

        <?php
        if (isset($_SESSION["id"])) {
            ?>
            <div class="container">
                <div class="col-md-12 text-center">
                    ようこそ <?= $_SESSION["nickName"] ?> さん　
                    <button type="button" class="btn-info" onclick="location.href='logout.php'">ログアウト</button>
                </div>
                <br><br><br>
            </div>

            <div class="col-md-6">
                <form method="post" action="">
                    <div class="panel panel-default">
                        <div class="panel-heading">ルーム名</div>
                        <div class="panel-body"><?= $roomInfo["room"] ?></div>

                        <div class="panel-heading">ルーム開設者</div>
                        <div class="panel-body"><?= $roomInfo["nickname"] ?></div>

                        <div class="panel-heading">場所</div>
                        <div class="panel-body">
                            <input type="text" class="form-control" id="place" name="place" placeholder="集合場所or開催場所を記入">
                        </div>

                        <div class="panel-heading">集合時間</div>
                        <div class="panel-body">
                            <input type="text" class="form-control" id="datetime" name="datetime" placeholder="集合時間を記入">
                        </div>

                        <div class="panel-heading">予算</div>
                        <div class="panel-body">
                            <input type="text" class="form-control" id="budget" name="budget" placeholder="予算を記入">
                        </div>

                        <div class="panel-heading">備考</div>
                        <div class="panel-body">
                            <input type="text" class="form-control" id="note" name="note" placeholder="備考を記入">
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                マップエリア
            </div>

            <div class="col-md-12" align="right">
                <button type="button" class="btn-primary btn-lg" onclick="location.href=''">更新</button>
            </div>
            <?php
        }
        ?>
    </body>
</html>

