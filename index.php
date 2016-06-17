<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/17
     * Time: 15:00
     */
    define("CRYPT", "CS");

    require_once 'chromelog.php';
    require_once 'db.php';
    $db = new db();
    ChromePhp::log("start");
    $errMsg = "";
    $msg = "";

    if(isset($_POST["create"]))
    {
        ChromePhp::log("ルーム作成");
    }
    else if(isset($_POST["join"]))
    {
        ChromePhp::log("ルーム接続");
    }
    else if(isset($_POST["signIn"]))
    {
        ChromePhp::log("sign in");
    }
    else if(isset($_POST["signUp"]))
    {
        ChromePhp::log("sign up");
        if($_POST["userId"] !== "" && $_POST["userPassword"] !== "" && $_POST["confUserPassword"] !== "" && $_POST["userNickName"] !== "" && $_POST["userEmail"] !== "")
        {
            if ($_POST["userPassword"] === $_POST["confUserPassword"])
            {
                $result = $db->signUp($_POST["userId"], $_POST["userPassword"], $_POST["userNickName"], $_POST["userEmail"]);
                $msg = "ユーザ登録が完了しました！登録されたメールアドレスに確認メールを送信したから見てね！！";
            }
            else
            {
                $errMsg = "パスワードが一致しません!!";
            }
        }
        else
        {
            $errMsg = "すべての項目を入力してください!!";
        }

    }
    else
    {
        ChromePhp::log("Error..");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>飲み会やろうぜ</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="jumbotron">
                <p><h1>飲み会やろうぜ 待ち合わせサイト</h1></p>
                <p>飲み会の待ち合わせで「お前ら何処だよ？？？」「お前こそ何処だよ？？？？」を解消するためのサービスです。</p>
            </div>
        </div>

        <!-- 新規ルーム作成 -->
        <div class="col-md-6">
            <form action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
                <p>
                    <div class="input-group">
                        <span class="input-group-addon">ルーム名</span>
                        <input type="text" name="room" class="form-control" placeholder="ルーム名を入力">
                    </div>
                </p>
                <p>
                    <div class="input-group">
                        <span class="input-group-addon">パスワード</span>
                        <input type="roomPassword" name="password" class="form-control" placeholder="接続する際のパスワードを入力(8文字以上、英数字混在)">
                    </div>
                </p>
                <p>
                <div class="input-group">
                    <span class="input-group-addon">パスワード（確認）</span>
                    <input type="roomPassword" name="confPassword" class="form-control" placeholder="もう一度パスワードを入力">
                </div>
                </p>
                <p>
                <div class="input-group">
                    <span class="input-group-addon">メールアドレス</span>
                    <input type="text" name="roomEmail" class="form-control" placeholder="通知用メールアドレスを入力">
                </div>
                </p>
                <p>
                    <input type="submit" name="create" class="btn btn-primary btn-lg center-block" value="ルームを作成">
                </p>
            </form>
        </div>

        <!-- 既存ルームへの接続 -->
        <div class="col-md-6">
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
                    <input type="password" name="roomPassword" class="form-control" placeholder="パスワードを入力">
                </div>
                </p>
                <p>
                    <input type="submit" name="join" id="join" class="btn btn-primary btn-lg center-block" value="ルームに接続">
                </p>
            </form>
        </div>

        <!-- ユーザ登録 -->
        <div class="col-md-6">
            <?php
                if($errMsg !== "")
                {
            ?>
                    <div class="alert alert-danger" role="alert"><?= $errMsg ?></div>
            <?php
                }
            ?>
            <?php
                if($msg !== "")
                {
                    ?>
                    <div class="alert alert-success" role="alert"><?= $msg ?></div>
                    <?php
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
                        <input type="password" name="userPassword" class="form-control" placeholder="パスワードを入力(8文字以上、英数字混在)">
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
                    <input type="submit" id="signUp" name="signUp" class="btn btn-danger btn-lg center-block" value="新規登録">
                </p>
            </form>
        </div>

        <!-- ログイン -->
        <div class="col-md-6">
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
    </body>
</html>
