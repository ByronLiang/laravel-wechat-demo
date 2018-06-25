<?php

return [
    'web' => [
        'app_id' => env('ALIPAY_APPID'),
        'alipay_public_key_path' => storage_path('certificate/alipay_web/alipay_public_key.pem'),
        'app_private_key_path' => storage_path('certificate/alipay_web/app_private_key.pem'),
    ],
    'test' => [
        'app_id' => '2016072800110686',
        'alipay_public_key_path' => storage_path('certificate/alipay_test/alipay_public_key.pem'),
        'app_private_key_path' => storage_path('certificate/alipay_test/app_private_key.pem'),
    ]
];