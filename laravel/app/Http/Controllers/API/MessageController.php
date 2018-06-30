<?php

namespace App\Http\Controllers\API;

use App\Services\WechatService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function answer()
    {
    	$wechat = new WechatService();

    	// return $wechat->simpleNote();
    	return $wechat->simpleMessage();
    }
}
