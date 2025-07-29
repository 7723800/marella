<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SmsMessageController extends Controller
{
    public static function send($phone, $msg)
    {
        $url = 'https://smsc.kz/sys/send.php';
        $login = '7723800';
        $psw = 'donatogfhjkm';
        $msg = urlencode($msg);
        $request = "{$url}?login={$login}&psw={$psw}&phones={$phone}&mes={$msg}";
        $client = new Client();
        return $client->request('GET', $request);
    }
}
