<?php
/**
 * Created by PhpStorm.
 * User: Sorarinu
 * Date: 2016/07/07
 * Time: 16:28
 */

require_once 'chromelog.php';

static $API_KEY = "1e2f4004931d07c9";

class hotpepper
{
    function __construct()
    {
    }

    function getStoreData()
    {
        global $API_KEY;
        ChromePhp::log($API_KEY);
        $url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/";
        $param = ['key' => $API_KEY, 'name' => '味道苑'];

        $res = file_get_contents($url . http_build_query($param));
        $result = json_decode($res);

        ChromePhp::log($result, true);
    }
}