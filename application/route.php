<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;


//------------PC后台管理系统----------------
// -------系统页面-------
Route::get("login", 'xt/index/login');
Route::get("index", 'xt/index/index');
Route::get("welcome", 'xt/index/welcome');
Route::get("xt/:page$", 'xt/html/:page');
//-------系统接口--------
//用户
Route::resource('xt/users', 'xt/User');
Route::post('xt/user/login', 'xt/User/login');
Route::post('xt/user/logout', 'xt/User/logout');
//基础代码
Route::resource("xt/baseCodes", 'xt/BaseCode');
//Route::get("xt/BaseCode/list", 'xt/BaseCode/listBaseCode');
//组织机构
Route::resource('xt/organises', 'xt/Organise');
Route::resource('xt/areas', 'xt/Area');

//业务页面
Route::get("html/:page", 'index/html/:page');
//业务接口
Route::resource('experInfo', 'index/ExpertInformation');
Route::resource('experCertificate', 'index/ExpertCertificate');
Route::resource("expertOrg", 'index/ExpertOrg');
Route::get('experCertificate/index', 'index/ExpertCertificate/index');
Route::get('experCertificate/major', 'index/ExpertCertificate/major');
Route::get('export','index/ExpertInformation/export');
Route::post('import','index/ExpertInformation/import');

//统计分析
Route::get('analysis','index/ExpertAnalysis/analysis');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
