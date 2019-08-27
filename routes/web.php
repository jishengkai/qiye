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

//Route::get('/', function () {
//    return view('index.index');
//});

Route::any('/','IndexController@index');
#前台
Route::prefix('/index')->group(function(){
    Route::get('about','IndexController@about');
    Route::get('news','IndexController@news');
    Route::get('shownews','IndexController@shownews');
    Route::any('index','IndexController@index');
});

//登录注册
Route::prefix('/login')->group(function(){
    Route::get('reg','LoginController@reg');#注册
    Route::post('regdo','LoginController@regdo');#注册执行
    Route::get('login','LoginController@login');#登录
    Route::post('logindo','LoginController@logindo');#执行登录
    Route::post('forgotpwd','LoginController@forgotpwd');//执行忘记密码
    Route::get('forgot','LoginController@forgot');//忘记密码
    Route::post('send','LoginController@send');//获取验证码
    Route::any('logout','LoginController@logout');//退出登录
});

//登录加上中间件
Route::group(['prefix'=>'admin','middleware'=>'login'],function(){
    Route::get('index','AdminController@index');
});

Route::get('code','LoginController@logincode');//登录验证码

//头部导航栏
Route::prefix('/navbar')->group(function(){
    Route::get('add','NavbarController@add');//添加视图
    Route::any('doAdd','NavbarController@doAdd');//执行添加
    Route::any('list','NavbarController@list');//执行添加
    Route::any('del','NavbarController@del');//删除
    Route::any('update','NavbarController@update');//修改
    Route::any('doupdate','NavbarController@doupdate');//执行修改
});

//底部导航栏
Route::prefix('/navbars')->group(function(){
    Route::get('add','NavbarsController@add');//添加视图
    Route::any('doAdd','NavbarsController@doAdd');//执行添加
    Route::any('list','NavbarsController@list');//执行添加
    Route::any('del','NavbarsController@del');//删除
    Route::any('update','NavbarsController@update');//修改
    Route::any('doupdate','NavbarsController@doupdate');//执行修改
});

//头部轮播图
Route::prefix('/rmap')->group(function(){
    Route::get('add','RmapController@add');//添加视图
    Route::any('doadd','RmapController@doadd');//执行添加
    Route::any('uploads','RmapController@uploads');//上传图片
    Route::any('list','RmapController@list');//执行添加
    Route::any('del','RmapController@del');//删除
});

//栏目
Route::prefix('/column')->group(function(){
    Route::get('add','ColumnController@add');//添加视图
    Route::any('doadd','ColumnController@doadd');//执行添加
    Route::any('list','ColumnController@list');//展示
    Route::any('del','ColumnController@del');//删除
    Route::any('update','ColumnController@update');//修改
    Route::any('doupdate','ColumnController@doupdate');//执行修改
});

//分栏
Route::prefix('/subfield')->group(function(){
    Route::get('add','SubfieldController@add');//添加视图
    Route::any('doadd','SubfieldController@doadd');//执行添加
    Route::any('list','SubfieldController@list');//展示
    Route::any('del','SubfieldController@del');//删除
    Route::any('update','SubfieldController@update');//修改
    Route::any('doupdate','SubfieldController@doupdate');//执行修改
});


