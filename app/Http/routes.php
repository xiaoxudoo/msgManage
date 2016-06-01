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

/*
|  消息管理
|
*/ 

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});
//Route::group(['middleware' => ['web','session_user'], 'namespace' => 'MsgManage'], function(){
Route::group(['middleware' => ['web','auth'], 'namespace' => 'MsgManage'], function(){
	Route::get('/', 'MsgRecordController@getMsgRecordList');
	//搜索消息记录
	Route::post('/searchMsgRecord', 'MsgRecordController@searchMsgRecord');
	Route::get('/searchMsgRecord', 'MsgRecordController@searchMsgRecord');
	Route::get('/selectGroup', 'MsgRecordController@selectGroup');
	Route::post('/display', 'MsgRecordController@displayMsgRecord');

	//文章预览、获取分组信息API
	Route::post('/preview', 'MsgRecordController@previewMsgRecord');
	Route::post('/groups', 'MsgRecordController@getMsgGroup');
	Route::get('/groups', 'MsgRecordController@getMsgGroup');

	//管理消息记录
	Route::get('/manage', 'MsgManageController@getMsgRecordList');
	//搜索消息记录
	Route::post('/manage/searchMsgRecord', 'MsgManageController@searchMsgRecord');
	Route::get('/manage/searchMsgRecord', 'MsgManageController@searchMsgRecord');
	//消息记录分组
	Route::get('/manage/selectGroup', 'MsgManageController@selectGroup');

	//消息记录管理 ———— 删除
	Route::post('/manage/delete', 'MsgManageController@deleteMsgRecord');
	//消息记录管理 ———— 增加和修改
	Route::post('/manage/merge', 'MsgManageController@createMsgRecord');
	
});



 