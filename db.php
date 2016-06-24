<?php
    /**
     * Created by PhpStorm.
     * User: Sorarinu
     * Date: 2016/06/17
     * Time: 17:08
     */

    require_once 'chromelog.php';

    class db
    {
        /**
         * func constructor.
         * MySQLに接続する
         */
        function __construct()
        {
            try {
                $this->pdo = new PDO('mysql:host=nxtg-t.net;dbname=projectP;charset=utf8;', 'projectP', 'projectP', array(PDO::ATTR_EMULATE_PREPARES => false));
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            catch (PDOException $ex) {
                exit('Connection Error...' . $ex->getMessage());
            }
        }

        /**
         * 既に存在しているユーザか判定
         *
         * @param $userId
         *
         * @return int
         */
        function checkUserId($userId)
        {
            $rows = $this->pdo->query("SELECT * FROM users WHERE id = '$userId'");

            foreach ($rows as $row) {
                if (isset($row["id"])) {
                    return -1;
                }
            }

            return 0;
        }

        /**
         * ユーザ情報をデータベースに保存する
         *
         * @param $userId
         * @param $password
         * @param $nickName
         * @param $email
         *
         * @return PDOStatement
         */
        function signUp($userId, $password, $nickName, $email)
        {
            return $this->pdo->query("INSERT INTO users (id, password, nickname, email) VALUES ('$userId', '$password', '$nickName', '$email')");
        }

        function login($userId, $password)
        {
            $rows = $this->pdo->query("SELECT * FROM users WHERE id = '$userId' AND password = '$password'");

            foreach ($rows as $row) {
                if (isset($row['id'])) {
                    return $row;
                }

                return false;
            }
        }

        /**
         * 新規ルーム情報をデータベースに保存する
         *
         * @param $id
         * @param $nickname
         * @param $room
         * @param $password
         * @param $email
         *
         * @return int|PDOStatement
         */
        function createRoom($id, $nickname, $room, $password, $email)
        {
            $rows = $this->pdo->query("SELECT * FROM room WHERE room = '$room'");

            foreach ($rows as $row) {
                if (isset($row["room"])) {
                    return -1;
                }
            }

            return $this->pdo->query("INSERT INTO room (id, nickname, room, password, email) VALUES ('$id', '$nickname', '$room', '$password', '$email')");
        }

        /**
         * ルーム情報を返す
         *
         * @param $room
         *
         * @return mixed
         */
        function getRoomInfo($room)
        {
            $rows = $this->pdo->query("SELECT * FROM room WHERE room = '$room'");

            foreach ($rows as $row) {
                return $row;
            }
        }

        /**
         * 既存ルームに接続する
         *
         * @param $room
         * @param $password
         *
         * @return null
         */
        function join($room, $password)
        {
            $rows = $this->pdo->query("SELECT * FROM room WHERE room = '$room' AND password = '$password'");

            foreach ($rows as $row) {
                if (isset($row["room"])) {
                    return $row;
                }

                return null;
            }
        }

        /**
         * ルーム情報を更新する
         *
         * @param $room
         * @param $place
         * @param $date
         * @param $budget
         * @param $note
         *
         * @return PDOStatement
         */
        function updateRoomInfo($room, $place, $date, $budget, $note)
        {
            return $this->pdo->query("UPDATE room SET place = '$place', date = '$date', budget = '$budget', note = '$note' WHERE room = '$room'");
        }

        /**
         * 接続人数確認用テーブルを作成する
         *
         * @param $room
         *
         * @return PDOStatement
         */
        function createRoomTable($room)
        {
            return $this->pdo->query("CREATE TABLE $room (joinUser TEXT NOT NULL, latitude DOUBLE, 	longitude DOUBLE)");
        }

        /**
         * 接続人数確認用テーブルにユーザ情報を保存する
         *
         * @param $user
         * @param $room
         *
         * @return PDOStatement
         */
        function joinRoomMember($user, $room)
        {
            $rows = $this->pdo->query("SELECT * FROM $room WHERE joinUser = '$user'");

            foreach ($rows as $row) {
                if (isset($row["joinUser"])) {
                    ChromePhp::log("return");

                    return -1;
                }
            }
            $this->pdo->query("INSERT INTO $room VALUES ('$user')");

            return $this->pdo->errorInfo();
        }

        /**
         * 接続中のユーザ情報を消す
         *
         * @param $user
         * @param $room
         *
         * @return PDOStatement
         */
        function removeRoomMember($user, $room)
        {
            if ($room === null) return -1;

            return $this->pdo->query("DELETE FROM $room WHERE joinUser = '$user'");
        }

        /**
         * 接続中のユーザを取得
         *
         * @param $room
         *
         * @return PDOStatement
         */
        function getRoomMember($room)
        {
            return $this->pdo->query("SELECT * FROM $room");
        }

        /**
         * ルーム一覧を取得する
         *
         * @return PDOStatement
         */
        function getRoom()
        {
            return $this->pdo->query("SELECT * FROM room");
        }

        /**
         * 指定のルームを削除する
         *
         * @param $room
         * @param $id
         */
        function deleteRoom($room, $id)
        {
            $this->pdo->query("DELETE FROM room WHERE room = '$room' AND id = '$id'");
            $this->pdo->query("DROP TABLE $room");
        }
    }

?>