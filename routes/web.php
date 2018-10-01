<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('home','HomeController@post');
Route::get('logout',function(){
			Auth::logout();
			return redirect("home");
		});
Route::get('huong-dan/api', function(){
	return view('backend.huong-dan.api');
});
Route::get('huong-dan/tim-key', function(){
	return view('backend.huong-dan.timkey');
});
Route::get('huong-dan/auto-reup', function(){
	return view('backend.huong-dan.autoreup');
});
Route::get('huong-dan/theo-doi', function(){
	return view('backend.huong-dan.theodoi');
});
Route::get('huong-dan/auto-comment', function(){
	return view('backend.huong-dan.autocomment');
});
Route::group(array("prefix"=>"admin","middleware"=>"auth"),function(){

		Route::get('/home', function(){
			return view('backend.home');
		});
	//---------log out---------//
		Route::get('logout',function(){
			Auth::logout();
			return redirect("home");
		});
	//---------user---------//
		Route::get('user','backend\userController@list_user');
		Route::get('user/delete/{id}','backend\userController@delete_user');
		Route::get('user/edit/{id}','backend\userController@edit_user');
		Route::post('user/edit/{id}','backend\userController@do_edit_user');
		Route::get('user/add', 'backend\userController@add_user');
		Route::post('user/add','backend\userController@do_add');
		Route::get('key','backend\userController@list_key');
		Route::get('view','backend\userController@list_view');

	//---------admin---------//
		Route::get('theodoikenh','backend\userController@list_channel');
		Route::get('theodoivideo/{id}','backend\userController@list_video');
		Route::get('kenhrac','backend\userController@list_user_kenhrac');

	//-------channel-------//
		Route::get('channel','backend\channelController@list_channel');
		Route::get('channel/add','backend\channelController@add_channel');
		Route::get('channel/delete/{id}','backend\channelController@delete_channel');

	//-------video-------//
		Route::get('channel/video/{id}','backend\channelController@list_video');
		Route::get('channel/video/add/{id}','backend\channelController@add_video');
		Route::get('channel/video/delete/{id}','backend\channelController@delete_video');

	//---------update view die song---------//
		// Route::get('view','backend\viewController@update_view');

	//---------Lọc key---------//
		Route::get('key','backend\channelController@key')->middleware(['can:status']);

	//---------Auto Comment---------//
		// Route::get('comment','backend\channelController@comment');
		Route::get('comment','backend\channelController@comment')->middleware(['can:status']);

	//---------Auto REUP---------//
		Route::get('autoreup/channel','backend\reup\autoreupController@list_channel')->middleware(['can:reup']);
		Route::get('autoreup/channel/add','backend\reup\autoreupController@add_channel')->middleware(['can:reup']);
		Route::get('autoreup/channel/edit/{id}','backend\reup\autoreupController@edit_channel')->middleware(['can:reup']);
		Route::get('autoreup/channel/delete/{id}','backend\reup\autoreupController@delete_channel')->middleware(['can:reup']);
		Route::get('autoreup/video/{id}','backend\reup\autoreupController@list_video')->middleware(['can:reup']);
		Route::get('autoreup/video/delete/{id}','backend\reup\autoreupController@delete_video')->middleware(['can:reup']);
		Route::get('autoreup/video/add/{id}','backend\reup\autoreupController@add_video')->middleware(['can:reup']);
		Route::get('autoreup/video/edit/{id}','backend\reup\autoreupController@edit_video')->middleware(['can:reup']);
		Route::post('autoreup/video/edit/{id}','backend\reup\autoreupController@do_edit_video')->middleware(['can:reup']);
		// Route::post('public/update','backend\reup\autoreupController@update');
		// Route::post('auto/update','backend\reup\autoreupController@auto_update');

		Route::get('autoreup/channel/cauhinh/{id}','backend\reup\autoreupController@cauhinh')->middleware(['can:reup']);
		Route::post('autoreup/channel/cauhinh/{id}','backend\reup\autoreupController@post_cauhinh')->middleware(['can:reup']);
		Route::get('autoreup/channelreup/delete/{id}','backend\reup\autoreupController@delete_channelreup')->middleware(['can:reup']);
		Route::get('autoreup/video/sua/{id}','backend\reup\autoreupController@sua')->middleware(['can:reup']);
		Route::post('autoreup/video/sua/{id}','backend\reup\autoreupController@post_sua')->middleware(['can:reup']);
		// Route::post('public/update_public','backend\reup\autoreupController@update_public');
		// Route::post('public/update_private','backend\reup\autoreupController@update_private');
		// Route::post('public/xoa','backend\reup\autoreupController@xoa');
	// phiên bản mới

		Route::post('public/update','backend\reup\autoreupController@update');
		Route::post('public/updatehuy','backend\reup\autoreupController@updatehuy');
		Route::post('public/update_public','backend\reup\autoreupController@update_public');
		Route::post('public/update_private','backend\reup\autoreupController@update_private');
		Route::post('public/xoa','backend\reup\autoreupController@xoa');
		Route::post('auto/update','backend\reup\autoreupController@auto_update');
	
});
