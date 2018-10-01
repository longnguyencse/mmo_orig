<?php

namespace App\Http\Controllers\backend\reup;

use App\Http\Controllers\Controller;
use DB;
use Hash;
// use Illuminate\Http\Request;
use Auth;
use Request;

class autouploadController extends Controller
{
	//==========Auto Upload=======//
	public function list_channel(){

		$data["arr"]=DB::table('mychannel')->get();
		return view('backend.list_autoupload',$data);
	}

	//==========Add Auto Upload=======//
	public function add_channel(){
		
		$data["arr"]=DB::table('mychannel')->get();
		return view('backend.add_autoupload',$data);
	}

	//==========Edit Auto Upload=======//
	public function edit_channel($id){
		
		$data["arr"]=DB::table('mychannel')->where('pk_mychannel_id','=',$id)->first();
		return view('backend.edit_autoupload',$data);
	}

	//==========Delete channel=======//
	public function delete_channel($id){

		DB::delete("delete from myvideo where fk_mychannel_id = $id");
		DB::delete("delete from mychannel where pk_mychannel_id = $id");
		return redirect("/admin/autoupload/channel");
	}

	//==========list video=======//
	public function list_video($id){

		$data["channel"]=$id;
		$data["arr"]=DB::table('myvideo')->where('fk_mychannel_id','=',$id)->get();
		return view('backend.list_autouploadvideo',$data);
	}

	//==========list video=======//
	public function add_video($id){

		$data["arr"] = DB::table('mychannel')->where('pk_mychannel_id','=',$id)->first();
		return view('backend.add_autouploadvideo',$data);
	}

	//==========edit video=======//
	public function edit_video($id){

		$data["arr"] = DB::table('myvideo')->where('pk_myvideo_id','=',$id)->first();
		return view('backend.edit_autouploadvideo',$data);
	}

	//==========do edit video=======//
	public function do_edit_video($id){

		$name= Request::get('name');
		$desc=Request::get('desc');
		$tag=Request::get('tag');
		$auto1=Request::get('auto');
		$auto = $auto1=='on'?1:0;
		DB::update("update myvideo set name='$name',auto='$auto',tag='$tag',description='$desc' where pk_myvideo_id = $id");
		
		$private='';
		$private=Request::get('private');
		if ($private != '') {
			DB::update("update myvideo set private='$private' where pk_myvideo_id = $id");
		}
		$c_img='';
		if (Request::hasFile('img')) {
			$c_img = Request::file('img')->getClientOriginalName();
			$c_img = "public/upload/".time()."_".$c_img;
			Request::file('img')->move('public/upload/',$c_img);
		}
		if ($c_img!="") {
			$c_img1 = DB::table('myvideo')->where('pk_myvideo_id','=',$id)->first();
			if (file_exists($c_img1->img)) {
				unlink($c_img1->img);
			}
			DB::update("update myvideo set img='$c_img' where pk_myvideo_id = $id");
		}
		return redirect('/admin/autoupload/video/edit/'.$id);
	}


	//==========Delete channel=======//
	public function delete_video($id){

		$arr=DB::table('myvideo')->where('pk_myvideo_id','=',$id)->first();
		DB::delete("delete from myvideo where pk_myvideo_id = $id");
		return redirect("/admin/autoupload/video/".$arr->fk_mychannel_id);
	}
}
