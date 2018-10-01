<?php

namespace App\Http\Controllers\backend\reup;

use App\Http\Controllers\Controller;
use DB;
use Hash;
// use Illuminate\Http\Request;
use Auth;
use Request;

class autoreupController extends Controller
{
	//==========Cau hinh=======//
	public function cauhinh($idreup){
		$reupchannel=DB::table('reupchannel')->where('pk_reupchannel_id','=',$idreup)->first();
		$this->authorize('content-view',$reupchannel->fk_user_id);

		$data["arr"]=DB::table('reupchannel')->where('pk_reupchannel_id','=',$idreup)->first();

		return view('backend.reup.cauhinh',$data);
	}
	public function post_cauhinh($id){
		$reupchannel=DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		$this->authorize('content-view',$reupchannel->fk_user_id);

		$edittieude=Request::get('edittieude');
		$editmota=Request::get('editmota');
		$edittag=Request::get('edittag');
		$tieude='';
		if (Request::get('tieude') != '')
			$tieude=Request::get('tieude');
		$mota='';
		if (Request::get('mota') != '')
			$mota=Request::get('mota');
		$tag='';
		if (Request::get('tag') != '')
			$tag=Request::get('tag');
		$thaybang=Request::get('thaybang');
		$thaybangmt=Request::get('thaybangmt');
		$thaybangt=Request::get('thaybangt');
		$ghichu='';
		if (Request::get('ghichu') != '')
			$ghichu=Request::get('ghichu');
		$catdau=Request::get('catdau');
		$catduoi=Request::get('catduoi');
		if ($edittieude==2) {
			$tieude=$tieude." thaybang ".$thaybang;
		}
		if ($editmota==2) {
			$mota=$mota." thaybang ".$thaybangmt;
		}
		if ($edittag==2) {
			$tag=$tag." thaybang ".$thaybangt;
		}
		$gian=Request::get('gian');
		$lap=Request::get('lap');

		DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->update(
			[
				'tieude'=>$tieude,
				'mota'=>$mota,
				'tag'=>$tag,
				'tieude_type'=>urldecode($edittieude),
				'mota_type'=>urldecode($editmota),
				'tag_type'=>$edittag,
				'ghichu'=>$ghichu,
				'catdau'=>$catdau,
				'catduoi'=>$catduoi,
				'gian'=>$gian,
				'lap'=>$lap
			]
		);

		$c_img='';
		$c_img1 = DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		if (Request::hasFile('img')) {
			if(!is_dir("public/upload/".$id)){
				mkdir("public/upload/".$id);
			}
			$c_img = Request::file('img')->getClientOriginalName();
			$c_img = "public/upload/".$id."/".$c_img;
			Request::file('img')->move('public/upload/'.$id,$c_img);
		}
		if ($c_img!="") {
			if (file_exists($c_img1->img)) {
				unlink($c_img1->img);
			}
			DB::update("update reupchannel set img='$c_img' where pk_reupchannel_id = $id");
		}
		$xoa=0;
		if(Request::get('xoa')=='on')
			$xoa=1;
		if ($xoa==1) {
			if (file_exists($c_img1->img)) {
				unlink($c_img1->img);
			}
			DB::update("update reupchannel set img='0' where pk_reupchannel_id = $id");
		}
		
		return redirect("/admin/autoreup/channel");
	}
	//==========Delete channel=======//
	public function delete_channelreup($id){
		$fk=DB::table('reupchanneltd')->where('pk_reupchanneltd_id','=',$id)->first();
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$fk->fk_reupchannel_id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		
		DB::delete("delete from reupchanneltd where pk_reupchanneltd_id = $id");
		
		return redirect("/admin/autoreup/channel/edit/".$fk->fk_reupchannel_id);
	}

