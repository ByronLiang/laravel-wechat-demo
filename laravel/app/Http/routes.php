<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api', 'namespace' => 'API', 'middleware' => 'auth.driver:api'], function () {
    Route::group(['middleware' => 'auth'], function () {
    });
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth.driver:admin'], function () {
    if (request()->wantsJson() || request()->ajax()) {
        Route::group(['middleware' => 'auth'], function () {
            Route::controller('product', 'ProductController');
            Route::controller('banner', 'BannerController');
            Route::controller('supplier', 'SupplierController');
            Route::controller('catagory', 'CatagoryController');
            Route::controller('author', 'AuthorController');
        });
    }
    Route::controller('auth', 'AuthController');
    Route::get('/{capture?}', function () {
        return view('adminapp');
    })->where('capture', '[\/\w\.-]*');
});

// Route::group(['prefix' => 'v'], function () {
//     Route::get('/{capture?}', function () {
//         return view('webapp', ['wechat' => env('WECHAT')]);
//     })->where('capture', '[\/\w\.-]*');
// });

Route::group(['prefix' => 'web',
    'namespace' => 'Web',
    'middleware' => 'auth.driver:web'
], function () {
    Route::controller('test', 'TestController');
    Route::controller('wechat', 'WechatController');
    Route::controller('home', 'HomeController');
    Route::group(['middleware' => 'auth'], function () {
    });
});
