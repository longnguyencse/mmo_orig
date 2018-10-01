<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\video;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
class videoController extends Controller
{
    public function post(Request $req){
        $video = new video;
        $video->c_name = $req->video_name;
        $video->fk_video_id = $req->pk_channel_id+1;
        $video->c_img = $req->video_img;
        $video->c_view = $req->video_view;
        $video->c_link   = $req->video_id;
        $video->c_publish = $req->video_pub;
        $video->c_die = "";
        $video->c_song = "";
        $video->c_died = 0;
        $video->save();
        // echo $req->video_name;
    }
}