	//==========Delete channel=======//
	public function sua($id){
		$video=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		$fk=DB::table('reupchannel')->where('pk_reupchannel_id','=',$video->fk_reupchannel_id)->first();
		$this->authorize('content-view',$fk->fk_user_id);
		
		$data['arr']=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		
		return view('backend.reup.sua',$data);
	}
	//==========do edit video=======//
	public function post_sua($id){
		$fk_reupchannel_id=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$fk_reupchannel_id->fk_reupchannel_id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		$name='';
		if (Request::get('name') != ''){
			$name= Request::get('name');
		}
		$link='';
		if (Request::get('link') != ''){
			$link= Request::get('link');
		}
		$desc='';
		if (Request::get('desc') != '')
			$desc=Request::get('desc');
		$tag='';
		if (Request::get('tag') != '')
			$tag=Request::get('tag');
		$run=0;
		if(Request::get('run')=='on')
			$run=1;
		
		$time=Request::get('time');
		$trangthai=Request::get('status');
		
		$name=urlencode($name);
		$desc=urlencode($desc);
		DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->update(
			array(
				'link'=>$link
			));
		if ($trangthai!='') {
			DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->update(
				array(
					'trangthai'=>$trangthai,
					'sau'=>$time,
					'sua'=>$run

					
				));
		}
		if ($run==1) {
			$time=time();
			DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->update(array('time'=>$time));
		}
		$c_img='';
		$c_img1 = DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		if (Request::hasFile('img')) {
			$c_img = Request::file('img')->getClientOriginalName();
			$c_img = "public/upload/".$id.time()."_".$c_img;
			Request::file('img')->move('public/upload/',$c_img);
		}
		if ($c_img!="") {
			if (file_exists($c_img1->img)) {
				unlink($c_img1->img);
			}
			DB::update("update reupvideo set img='$c_img' where pk_reupvideo_id = $id");
		}
		$fk_reupchannel_id=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		return redirect('/admin/autoreup/video/'.$fk_reupchannel_id->fk_reupchannel_id);
	}

	public function update_public(){
		$id = Auth::user()->id;
		$pk_reupvideo_id=Request::get('pk_reupvideo_id');
		$video=DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->first();
		$channel=DB::table('reupchannel')->where('pk_reupchannel_id','=',$video->fk_reupchannel_id)->first();
		$this->authorize('content-view',$channel->fk_user_id);
		$time=time();
		DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->update(array('trangthai'=>0,'sau'=>0,'time'=>$time));
		echo "Vui lòng đợi để hệ thống cập nhật trạng thái video của bạn!";
	}
	public function update_private(){
		$id = Auth::user()->id;
		$pk_reupvideo_id=Request::get('pk_reupvideo_id');
		$video=DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->first();
		$channel=DB::table('reupchannel')->where('pk_reupchannel_id','=',$video->fk_reupchannel_id)->first();
		$this->authorize('content-view',$channel->fk_user_id);
		$time=time();
		DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->update(array('trangthai'=>1,'sau'=>0,'time'=>$time));
		echo "Vui lòng đợi để hệ thống cập nhật trạng thái video của bạn!";
	}
	public function xoa(){
		$id = Auth::user()->id;
		$pk_reupvideo_id=Request::get('pk_reupvideo_id');
		$video=DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->first();
		$channel=DB::table('reupchannel')->where('pk_reupchannel_id','=',$video->fk_reupchannel_id)->first();
		$this->authorize('content-view',$channel->fk_user_id);
		DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->delete();
		echo "Video đã được xóa!";
	}
	
	
	
	
	
	
	//==========List auto upload=======//
	public function list_channel(){
		$id = Auth::user()->id;
		$data["arr"]=DB::table('reupchannel')->where('fk_user_id','=',$id)->get();
		$data["count"] = DB::table('reupchannel')->where('fk_user_id','=',$id)->count();
		$data["sl"] = Auth::user()->sl;
		return view('backend.reup.list_channel',$data);
	}

	//==========Add Auto Upload=======//
	public function add_channel(){
		$id = Auth::user()->id;
		$count_channel=DB::table('reupchannel')->where('fk_user_id','=',$id)->count();
	    	$this->authorize('sl',$count_channel);
		$id = Auth::user()->id;
		$data["arr"]=DB::table('reupchannel')->where('fk_user_id','=',$id)->get();
		return view('backend.reup.add_channel',$data);
	}

	//==========Edit Auto Upload=======//
	public function edit_channel($id){
		$admin = Auth::user()->id;
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		$data['dem']=DB::table('reupchanneltd')->where('fk_reupchannel_id','=',$id)->count();
		$data["arr"]=DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		$data["arr1"]=DB::table('reupchanneltd')->where('fk_reupchannel_id','=',$id)->get();
		return view('backend.reup.edit_channel',$data);
	}

	//==========Delete channel=======//
	public function delete_channel($id){
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		function removeAllFile($dir){
		    if (is_dir($dir))
		    {
		        $structure = glob(rtrim($dir, "/").'/*');
		        if (is_array($structure)) {
		            foreach($structure as $file) {
		                if (is_dir($file)) recursiveRemove($file);
		                else if (is_file($file)) @unlink($file);
		            }
		        }
		    }
		}

		DB::delete("delete from reupchannel where pk_reupchannel_id = $id");
		DB::delete("delete from reupvideo where fk_reupchannel_id = $id");
		DB::delete("delete from reupchanneltd where fk_reupchannel_id = $id");
		//xoa thu muc luu anh cua kenh	
		if(is_dir('public/upload/'.$id)){
			removeAllFile('public/upload/'.$id);
			rmdir('public/upload/'.$id);
		}
		return redirect("/admin/autoreup/channel");
	}

