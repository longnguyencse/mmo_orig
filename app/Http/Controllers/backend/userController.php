<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use DB;
use Hash;
use Request;
class userController extends Controller
{
    //list user
    function list_user(){
    	$this->authorize('admin');
    	$data["arr"] = DB::table('users')->get();
    	return view('backend.list_user',$data);
		
    }

    //add user
    function add_user(){
    	$this->authorize('admin');
    	return view('backend.add_edit_user');
    }
    //do add user
    public function do_add(){
		$this->authorize('admin');
		$name = Request::get("name");
		$email = Request::get('email');
		// date_default_timezone_set('Asia/Ho_Chi_Minh');
		// $date = date("Y/m/d H:i`");
		// $date = Request::get('date');
		$password = Request::get('password');
		$password = Hash::make($password);
		DB::insert("insert into users (name,email,password) values ('$name','$email','$password') ");
		return redirect('admin/user/');
	}

	//edit user
	public function edit_user($id){
		$this->authorize('admin');
		$data["arr"] = DB::table("users")->where("id","=",$id)->first();
		$data["info"] = DB::table("info")->where("fk_users_id","=",$id)->first();
		return view("backend.add_edit_user", $data);
	}

	//do edit user
	public function do_edit_user($id){
		$this->authorize('admin');
		$name = Request::get('name');
		$email = Request::get('email');
		$password = Request::get('password');
		$number = Request::get('number');
		$sl = Request::get('sl');
		$checkbox = Request::get('checkbox');
		$checkbox1 = Request::get('checkbox1');
		$reup = Request::get('reup');
		$kenhreup = Request::get('kenhreup');
		if($reup=='on'){
			$reup = 1;
		} else $reup = 0;
		DB::update("update info set goi='$number' where fk_users_id=$id ");
		DB::update("update users set name='$name',reup='$reup', kenhreup='$kenhreup', email = '$email',sl='$sl' where id=$id ");
		if (!empty($password)) {
			$password = Hash::make($password);
			DB::update("update users set password='$password' where id=$id ");
		}
		if ($checkbox == "on") {
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$date = date("H:i Y/m/d");
			$time = time();
			DB::update("update info set ngaykichhoat='$date',time='$time' where fk_users_id=$id ");
			DB::update("update users set status=1 where id='$id' ");
		}
		if ($checkbox1 == "on") {
			DB::update("update users set status=0 where id='$id' ");
		}
		return redirect("admin/user");
	}

	//delete user
	public function delete_user($id){
		$this->authorize('admin');
		$arr=DB::table('channel')->where('fk_user_id','=',$id)->get();
		$count=DB::table('channel')->where('fk_user_id','=',$id)->count();
		if ($count != 0) {
			foreach ($arr as $rows) {
				DB::delete("delete from tbl_video where fk_video_id = $rows->pk_channel_id");
			}
		}
		DB::delete("delete from channel where fk_user_id = $id");
		DB::delete("delete from users where id = $id");
		DB::delete("delete from info where fk_users_id = $id");
		$arr1=DB::table('reupchannel')->where('fk_user_id','=',$id)->get();
		$count1=DB::table('reupchannel')->where('fk_user_id','=',$id)->count();
		if ($count1 != 0) {
			foreach ($arr1 as $rows1) {
				DB::delete("delete from reupvideo where fk_reupchannel_id = $rows1->pk_reupchannel_id");
				DB::delete("delete from reupchanneltd where fk_reupchannel_id = $rows1->pk_reupchannel_id");
			}
		}
		DB::delete("delete from reupchannel where fk_user_id = $id");
		return redirect("/admin/user");
	}


}
