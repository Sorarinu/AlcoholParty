<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/24
     * Time: 17:36
     */
    class snedMail
    {
        function sendNewAccount($to, $user)
        {
            mb_language("ja");
            mb_internal_encoding("UTF-8");

            $subject = "登録が完了しました";
            $headers = "From: alcoholparty@nxtg-t.net" . "\r\n";
            $message = <<< EOM
ユーザの登録が完了しました．\r\n
\r\n
ユーザ名： $user\r\n
パスワード： ご自身で設定されたもの\r\n
\r\n
-------------------------------\r\n
飲み会やろうぜ -AlcoholParty-\r\n
https://nxtg-t.net/AlcoholParty/\r\n
-------------------------------

EOM;

            mb_send_mail($to, $subject, $message, $headers);
        }
    }
?>