	//==========list video=======//
	public function list_video($id){
		$admin = Auth::user()->id;
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		$data["kenh"] = DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		$data["channel"]=$id;
		$data["arr"]=DB::table('reupvideo')->where('fk_reupchannel_id','=',$id)->orderBy('pk_reupvideo_id', 'desc')->get();
		return view('backend.reup.list_video',$data);
	}

	//==========list video=======//
	public function add_video($id){
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		$data["arr"] = DB::table('reupchannel')->where('pk_reupchannel_id','=',$id)->first();
		return view('backend.reup.add_video',$data);
	}

	//==========edit video=======//
	public function edit_video($id){
		$fk_reupchannel_id=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$fk_reupchannel_id->fk_reupchannel_id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		$data["arr"] = DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		return view('backend.reup.edit_video',$data);
	}

	//==========do edit video=======//
	public function do_edit_video($id){
		$fk_reupchannel_id=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$fk_reupchannel_id->fk_reupchannel_id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		$name='';
		if (Request::get('name') != ''){
			$name= Request::get('name');
			$name=urldecode($name);
		}	
		$desc='';
		if (Request::get('desc') != '')
			$desc=Request::get('desc');
		$tag='';
		if (Request::get('tag') != '')
			$tag=Request::get('tag');
		$run=0;
		if(Request::get('run')=='on')
			$run=1;
		$status=Request::get('status');
		if ($status==0) {
			$status=Request::get('publishat');
		}
		
		DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->update(array('name'=>$name,'description'=>$desc,'tag'=>$tag,'run'=>$run,'status'=>$status));
		$c_img='';
		$c_img1 = DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		if (Request::hasFile('img')) {
			if(!is_dir("public/upload/".$c_img1->fk_reupchannel_id)){
				mkdir("public/upload/".$c_img1->fk_reupchannel_id);
			}
			$c_img = Request::file('img')->getClientOriginalName();
			$c_img = "public/upload/".$c_img1->fk_reupchannel_id."/".$id.time()."_".$c_img;
			Request::file('img')->move('public/upload/'.$c_img1->fk_reupchannel_id,$c_img);
		}
		if ($c_img!="") {
			if (file_exists($c_img1->img)) {
				unlink($c_img1->img);
			}
			DB::update("update reupvideo set img='$c_img' where pk_reupvideo_id = $id");
		}
		$fk_reupchannel_id=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		return redirect('/admin/autoreup/video/'.$fk_reupchannel_id->fk_reupchannel_id);
	}


	//==========Delete channel=======//
	public function delete_video($id){
		$fk_reupchannel_id=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		$fk_user_id=DB::table('reupchannel')->where('pk_reupchannel_id','=',$fk_reupchannel_id->fk_reupchannel_id)->first();
		$this->authorize('content-view',$fk_user_id->fk_user_id);
		$arr=DB::table('reupvideo')->where('pk_reupvideo_id','=',$id)->first();
		if (file_exists($arr->img)) {
			unlink($arr->img);
		}
		DB::delete("delete from reupvideo where pk_reupvideo_id = $id");
		return redirect("/admin/autoreup/video/".$arr->fk_reupchannel_id);
	}


	//==========Delete channel=======//
	public function update(){
		$pk_reupvideo_id=Request::get('pk_reupvideo_id');
		DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->update(array('run'=>1));
		
// echo $pk_reupvideo_id;
	}

	//==========Delete channel=======//
	public function updatehuy(){
		$pk_reupvideo_id=Request::get('pk_reupvideo_id');
		DB::table('reupvideo')->where('pk_reupvideo_id','=',$pk_reupvideo_id)->update(array('run'=>0));
		
// echo $pk_reupvideo_id;
	}

	//==========update auto channel=======//
	public function auto_update(){
		$pk_reupchannel_id=Request::get('pk_reupchannel_id');
		$checked = Request::get('checked');
		
		if ($checked==1) {
			DB::table('reupchannel')->where('pk_reupchannel_id','=',$pk_reupchannel_id)->update(array('auto'=>1));
		} else{
			DB::table('reupchannel')->where('pk_reupchannel_id','=',$pk_reupchannel_id)->update(array('auto'=>0));
		}

	}
}
