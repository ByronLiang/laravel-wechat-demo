<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\QiniuService;

class TestController extends Controller
{
    public function getVideoInfo()
    {

        $url = "http://pa9jr09c8.bkt.clouddn.com/1529208658823.mp4";
        $urlArray = explode('/', $url);
        $medialKey = end($urlArray);
        $qiniu = new QiniuService();
        // $res = $qiniu->fetchCutMedial($medialKey);
        list($res, $status) = $qiniu->getCutMedia('z2.5b25e29ce3d00468089a6b6d');
        dd($res);
        // $res = $qiniu->getMedialInfo($url.'?avinfo');
        // dd($res);
        return $res;
    }

    public function getWechatLogin()
    {
        if (isset($_GET['code'])) {
            echo $_GET['code'];
        } else{
            echo "NO CODE";
        }
    }
}
