<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//测试
Route::get('/test','Test\TestController@test');
//对称加密
Route::post('/test1','Test\TestController@test1');
Route::get('/test2','Test\TestController@test_post');

//非对称 -》加密
Route::get('/test3','Test\TestController@test3');
//非对称 -》签名
Route::get('/test4','Test\TestController@test4');


//注册
Route::get('/regist','Regist\RegistController@regist');
//注册执行
Route::post('/registdo','Regist\RegistController@registdo');
//登录
Route::get('/login','Regist\RegistController@login');
//登录执行
Route::post('/logindo','Regist\RegistController@logindo');

Route::get('/index','Regist\RegistController@index');


//测试
Route::get('/test_a','Regist\RegistController@test');
Route::post('/test_t','Regist\RegistController@test');
