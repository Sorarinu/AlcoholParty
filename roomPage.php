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
    $joinResult = $func->joinRoomMember($_SESSION["nickName"], $_SESSION["roomName"]);

    if(isset($_POST["update"]))
    {
        $result = $func->updateRoomInfo(
            $roomInfo["room"],
            $_POST["place"] !== "" ? $_POST["place"] : $roomInfo["place"],
            $_POST["datetime"] !== "" ? $_POST["datetime"] : $roomInfo["date"],
            $_POST["budget"] !== "" ? $_POST["budget"] : $roomInfo["budget"],
            $_POST["note"] !== "" ? $_POST["note"] : $roomInfo["note"]
        );
        $roomInfo = $func->getRoomInfo($_SESSION["roomName"]);
        $_POST = array();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>飲み会やろうぜ</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/geolocation-api.css" rel="stylesheet">

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8H1PLQFo84FkLoVfVkpf-2i9FQc-YDRs"></script>
        <script src="js/realtimeFlush.js"></script>
        <script src="js/watch-position.js"></script>

        <script type="text/javascript">
            $(window).unload(function() {
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "leaveRoom.php",
                    success: function(){}
                });
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
        if (isset($_SESSION["id"]))
        {
            ?>
            <p>
                <div class="col-md-12 text-right">
                    ようこそ <?= $_SESSION["nickName"] ?> さん　
                    <input type="button" class="btn-info" onclick="location.href='logout.php'" value="ログアウト"><br><br>
                </div>
            </P>

            <?php
            if($_SESSION["nickName"] === $roomInfo["nickname"])
            {
                ?>

                <p>
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn-danger" onclick="location.href='deleteRoom.php'">ルームを削除する</button><br><br>
                    </div>
                </p>

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
                            <div id="after" style="display:none">
                                <div id="after_detail"></div>
                            </div>
                        </ul>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">マップエリア</div>
                        <div class="panel-body">
                            <div class="map-wrapper">
                                <div id="map-canvas"></div>
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
                            <div id="after" style="display:none">
                                <div id="after_detail"></div>
                            </div>
                        </ul>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">マップエリア</div>
                        <div class="panel-body">
                            <div class="map-wrapper">
                                <div id="map-canvas"></div>
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

