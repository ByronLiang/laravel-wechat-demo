<?php

namespace Ganguo\ClientAggregationUpload;

use App\Services\QiniuService;

class ClientAggregationUpload
{
    public function getParameter($drive = 'local')
    {
        switch ($drive) {
            case 'oss':
                $oss = (new AliyunOssService())->getToken();
                $parameter = [
                    'form' => [
                        'policy' => $oss['policy'],
                        'OSSAccessKeyId' => $oss['accessid'],
                        'success_action_status' => 200,
                        'signature' => $oss['signature'],
                    ],
                    'domain' => $oss['host'],
                    'upload_url' => $oss['host'],
                ];
                break;
            case 'qiniu':
                $qiniu = (new QiniuService())->getToken();
                $parameter = [
                    'form' => [
                        'token' => $qiniu['token'],
                    ],
                    'domain' => $qiniu['domain'],
                    'upload_url' => $qiniu['upload_url'],
                ];
                break;
            case 'local':
            default:
                \Session::put('_token', csrf_token());
                $parameter = [
                    'form' => [
                        '_token' => csrf_token(),
                    ],
                    'domain' => '/upload/',
                    'upload_url' => '/' . request()->path(),
                ];
                break;
        }
        return $parameter;
    }

    public function local(\Illuminate\Http\Request $request)
    {
        if (!$request->has('_token') || $request->get('_token') != \Session::get('_token')) {
            abort(403, '上传失败，token错误');
        }

        $file = $request->file('file');

        if ($file && !$file->isValid()) {
            return abort(422, '上传失败');
        }
        $file->move('upload', $request->key);

        return response()->json([
            'key' => $request->key,
        ]);
    }
}
