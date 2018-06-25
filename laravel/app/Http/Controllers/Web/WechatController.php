<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QrCode;
use Config;
use App\Services\WechatService;

class WechatController extends Controller
{
    public function getWechatCode()
    {
        $callback = urlencode('http://byron.free.ngrok.cc/web/wechat/login');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx287a861a2bc42046&redirect_uri='. $callback . '&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
        $code = QrCode::size(200)->generate($url);

        return view('web.wechat.wechat_qrcode', compact('code'));
    }

    public function getLogin()
    {
        if (isset($_GET['code'])) {
            echo $_GET['code'] . 'state=' . $_GET['state'];
        } else{
            echo "NO CODE";
        }
    }

    public function getWechatLogin()
    {
        $wechat = new WechatService();

        return $wechat->oauthRedirect();
    }

    public function getOauth()
    {
        $wechat = new WechatService();
        $user = $wechat->oauthUser();
        echo $user->getId() . '<br>';  // 对应微信的 OPENID
        echo $user->getNickname() . '<br>'; // 对应微信的 nickname
        echo $user->getName() . '<br>'; // 对应微信的 nickname
        echo $user->getAvatar(); // 头像网址
    }

    public function message(WechatService $wechat)
    {
        $wechat->server->push(function ($message) {
        });
    }
}
