<?php

namespace App\Http\Controllers;

use Request;
use DB;
use Auth;
use Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id = Auth::user()->id;
        $dem = DB::table('info')->where('fk_users_id','=',$id)->count();
        if ($dem == 0) {
            DB::insert("insert into info (fk_users_id,api,clientID,clientSecret,ngaykichhoat,goi) values ($id,'','','','',0) ");
        }
        $data["arr"] = DB::table('info')->where('fk_users_id','=',$id)->first();
        // echo $data["arr"]->goi;
        $goi = $data["arr"]->goi;
        $t = time() - $data["arr"]->time;
        $sd = $t/86400;
        $conlai = $goi-$sd;
        if ($conlai <=0) {
            DB::update("update users set status=0 where id='$id' ");
        }
        $data["ngay"] = $conlai;
        return view('home',$data);
    }
    function post(){
        $id = Auth::user()->id;
        $api = Request::get("api");
        $clientID = Request::get("clientID");
        $clientSecret = Request::get("clientSecret");
	DB::table('channel')->where('fk_user_id','=',$id)->update(array('die'=>0));
	DB::table('reupchannel')->where('fk_user_id','=',$id)->update(array('die'=>0));
        DB::update("update info set api='$api',clientID='$clientID',clientSecret='$clientSecret' where fk_users_id = $id ");
        if (Request::get("password_1") != "") {
            $password_1 = Request::get("password_1");
            $password_2 = Request::get("password_2");
            if ($password_1 == $password_2) {
                $password_2 = Hash::make($password_2);
                DB::update("update users set password='$password_2' where id = $id ");
            }
        }
        return redirect('home');
    }
}
