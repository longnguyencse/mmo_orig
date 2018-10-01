<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use DB;
use Hash;
use Illuminate\Http\Request;
use Auth;

class channelController extends Controller
{
    //list channel
    function list_channel(){
    	// ------phan quyen
    	$id = Auth::user()->id;
    	
    	// $this->authorize('content-view',$id);
    	$this->authorize('status');
		$data["arr"] = DB::table('channel')->where('fk_user_id','=',$id)->get();
		$data["count"] = DB::table('channel')->where('fk_user_id','=',$id)->count();
		$data["sl"] = Auth::user()->sl;
    	return view('backend.list_channel',$data);
    }

    //add channel
    public function add_channel(){
    	// ------phan quyen
    	$id = Auth::user()->id;
    	
    	// $this->authorize('content-view',$id);
    	$this->authorize('status');
    	$count_channel=DB::table('channel')->where('fk_user_id','=',$id)->count();
    	$this->authorize('sl',$count_channel);

		return view('backend.add_edit_channel');
	}

	//delete channel
	public function delete_channel($idchannel){
		$arr = DB::table('channel')->where('pk_channel_id','=',$idchannel)->first();
		// ------phan quyen
    	// $id = Auth::user()->id;
    	
    	$this->authorize('content-view',$arr->fk_user_id);
    	$this->authorize('status');

		DB::delete("delete from channel where pk_channel_id = $idchannel");
		DB::delete("delete from tbl_video where fk_video_id = $idchannel");
		return redirect("/admin/channel");
	}


// video
	public function list_video($idvideo){
		$arr = DB::table('channel')->where('pk_channel_id','=',$idvideo)->first();
		// ------phan quyen
    	$id = $arr->fk_user_id;
    	
    	$this->authorize('content-view',$id);
    	$this->authorize('status');

    	$data["channel"] = DB::table('tbl_video')->where('fk_video_id','=',$idvideo)->first();
    	$data["kenh"] = DB::table('channel')->where('pk_channel_id','=',$idvideo)->first();
		$data["arr"] = DB::table('tbl_video')->where('fk_video_id','=',$idvideo)->orderBy('pk_video_id', 'desc')->get();
		return view('backend.list_video',$data);
	}
	public function add_video($id_add){
		$id = Auth::user()->id;
    	
    	// $this->authorize('content-view',$id);
    	$this->authorize('status');
    	
    	// $data["arr"] = DB::table('channel')->where('fk_user_id','=',$id)->get();
    	$data["arr1"] = DB::table('channel')->where('pk_channel_id','=',$id_add)->first();
		return view('backend.add_edit_video',$data);
	}
	public function delete_video($idvideo){
		$arr=DB::table('tbl_video')->where('pk_video_id','=',$idvideo)->first();
		$channel=DB::table('channel')->where('pk_channel_id','=',$arr->fk_video_id)->first();
		// ------phan quyen
    	// $id = Auth::user()->id;
    	
    	$this->authorize('content-view',$channel->fk_user_id);
    	$this->authorize('status');
		DB::delete("delete from tbl_video where pk_video_id = $idvideo");
		return redirect("/admin/channel/video/".$arr->fk_video_id);
	}
	
	//==========Searcg=======//
	public function key(){
		$id = Auth::user()->id;
		$data["arr"]=DB::table('info')->where('fk_users_id','=',$id)->first();
		return view('backend.key',$data);
	}

	//==========Comment=======//
	public function comment(){
		$id = Auth::user()->id;
		$data["arr"]=DB::table('info')->where('fk_users_id','=',$id)->first();
		return view('backend.comment',$data);
	}

	// //==========Auto Upload=======//
	// public function autoupload(){

	// 	$data["arr"]=DB::table('mychannel')->get();
	// 	return view('backend.autoupload',$data);
	// }

	// //==========Auto Upload=======//
	// public function add_autoupload(){

	// 	return view('backend.add_edit_autoupload');
	// }
}
