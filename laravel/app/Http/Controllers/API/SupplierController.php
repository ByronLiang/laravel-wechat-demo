<?php

namespace App\Http\Controllers\API;

use App\Services\QiniuService;

class SupplierController extends Controller
{
    public function getUpload(QiniuService $qiniu, \App\Services\AliyunOssService $oss)
    {
        $parameter['local'] = [
            'form' => [
                'csrf-token' => csrf_token(),
            ],
            'domain' => '/upload/',
            'upload_url' => '/' . request()->path(),
        ];

        $qiniu = $qiniu->getToken();
        $parameter['qiniu'] = [
            'form' => [
                'token' => $qiniu['token'],
            ],
            'domain' => $qiniu['domain'],
            'upload_url' => $qiniu['upload_url'],
        ];

        $oss = $oss->getToken();
        $parameter['oss'] = [
            'form' => [
                'policy' => $oss['policy'],
                'OSSAccessKeyId' => $oss['accessid'],
                'success_action_status' => 200,
                'signature' => $oss['signature'],
            ],
            'domain' => $oss['host'],
            'upload_url' => $oss['host'],
        ];

        return \JSend::success($parameter[request('drive', 'qiniu')]);
    }

    public function postUpload(\Illuminate\Http\Request $request)
    {
        /**
         * @var \Illuminate\Http\UploadedFile $file
         * @var \Symfony\Component\HttpFoundation\File\File $res
         */
        $file = $request->file('file');

        if ($file && !$file->isValid()) {
            return \JSend::error('上传失败');
        }
        $file->move('upload', $request->key);

        return response()->json([
            'key' => $request->key,
        ]);
    }
}
