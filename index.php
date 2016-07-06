<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/17
     * Time: 15:00
     */
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once 'mail.php';
    require_once 'chromelog.php';
    require_once 'db.php';

    $db = new db();
    $mail = new sendMail();

    if (isset($_POST["create"])) {
        if ($_POST["roomName"] !== "" && $_POST["roomPassword"] !== "" && $_POST["confRoomPassword"] !== "") {
            if($_POST["roomName"] !== "room" && $_POST["roomName"] !== "users")
            {
                if ($_POST["roomPassword"] === $_POST["confRoomPassword"])
                {
                    $result = $db->createRoom($_SESSION["id"], $_SESSION["nickName"], $_POST["roomName"], $_POST["roomPassword"], $_SESSION["email"]);

                    if ($result === -1)
                    {
                        $createMsg = "Error：入力されたルーム名は既に使用されています";
                        $_POST = array();
                    } else
                    {
                        $db->createRoomTable($_POST["roomName"]);

                        $createMsg = "Success：新規ルームの作成が完了しました．";
                        $_SESSION += array("roomName" => $_POST["roomName"]);
                        $mail->sendNewRoom($_SESSION["email"], $_SESSION["nickName"], $_SESSION["roomName"]);
                    }

                } else
                {
                    $createMsg = "Error：パスワードが一致しません";
                    $_POST = array();
                }
            }
            else{
                $createMsg = "Error：指定されたルーム名は使用できません";
                $_POST = array();
            }
        }
        else {
            $createMsg = "Error：必要事項が入力されていません";
            $_POST = array();
        }
    }
    else if (isset($_POST["join"])) {
        if ($_POST["roomName"] !== "" && $_POST["roomPassword"] !== "") {
            $roomName = filter_input(INPUT_POST, "roomName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $roomPassword = filter_input(INPUT_POST, "roomPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $db->join($roomName, $roomPassword);

            unset($_SESSION["roomName"]);   //ゴミを破棄

            if ($result !== null) {
                $_SESSION += array("roomName" => $roomName);
                $_SESSION += array("joinDate" => date());
                $_POST = array();
                header("Location: roomPage.php");
                exit;
            }
            else {
                $joinMsg = "Error：該当するルームが存在しません";
                unset($_SESSION["roomName"]);
                $_POST = array();
            }
        }
        else {
            $joinMsg = "Error：必要事項が入力されていません";
            unset($_SESSION["roomName"]);
            $_POST = array();
        }
    }
    else if (isset($_POST["signIn"])) {
        $userId = filter_input(INPUT_POST, "userId", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userPassword = filter_input(INPUT_POST, "userPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user = $db->login($userId, $userPassword);

        if ($user !== null) {
            //セッション保存
            session_regenerate_id(true);
            $_SESSION = array(
                "id" => $user["id"],
                "nickName" => $user["nickname"],
                "email" => $user["email"]
            );
        }
        else {
            $signInMsg = "Error：ログインに失敗しました";
            $_POST = array();
        }
    }
    else if (isset($_POST["signUp"])) {
        if ($_POST["userId"] !== "" && $_POST["userPassword"] !== "" && $_POST["confUserPassword"] !== "" && $_POST["userNickName"] !== "" && $_POST["userEmail"] !== "") {
            if ($_POST["userPassword"] === $_POST["confUserPassword"]) {
                $userId = filter_input(INPUT_POST, "userId", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $userPassword = filter_input(INPUT_POST, "userPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $userNickName = filter_input(INPUT_POST, "userNickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_VALIDATE_EMAIL);

                if ($db->checkUserId($userId) !== -1) {
                    if ($userEmail !== false) {
                        $result = $db->signUp($userId, $userPassword, $userNickName, $userEmail);
                        $mail->sendNewAccount($userEmail, $userId);
                        $signUpMsg = "Success：ユーザ登録が完了しました！登録されたメールアドレスに確認メールを送信したから見てね！！";
                    }
                    else {
                        $signUpMsg = "メールアドレスの形式が正しくありません";
                        $_POST = array();
                    }
                }
                else {
                    $signUpMsg = "Error：入力されたIDは使用できません";
                    $_POST = array();
                }
            }
            else {
                $signUpMsg = "Error：パスワードが一致しません";
                $_POST = array();
            }
        }
        else {
            $signUpMsg = "Error：必要事項が入力されていません";
            $_POST = array();
        }

    }
    else {
        ChromePhp::log("Error..");
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Alcohol Party</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="jumbotron text-center">
        <p>

        <h1><a href="index.php">Alcohol Party</a></h1></p>
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

        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">ルーム</a></li>
            <li><a href="#tab2" data-toggle="tab">ユーザ情報</a></li>
            <li><a href="#tab3" data-toggle="tab">オススメ</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <!-- 新規ルーム作成 -->
                <p>
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                新しくルームを作成する
                            </div>

                            <div class="panel-body">
                                <?php
                                    if (isset($createMsg))
                                    {
                                        if ($createMsg !== "Success：新規ルームの作成が完了しました．")
                                        {
                                            ?>
                                            <div class="alert alert-danger" role="alert"><?= $createMsg ?></div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="alert alert-success" role="alert"><?= $createMsg ?> <a href="roomPage.php" class="alert-link">詳細・設定ページへ</a></div>
                                            <?php
                                        }
                                    }
                                ?>
                                <form action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
                                    <p>

                                    <div class="input-group">
                                        <span class="input-group-addon">ルーム名</span>
                                        <input type="text" name="roomName" class="form-control" placeholder="ルーム名を入力">
                                    </div>
                                    </p>
                                    <p>

                                    <div class="input-group">
                                        <span class="input-group-addon">パスワード</span>
                                        <input type="password" name="roomPassword" class="form-control"
                                               placeholder="接続する際のパスワードを入力(8文字以上、英数字混在)">
                                    </div>
                                    </p>
                                    <p>

                                    <div class="input-group">
                                        <span class="input-group-addon">パスワード（確認）</span>
                                        <input type="password" name="confRoomPassword" class="form-control"
                                               placeholder="もう一度パスワードを入力">
                                    </div>
                                    </p>
                                    <p>
                                        <input type="submit" name="create" class="btn btn-primary btn-lg center-block"
                                               value="ルームを作成">
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- 既存ルームへの接続 -->
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">ルーム一覧</div>
                                <?php
                                    $rooms = $db->getRoom();
                                    $i = 0;

                                    foreach($rooms as $room)
                                    {
                                ?>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div style="float:left"><?= $room["room"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;開設者：<?= $room["nickname"]; ?></div>
                                                <div align="right"><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalPass<?= $i ?>">接続</button></div>

                                                <div class="modal fade" id="modalPass<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form method="post" action="<?php print($_SERVER['PHP_SELF']) ?>">
                                                                <input type="hidden" name="roomName" id="roomName" value="<?= $room["room"]; ?>">

                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title" id="myModalLabel">ルーム「<?= $room["room"]; ?>」へ接続</h4>
                                                                </div>

                                                                <div class="modal-body">
                                                                    パスワードを入力してください<br>
                                                                    <input type="password"  name="roomPassword" class="form-control">
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                                                                    <input type="submit" name="join" id="join" class="btn btn-primary" value="接続">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                <?php
                                        $i++;
                                    }
                                ?>
                        </div>
                    </div>
                </p>
            </div>

            <div class="tab-pane" id="tab2">
                <!-- ユーザプロフィール表示画面 -->
                <?php require_once 'userInfoPage.php'; ?>
            </div>

            <div class="tab-pane" id="tab3">
                <p>かみんぐすーん</p>
            </div>
        </div>
        <?php
    }
    else
    {
        ?>

        <!-- ユーザ登録 -->
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    新規ユーザ登録
                </div>

                <div class="panel-body">
                    <?php
                    if (isset($signUpMsg))
                    {
                        if ($signUpMsg !== "Success：ユーザ登録が完了しました！登録されたメールアドレスに確認メールを送信したから見てね！！")
                        {
                            ?>
                            <div class="alert alert-danger" role="alert"><?= $signUpMsg ?></div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="alert alert-success" role="alert"><?= $signUpMsg ?></div>
                            <?php
                        }
                    }
                    ?>
                    <form action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
                        <p>

                        <div class="input-group">
                            <span class="input-group-addon">ユーザID</span>
                            <input type="text" name="userId" class="form-control" placeholder="ユーザ名を入力">
                        </div>
                        </p>

                        <p>

                        <div class="input-group">
                            <span class="input-group-addon">パスワード</span>
                            <input type="password" name="userPassword" class="form-control"
                                   placeholder="パスワードを入力(8文字以上、英数字混在)">
                        </div>
                        </p>

                        <p>

                        <div class="input-group">
                            <span class="input-group-addon">パスワード（確認）</span>
                            <input type="password" name="confUserPassword" class="form-control" placeholder="もう一度パスワードを入力">
                        </div>
                        </p>

                        <p>

                        <div class="input-group">
                            <span class="input-group-addon">ニックネーム</span>
                            <input type="text" name="userNickName" class="form-control" placeholder="ニックネームを入力">
                        </div>
                        </p>

                        <p>

                        <div class="input-group">
                            <span class="input-group-addon">メールアドレス</span>
                            <input type="text" name="userEmail" class="form-control" placeholder="メールアドレス">
                        </div>
                        </p>

                        <p>
                            <input type="submit" id="signUp" name="signUp" class="btn btn-danger btn-lg center-block"
                                   value="新規登録">
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <!-- ログイン -->
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    ユーザログイン
                </div>

                <div class="panel-body">
                    <?php
                    if (isset($signInMsg))
                    {
                        if ($signInMsg === "Error：ログインに失敗しました")
                        {
                            ?>
                            <div class="alert alert-danger" role="alert"><?= $signInMsg ?></div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="alert alert-success" role="alert"><?= $signInMsg ?></div>
                            <?php
                        }
                    }
                    ?>

                    <form action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
                        <p>

                        <div class="input-group">
                            <span class="input-group-addon">ユーザID</span>
                            <input type="text" name="userId" class="form-control" placeholder="ユーザ名を入力">
                        </div>
                        </p>

                        <p>

                        <div class="input-group">
                            <span class="input-group-addon">パスワード</span>
                            <input type="password" name="userPassword" class="form-control" placeholder="パスワードを入力">
                        </div>
                        </p>

                        <p>
                            <input type="submit" name="signIn" class="btn btn-primary btn-lg center-block" value="ログイン">
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
?>
</body>
</html>

