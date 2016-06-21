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

    if(isset($_POST["update"]))
    {
        $result = $func->updateRoomInfo($roomInfo["room"],
            $_POST["place"] !== "" ? $_POST["place"] : $roomInfo["place"],
            $_POST["datetime"] !== "" ? $_POST["datetime"] : $roomInfo["date"],
            $_POST["budget"] !== "" ? $_POST["budget"] : $roomInfo["budget"],
            $_POST["note"] !== "" ? $_POST["note"] : $roomInfo["note"]
        );
        $roomInfo = $func->getRoomInfo($_SESSION["roomName"]);
        $_POST = array();
    }
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
    </head>

    <body>
        <div class="container">
            <div class="jumbotron text-center">
                <p><h1><a href="index.php">飲み会やろうぜ 待ち合わせサイト</a></h1></p>
                <p>飲み会の待ち合わせで「お前ら何処だよ？？？」「お前こそ何処だよ？？？？」を解消するためのサービスです。</p>
            </div>
        </div>

        <?php
        if (isset($_SESSION["id"]))
        {
            ?>
            <div class="container">
                <div class="col-md-12 text-center">
                    ようこそ <?= $_SESSION["nickName"] ?> さん　
                    <button type="button" class="btn-info" onclick="location.href='logout.php'">ログアウト</button>
                </div>
                <br><br><br>
            </div>

            <?php
            if($_SESSION["nickName"] === $roomInfo["nickname"])
            {
                ?>

                <div class="col-md-4">
                    <form method="post" action="<?php print($_SERVER['PHP_SELF']) ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">ルーム名</div>
                            <div class="panel-body"><?= $roomInfo["room"] ?></div>

                            <div class="panel-heading">ルーム開設者</div>
                            <div class="panel-body"><?= $roomInfo["nickname"] ?></div>

                            <div class="panel-heading">場所</div>
                            <div class="panel-body">
                                <?= $roomInfo["place"] ?>
                                <input type="text" class="form-control" id="place" name="place"
                                       placeholder="集合場所or開催場所を記入">
                            </div>

                            <div class="panel-heading">集合時間</div>
                            <div class="panel-body">
                                <?= $roomInfo["date"] ?>
                                <input type="text" class="form-control" id="datetime" name="datetime"
                                       placeholder="集合時間を記入">
                            </div>

                            <div class="panel-heading">予算</div>
                            <div class="panel-body">
                                <?= $roomInfo["budget"] ?>
                                <input type="text" class="form-control" id="budget" name="budget" placeholder="予算を記入">
                            </div>

                            <div class="panel-heading">備考</div>
                            <div class="panel-body">
                                <?= $roomInfo["note"] ?>
                                <input type="text" class="form-control" id="note" name="note" placeholder="備考を記入">
                            </div>
                        </div>
                        <div class="col-md-12" align="right">
                            <p><input type="submit" id="update" name="update" class="btn-primary btn-lg" value="更新"></p>
                        </div>
                    </form>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">接続中のユーザ</div>
                        <ul class="list-group">
                            <li class="list-group-item">User1</li>
                            <li class="list-group-item">User2</li>
                            <li class="list-group-item">User3</li>
                            <li class="list-group-item">User4</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">マップエリア</div>
                        <div class="panel-body">
                            <div class="google-maps">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3243.0483586847345!2d139.3381578263927!3d35.62653432616566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60191da6d0a3a261%3A0x337318568a7aaa3b!2z5p2x5Lqs5bel56eR5aSn5a2mIOWFq-eOi-WtkOOCreODo-ODs-ODkeOCuQ!5e0!3m2!1sja!2sjp!4v1466492244153" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            else
            {
                ?>

                <div class="col-md-4">
                    <form method="post" action="">
                        <div class="panel panel-default">
                            <div class="panel-heading">ルーム名</div>
                            <div class="panel-body"><?= $roomInfo["room"] ?></div>

                            <div class="panel-heading">ルーム開設者</div>
                            <div class="panel-body"><?= $roomInfo["nickname"] ?></div>

                            <div class="panel-heading">場所</div>
                            <div class="panel-body"><?= $roomInfo["place"] ?></div>

                            <div class="panel-heading">集合時間</div>
                            <div class="panel-body"><?= $roomInfo["date"] ?></div>

                            <div class="panel-heading">予算</div>
                            <div class="panel-body"><?= $roomInfo["budget"] ?></div>

                            <div class="panel-heading">備考</div>
                            <div class="panel-body"><?= $roomInfo["note"] ?></div>
                        </div>
                    </form>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">接続中のユーザ</div>
                        <ul class="list-group">
                            <li class="list-group-item">User1</li>
                            <li class="list-group-item">User2</li>
                            <li class="list-group-item">User3</li>
                            <li class="list-group-item">User4</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">マップエリア</div>
                        <div class="panel-body">
                            <div class="google-maps">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3243.0483586847345!2d139.3381578263927!3d35.62653432616566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60191da6d0a3a261%3A0x337318568a7aaa3b!2z5p2x5Lqs5bel56eR5aSn5a2mIOWFq-eOi-WtkOOCreODo-ODs-ODkeOCuQ!5e0!3m2!1sja!2sjp!4v1466492244153" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </body>
</html>

