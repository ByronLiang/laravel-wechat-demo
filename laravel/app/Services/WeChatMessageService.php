<?php

namespace App\Services;

use Log;
use Config;

/**
*
*/
class WechatMessageService
{
    public static function handleMessage($message)
    {
        return "您好！欢迎使用 EasyWeChat;your input is" . $message['Content'];
    }
}