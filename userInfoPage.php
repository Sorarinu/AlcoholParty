<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/29
     * Time: 13:41
     */
    if (!isset($_SESSION)) {
        session_start();
    }

    //require_once 'chromelog.php';
    require_once 'db.php';

    $db = new db();

    if(isset($_POST["update"]))
    {
        $user = $db->getUserData($_SESSION["id"]);

        foreach ($user as $item) {
            $result = $db->updateUserData(
                $_SESSION["id"],
                $_POST["nickname"] !== "" ? $_POST["nickname"] : $item["nickname"],
                $_POST["email"] !== "" ? $_POST["email"] : $item["email"],
                $_POST["imageURL"] !== "" ? $_POST["imageURL"] : $item["img"]
            );
            $_POST = array();
        }
    }
?>
<div class="col-md-1"></div>
<div class="col-md-3 text-center">
    <?php
        $userData = $db->getUserData($_SESSION["id"]);

        foreach($userData as $data)
        {
            ?>
            <br>
            <p><img src="<?= $data["img"] ?>" width="240" height="240" alt="サムネイル"></p>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">ユーザID</div>
                </div>
                <div class="panel-body">
                    <?= $data["id"] ?>
                </div>

                <div class="panel-heading">
                    <div class="panel-title">ニックネーム</div>
                </div>
                <div class="panel-body">
                    <?= $data["nickname"] ?>
                </div>

                <div class="panel-heading">
                    <div class="panel-title">メールアドレス</div>
                </div>
                <div class="panel-body">
                    <?= $data["email"] ?>
                </div>
            </div>
            <?php
        }
    ?>
</div>
<div class="col-md-1"></div>
<div class="col-md-6">
    <br>
    <form action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Profile
            </div>
            <div class="panel-body">
                <h3 class="text-center">サムネイル登録</h3>
                <input type="text" name="imageURL" id="imageURL" class="form-control" placeholder="画像のURLを入力">
                <br>
                <h3 class="text-center">ニックネームの変更</h3>
                <input type="text" name="nickname" id="nickname" class="form-control" placeholder="新しいニックネームを入力">
                <br>
                <h3 class="text-center">メールアドレスの変更</h3>
                <input type="text" name="email" id="email" class="form-control" placeholder="新しいメールアドレスを入力">
            </div>
            <div class="panel-footer" align="right">
                <input type="submit" id="update" name="update" class="btn btn-info btn-lg" value="更新">
            </div>
        </div>
    </form>
</div>
<div class="col-md-1"></div>
