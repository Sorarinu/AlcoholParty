<?php
/**
 * Created by PhpStorm.
 * User: Sorarinu
 * Date: 2016/07/07
 * Time: 16:28
 */

require_once 'chromelog.php';

class hotpepper
{
    function __construct()
    {
    }

    function getStoreData()
    {
        $API_KEY = "1e2f4004931d07c9";
        $url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1";
        $param = ['key' => $API_KEY, 'name' => 'ちばチャン', 'address' => '八王子'];
        $rows = json_encode(file_get_contents($url . "?key=" . $param["key"] . "&name=" . $param["name"] . "&address=" . $param["address"]));
    }
}