<?php

namespace App\Services;

use Log;
use Config;
use EasyWeChat\Payment\Order;
use EasyWeChat\Foundation\Application;

class WechatService
{
    private $app;

    public function __construct()
    {
        $cfg = Config::get('services.wechat');
        $config = [
            'debug' => $cfg['debug'],
            'app_id' => $cfg['appid'],
            'secret' => $cfg['appsecret'],
            'token'   => $cfg['token'],
            'log' => [
                'level' => 'debug',
                'file' => storage_path('logs/wechat-'.date('Y-m-d').'.log'),
            ],
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => action('Web\WechatController@getOauth'),
            ],
            'payment' => [
                'merchant_id' => $cfg['merchantid'],
                'key' => $cfg['paykey'],
                'cert_path' => $cfg['paycertpath'],
                'key_path' => $cfg['paykeypath'],
            ],
            'guzzle' => [
                'timeout' => 60, // 超时时间（秒）
            ],
        ];
        $this->app = new Application($config);
        $menu = $this->app->menu;
        $this->addMenu($menu);
    }

    public function getApplication()
    {
        return $this->app;
    }

    public function oauthRedirect()
    {
        return $this->app->oauth->redirect();
    }

    public function oauthUser()
    {
        return $this->app->oauth->user();
    }

    public function jsSdkConfig()
    {
        return $this->app->js->config([
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'hideAllNonBaseMenuItem',
            'showMenuItems',
        ]);
    }

    public function configForPayment(array $data)
    {
        $order = new Order($data);
        $result = $this->app->payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            return $this->app->payment->configForPayment($result->prepay_id);
        } else {
            Log::error('wechat config payment fail: '.json_encode($result));
        }
    }

    public function queryPayment($out_trade_no)
    {
        $result = $this->app->payment->query($out_trade_no);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            return $result;
        } else {
            Log::error('wechat query payment fail: '.json_encode($result));
        }
    }

    public function isSuccessPayment($result)
    {
        return $result->trade_state == 'SUCCESS';
    }

    public function refundPayment($out_trade_no, $refund_no, $total_fee)
    {
        $result = $this->app->payment->refund($out_trade_no, $refund_no, $total_fee);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            return $result;
        } else {
            Log::error('wechat refund fail: '.json_encode($result));
        }
    }

    // 普通消息回复功能
    public function simpleMessage()
    {
        $server = $this->app->server;
        $response = $server->setMessageHandler(function ($message) {
            return $this->messageTypeProcess($message);
        });

        return $response->serve();
    }

    // 待定回调函数的用法
    public function easyMessage()
    {
        $server = $this->app->server;
        $message = $server->getMessage();
        $response = $server->setMessageHandler(WechatMessageService::handleMessage($message));

        return $response->serve();
    }

    public function messageTypeProcess($message)
    {
        switch ($message->MsgType) {
            case 'text':
                // $this->messageHandle($message);
                // $this->simpleNote();
                return "您好！欢迎使用 byron-wechat; ". $message->MsgType ."your input is" . $message->Content;
                break;
            case 'event':
                if ($message->Event == 'SCAN') {
                    return 'how dare you are, you scan me';
                } elseif ($message->Event == 'subscribe') {
                    return 'welcome';
                } else if ($message->Event == 'CLICK') {
                    return $this->menuClick($message->EventKey);
                }
                break;
            default:
                return '';
                break;
            }
    }

    public function messageHandle($message)
    {
        return "您好！欢迎使用 EasyWeChat;". $message->MsgType ." <br>your input is" . $message->Content;
    }

    // 获取公众号access_token
    public function fetchToken()
    {
        $access_token = $this->app->access_token;
        $token = $access_token->getToken();
        Log::info('access_token: ' . $token);
    }

    // 模板消息
    public function simpleNote()
    {
        $server = $this->app->server;
        $response = $server->setMessageHandler(function ($message) {
            $this->handleNote();
        });

        return $response->serve();
    }

    public function handleNote()
    {
        $notice = $this->app->notice;
        $userId = 'oEE_N0UfvoIRysP6TJZOFY-iuzhs';
        $templateId = 'm4UjKTrObPPM80sVUi3Dhu7e-ztHNKOfZCukb6_BtmE';
        $url = 'http://www.baidu.com';
        $data = array(
            "first"  => "恭喜你购买成功！",
            "name"   => "巧克力",
            "price"  => "39.8元",
            "remark" => "欢迎再次购买！",
        );

        $res = $notice->uses($templateId)
            ->withUrl($url)
            ->andData($data)
            ->andReceiver($userId)
            ->send();
        Log::info($res);
    }

    // 菜单栏点击事件
    public function menuClick($key)
    {
        switch ($key) {
            case 'V1001_TODAY_MUSIC':
                return '你选择的菜单是今日金曲';
                break;
            case 'V1001_GOOD':
                return '感谢支持';
                break;
            default:
                return '无法识别你的菜单选项';
                break;
        }
    }

    // 初始化公众号的自定义菜单
    public function addMenu($menu)
    {
        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "name" => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
    }
}
