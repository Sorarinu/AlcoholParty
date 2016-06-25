<?php

    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/24
     * Time: 17:36
     */
    class snedMail
    {
        function initMail()
        {
            mb_language("ja");
            mb_internal_encoding("UTF-8");
        }

        function sendNewAccount($to, $user)
        {
            $this->initMail();

            $subject = "【no-reply】登録が完了しました";
            $headers = "From: alcoholparty@nxtg-t.net" . "\r\n";
            $message = <<< EOM
ユーザの登録が完了しました．\r\n
\r\n
【ユーザ名】 $user\r\n
【パスワード】 ご自身で設定されたもの\r\n
\r\n
-------------------------------\r\n
飲み会やろうぜ -AlcoholParty-\r\n
https://nxtg-t.net/AlcoholParty/\r\n
-------------------------------

EOM;

            mb_send_mail($to, $subject, $message, $headers);
        }

        function sendNewRoom($to, $user, $room)
        {
            $subject = "【no-reply】新規ルームを開設しました";
            $headers = "From: alcoholparty@nxtg-t.net" . "\r\n";
            $message = <<< EOM
新規ルームを開設しました．\r\n
\r\n
【ルーム名】 $room\r\n
【開設者】 $user\r\n
【パスワード】 ご自身で設定されたもの\r\n
\r\n
-------------------------------\r\n
飲み会やろうぜ -AlcoholParty-\r\n
https://nxtg-t.net/AlcoholParty/\r\n
-------------------------------

EOM;

            mb_send_mail($to, $subject, $message, $headers);
        }

        function sendDeleteRoom($to, $user, $room)
        {
            $this->initMail();

            $subject = "【no-reply】ルームを削除しました";
            $headers = "From: alcoholparty@nxtg-t.net" . "\r\n";
            $message = <<< EOM
既存ルームを削除しました．\r\n
\r\n
【ルーム名】 $room\r\n
【開設者】 $user\r\n
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