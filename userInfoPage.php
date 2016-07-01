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

    require_once 'chromelog.php';
    require_once 'db.php';

    $db = new db();
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
    <form action="" method="post">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Profile
            </div>
            <div class="panel-body">
                パネルの内容
            </div>
            <div class="panel-footer" align="right">
                <input type="submit" id="update" name="update" class="btn btn-info btn-lg" value="更新">
            </div>
        </div>
    </form>
</div>
<div class="col-md-1"></div>