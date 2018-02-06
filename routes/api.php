<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'UserController@test');
//注册用户
Route::post('/register', 'UserController@registerUser');
//检测该用户名是否使用了
Route::post('/checkUsername', 'UserController@checkUsername');
//登录用户
Route::post('/login', 'UserController@login');


//注册管理员用户
Route::post('/registerAdmin', 'AdminUserController@registerAdmin');
//管理员登录
Route::post('/adminLogin', 'AdminUserController@adminLogin');
//检测该管理员名是否使用了
Route::post('/checkAdmin', 'AdminUserController@checkAdmin');



//获取产品列表
Route::get('/getProductsList', 'ProductController@getProductsList');
//    获取产品的问题类别树
Route::get('/getCategoryTree', 'QuestionController@getCategoryTree');

//获取当前树节点的所有问题及解决方法
Route::get('/getQuestionAndAnswer', 'QuestionController@getQuestionAndAnswer');
//获取常见问题
Route::get('/getCommQuestion', 'QuestionController@getCommQuestion');


//更新问题的查看次数
Route::post('/updateViews', 'QuestionController@updateViews');

//更新问题是否解决的次数
Route::post('/updateSolveNum', 'QuestionController@updateSolveNum');




//限制是否
Route::group(['middleware' => 'check.login'], function () {

});


Route::group(['middleware' => 'check.admin'], function () {
//    添加产品
    Route::post('/storeProduct', 'ProductController@storeProduct');
//    添加分类
    Route::post('/storeCategory', 'QuestionController@storeCategory');
//    添加问题和解决方案
    Route::post('/storeQuestion','QuestionController@storeQuestion');








});


