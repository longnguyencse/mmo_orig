<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_YouTube;
use Google_Service_YouTube_Video;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_VideoStatus;
use Google_Http_MediaFileUpload;
class autoreup1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:reup1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto reup ok';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    if (!file_exists(__DIR__ . '/../../../public/vendor/autoload.php')){
      $d=__DIR__ ;
      DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, '$d', '01');");
    }
    require_once __DIR__ . '/../../../public/vendor/autoload.php';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date("H:i Y/m/d");
    //DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'auto reup', '$date');");
    //$user=DB::table('users')->where('status','=',1)->where('id','=',78)->get(); // get user active    
    //DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'auto reup', 'user');");
    function get_type($id){
        $position_f=strpos($id,"/");
        $position_t=strpos($id,";");
        return substr($id,$position_f+1,$position_t-$position_f-1);
    }
    //ghep auto
    function ghep($mau,$thay,$pp,$tag){
      if ($pp!=0) {
        if ($pp==1) {
          if($tag==1){
            if($mau=='')
              return $thay;
            else
              return $mau.",".$thay;
          }
          else
            return $mau." ".$thay;
        }
        if ($pp==2) {
          $var=explode('thaybang',$thay);
          $muonthay=trim($var[0]);
          $thaybang=trim($var[1]);
          return str_replace($muonthay, $thaybang, $mau);
        }
        if ($pp==3) {
          return $thay;
        }
      } else{
        return $mau;
      } 
    }
    //end ghep auto
    function get_nb($duration,$t,$s){
        $result = strstr($duration, $t);
        $result1 = strstr($result,$s, true);
        $result1=ltrim($result1,$t);
        return $result1;
    }
//remove all file
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
    //check 403 error
    function http_response($url)
    { 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HEADER, TRUE); 
        curl_setopt($ch, CURLOPT_NOBODY, TRUE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        $head = curl_exec($ch); 
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch); 

        if(!$head) 
        {  
         return FALSE; 
        } 

        return $httpCode;
    }
    $q=(count(glob("public/download1/*")) === 0) ? 0 : 1;
        if (0==0){
        $user=DB::table('users')->where('status','=',1)->where('reup','=',1)->inRandomOrder()->get(); // get user active
        foreach ($user as $user_rows) {
            $ren_count=0;
            $info=DB::table('info')->where('fk_users_id','=',$user_rows->id)->first();
            if ($info->api != '') { //neu ton tai api
                $reupchannel = DB::table('reupchannel')->where('fk_user_id','=',$user_rows->id)->where('running','=',0)->where('loi','=',0)->where('die','=',0)->inRandomOrder()->get(); //get channel cua user active
                //$reupchannel = DB::table('reupchannel')->where('pk_reupchannel_id','=',94)->get(); //get channel cua user active
                foreach ($reupchannel as $reupchannel_rows) {
                    DB::table('reupchannel')->where('pk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->update(array('running'=>1));
                    $time=time();
                    $tru=$time-$reupchannel_rows->time;
                    echo $time." - ".$reupchannel_rows->time." = ";
                    $mau=$reupchannel_rows->gian*60;
                    echo $tru." - ".$mau." \n";
                    if($reupchannel_rows->time==0 || ($time-$reupchannel_rows->time)>$reupchannel_rows->gian*60){
                        //DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'auto reup', 'ok');");
                        echo "id kenh ".$reupchannel_rows->pk_reupchannel_id." \n ";
                        $OAUTH2_CLIENT_ID = $reupchannel_rows->clientID;
                        $OAUTH2_CLIENT_SECRET = $reupchannel_rows->clientSecret;

                        $client = new Google_Client();
                        $client->setClientId($OAUTH2_CLIENT_ID);
                        $client->setClientSecret($OAUTH2_CLIENT_SECRET);
                        $client->setScopes('https://www.googleapis.com/auth/youtube');
                        $youtube = new Google_Service_YouTube($client);

                        $refresh_token=$reupchannel_rows->log;

                        $client->refreshToken($refresh_token);
                        $_SESSION['token'] = $client->getAccessToken();
                        $access_token = $_SESSION['token']['access_token'];
                        try{
                                    $client->setAccessToken($access_token);
                                    }
                        catch(\InvalidArgumentException $e) {
                            //DB::table('reupchannel')->where('pk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->update(array('loi'=>1));
                            continue;
                        }
                        if ($client->getAccessToken()) { //neu ton tai token
                            try {
                                //get vieo reup cua kenh va link khac rong
                                $reupvideo=DB::table('reupvideo')->where('fk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->where('link','=','')->where('die','=',0)->where('running','=',0)->limit(1)->where('run','=',1)->get();
                                // echo "string";
                                foreach ($reupvideo as $reupvideo_rows) {
                                DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('running'=>1));
                                removeAllFile('public/download1'); 
                                echo "id video ".$reupvideo_rows->pk_reupvideo_id." ";
                                    
                                // *******down va xu li video********
                                    $ffmpeg = "/usr/bin/ffmpeg";
                                    $youtubedl= "/usr/local/bin/youtube-dl";

                                    // $ffmpeg = "public\\ffmpeg\\bin\\ffmpeg";
                                    // $youtubedl= "public\\youtube-dl\\youtube-dl";

                                    $duration = $reupvideo_rows->duration;

                                    // download file reup
                                    echo $reupvideo_rows->linkreup."\n";
                                    $namevideo=time().$reupvideo_rows->linkreup;
                                    $downvideo="$youtubedl -o 'public/download1/$namevideo.%(ext)s' https://www.youtube.com/watch?v=$reupvideo_rows->linkreup";
                                    
                                    // echo $reupvideo_rows->linkreup;
                                    $data = file_get_contents("https://www.youtube.com/get_video_info?video_id=".$reupvideo_rows->linkreup);
                                    parse_str($data);
                                    if(isset($url_encoded_fmt_stream_map)){
                                        $arr = explode(",", $url_encoded_fmt_stream_map);
                                        $i=0;
                                        foreach ($arr as $item) {
                                            $i++;
                                            parse_str($item);
                                            if ($i==1) {
                                                if(isset($url)){
                                                    $errorcode = http_response($url);
                                                } else $errorcode = 0;
                                                
                                                if($errorcode==403 || !isset($type) || $errorcode==0){
                                                    shell_exec($downvideo);
                                                    $file=glob("public/download1/$namevideo.*");
                                                    if(count($file)==0){
                                                        DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('die'=>1));
                                                        continue;
                                                    }
                                                    $cat=explode('/', $file[0]);
                                                    $file_reup=$cat[2];
                                                } else{
                                                $a=get_type($type);
                                                $name = $namevideo.".".$a;
                                                // luu video
                                                    file_put_contents("public/download1/".$name, fopen($url, 'r'));
                                                    $file_reup=$name;
                                                }
                                            }
                                        }
                                    } else {
                                        shell_exec($downvideo);
                                        $file=glob("public/download1/$namevideo.*");
                                        if(count($file)==0){
                                            DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('die'=>1));
                                            continue;
                                        }
                                        $cat=explode('/', $file[0]);
                                        $file_reup=$cat[2];
                                    }
                                    
                                    echo $file_reup." down xong \n";
                                    // break;
                                
                                    if(strpos($duration, 'H')>0){
                                        $h = get_nb($duration,'T','H');
                                        $m=0;
                                        if(strpos($duration, 'M')>0){
                                            $m = get_nb($duration,'H','M');
                                       }
                                        $s=0;
                                        if(strpos($duration, 'S')>0){
                                            if($m==0){
                                                $s = get_nb($duration,'H','S');
                                            } else{
                                                $s = get_nb($duration,'M','S');
                                            }
                                       }
                                        $catdau=$reupchannel_rows->catdau;
                                        $catduoi=$reupchannel_rows->catduoi;
                                        //echo " chuoi ".$h." ".$m." ".$s;break;
                                        $tong=($h*3600+$m*60+$s);
                                        if (($catdau+$catduoi)<$tong) {
                                            $cat = $tong - ($catdau+$catduoi);
                                        }else{
                                            $catdau=5;
                                            $cat = $tong-10;
                                        }

                                        $hh=floor($cat/3600);
                                        if ($hh==0) {
                                            $mm=floor($cat/60);
                                        } else{
                                            $mm=floor(($cat-$hh*3600)/60);
                                        }
                                        $ss=$cat-$hh*3600-$mm*60;
                                        
                                        if($catdau>60){
                                            $mt=floor($catdau/60);
                                            $st=$catdau-$mt*60;
                                            $cmd = "$ffmpeg -y -ss 00:$mt:$st -i public/download1/$file_reup -to $hh:$mm:$ss -codec copy public/download1/ok$file_reup";
                                        } else{
                                            $cmd = "$ffmpeg -y -ss 00:00:$catdau -i public/download1/$file_reup -to $hh:$mm:$ss -codec copy public/download1/ok$file_reup";
                                        }
                                    } else{
                                        if(strpos($duration, 'M')>0){
                                            $m = (int)get_nb($duration,'T','M');
                                            $s=0;
                                            if(strpos($duration, 'S')>0){
                                                $s = (int)get_nb($duration,'M','S');
                                            }
                                            $catdau=$reupchannel_rows->catdau;
                                            $catduoi=$reupchannel_rows->catduoi;
                                            $tong=($m*60+$s);
                                            if (($catdau+$catduoi)<$tong) {
                                                $cat = $tong - ($catdau+$catduoi);
                                            }else{
                                                $catdau=5;
                                                $cat = $tong-10;
                                            }
                                            $mm=floor($cat/60);
                                            $ss=$cat-$mm*60;
                                            if($catdau>60){
                                                $mt=floor($catdau/60);
                                                $st=$catdau-$mt*60;
                                                $cmd = "$ffmpeg -y -ss 00:$mt:$st -i public/download1/$file_reup -to 00:$mm:$ss -codec copy public/download1/ok$file_reup";
                                            } else{
                                                $cmd = "$ffmpeg -y -ss 00:00:$catdau -i public/download1/$file_reup -to 00:$mm:$ss -codec copy public/download1/ok$file_reup";
                                            }
                                        } else{
                                            $s = get_nb($duration,'T','S');
                                            $cmd = "$ffmpeg -y -ss 00:00:05 -i public/download1/$file_reup -to 00:00:$s -codec copy public/download1/ok$file_reup";
                                        }
                                    }

                                    $cmd1 = "$ffmpeg -y -i public/download1/ok$file_reup -codec copy -metadata title='' -metadata artist='' -metadata album_artist='' -metadata album='' -metadata date='' -metadata track='' -metadata genre='' -metadata publisher='' -metadata encoded_by='' -metadata copyright='' -metadata composer='' -metadata performer='' -metadata TIT1='' -metadata TIT3='' -metadata disc='' -metadata TKEY='' -metadata TBPM='' -metadata language='eng' -metadata encoder='' -preset superfast public/download1/upload$file_reup";
                                    shell_exec($cmd);
                                    shell_exec($cmd1);

                                // *******end down va xu li video*******


                                    //REPLACE this value with the path to the file you are uploading.
                                    $videoPath = "public/download1/upload$file_reup";

                                    // Create a snippet with title, description, tags and category ID
                                    // Create an asset resource and set its snippet metadata and type.
                                    // This example sets the video's title, description, keyword tags, and
                                    // video category.
                                    $v_name=ghep(urldecode($reupvideo_rows->name),$reupchannel_rows->tieude,$reupchannel_rows->tieude_type,0);
                                    $desc=ghep(urldecode($reupvideo_rows->description),$reupchannel_rows->mota,$reupchannel_rows->mota_type,0);
                                    $catdd=ghep(urldecode($reupvideo_rows->tag),$reupchannel_rows->tag,$reupchannel_rows->tag_type,1);
                                                    
                                    if ($reupchannel_rows->lap!=0) {
                                        $lap=str_repeat(urldecode($reupvideo_rows->name)."\n", $reupchannel_rows->lap);
                                        $desc=$lap.$desc;
                                    }

                                    $v_name=mb_substr($v_name,0,100, "utf-8");
                                    $desc=mb_substr($desc,0,5000, "utf-8");
                                    $catdd=mb_substr($catdd,0,500, "utf-8");
                                    
                                    $l=ltrim($catdd, ',');
                                    $tag=rtrim($l, ',');
                            
                                    $snippet = new Google_Service_YouTube_VideoSnippet();
                                    $snippet->setTitle($v_name);
                                    $snippet->setDescription($desc);
                                    $snippet->setTags(array($tag));
                                    

                                    // Numeric video category. See
                                    // https://developers.google.com/youtube/v3/docs/videoCategories/list
                                    $snippet->setCategoryId("22");

                                    // Set the video's status to "public". Valid statuses are "public",
                                    // "private" and "unlisted".
                                    $status = new Google_Service_YouTube_VideoStatus();
                                    if ($reupvideo_rows->status==1) {
                                        $status->privacyStatus = "public";
                                    } else{
                                        $status->privacyStatus = "private";
                                        $status->publishAt = $reupvideo_rows->status;
                                    }

                                    // Associate the snippet and status objects with a new video resource.
                                    $video = new Google_Service_YouTube_Video();
                                    $video->setSnippet($snippet);
                                    $video->setStatus($status);

                                    // Specify the size of each chunk of data, in bytes. Set a higher value for
                                    // reliable connection as fewer chunks lead to faster uploads. Set a lower
                                    // value for better recovery on less reliable connections.
                                    $chunkSizeBytes = 1 * 1024 * 1024;

                                    // Setting the defer flag to true tells the client to return a request which can be called
                                    // with ->execute(); instead of making the API call immediately.
                                    $client->setDefer(true);

                                    // Create a request for the API's videos.insert method to create and upload the video.
                                    $insertRequest = $youtube->videos->insert("status,snippet", $video);

                                    // Create a MediaFileUpload object for resumable uploads.
                                    $media = new Google_Http_MediaFileUpload(
                                        $client,
                                        $insertRequest,
                                        'video/*',
                                        null,
                                        true,
                                        $chunkSizeBytes
                                    );
                                    $media->setFileSize(filesize($videoPath));

                                    try{
                                        // Read the media file and upload it chunk by chunk.
                                        $status = false;
                                        $handle = fopen($videoPath, "rb");
                                        while (!$status && !feof($handle)) {
                                          $chunk = fread($handle, $chunkSizeBytes);
                                          $status1 = $media->nextChunk($chunk);
                                        }
        
                                        fclose($handle);
                            


                                        // If you want to make other calls after the file upload, set setDefer back to false
                                        $client->setDefer(false);

                                        //get anh
                                        $name_img=time().$reupvideo_rows->linkreup.".jpg";
                                        $url = 'https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/maxresdefault.jpg';
                                        
                                        // DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('img'=>'public/upload/'.$name_img));
                                        if(file_exists($reupvideo_rows->img)){
                                            $uploadimg=$reupvideo_rows->img;
                                            $uploadimg1=$uploadimg;
                                        } else{
                                            // if($reupchannel_rows->anh==1)
                                            if (@getimagesize($url)) {
                                               file_put_contents("public/upload/".$name_img, file_get_contents('https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/maxresdefault.jpg'));
                                            } else {
                                              $url = 'https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/sddefault.jpg';
                                              if (@getimagesize($url)) {
                                                file_put_contents("public/upload/".$name_img, file_get_contents('https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/sddefault.jpg'));
                                              } else{
                                                $url = 'https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/hqdefault.jpg';
                                                if (@getimagesize($url)) {
                                                  file_put_contents("public/upload/".$name_img, file_get_contents('https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/hqdefault.jpg'));
                                                } else{
                                                  $url = 'https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/mqdefault.jpg';
                                                  if (@getimagesize($url)) {
                                                    file_put_contents("public/upload/".$name_img, file_get_contents('https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/mqdefault.jpg'));
                                                  } else{
                                                    $url = 'https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/default.jpg';
                                                    if (@getimagesize($url)) {
                                                      file_put_contents("public/upload/".$name_img, file_get_contents('https://i.ytimg.com/vi/'.$reupvideo_rows->linkreup.'/default.jpg'));
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                            $uploadimg="public/upload/".$name_img;
                                            $uploadimg1=$uploadimg;
                                        }
                                        if ($reupchannel_rows->img!='0') {
                                            // $resize="$ffmpeg -y -i $uploadimg -vf scale=1280:720 public/upload/$reupchannel_rows->pk_reupchannel_id/resize.jpg";
                                            // $img_resize="public/upload/resize.jpg";
                                            // shell_exec($resize);
                                            $overlay="$ffmpeg -y -i $uploadimg -i $reupchannel_rows->img -filter_complex \"[1]scale=iw/2:-1[b];[0:v][b] overlay=25:25\" public/upload/$reupchannel_rows->pk_reupchannel_id/upload.jpg";
                                            shell_exec($overlay);
                                            $uploadimg="public/upload/$reupchannel_rows->pk_reupchannel_id/upload.jpg";
                                        }
                                        if (file_exists($uploadimg)) {
                                        // set thumbnail video
                                            // REPLACE this value with the video ID of the video being updated.
                                            $videoId = $status1['id'];
                                            echo "ok img upload... \n";
                                            // REPLACE this value with the path to the image file you are uploading.
                                            $imagePath = $uploadimg;

                                            // Specify the size of each chunk of data, in bytes. Set a higher value for
                                            // reliable connection as fewer chunks lead to faster uploads. Set a lower
                                            // value for better recovery on less reliable connections.
                                            $chunkSizeBytes = 1 * 1024 * 1024;

                                            // Setting the defer flag to true tells the client to return a request which can be called
                                            // with ->execute(); instead of making the API call immediately.
                                            $client->setDefer(true);

                                            // Create a request for the API's thumbnails.set method to upload the image and associate
                                            // it with the appropriate video.
                                            $setRequest = $youtube->thumbnails->set($videoId);

                                            // Create a MediaFileUpload object for resumable uploads.
                                            $media = new Google_Http_MediaFileUpload(
                                                $client,
                                                $setRequest,
                                                'image/png',
                                                null,
                                                true,
                                                $chunkSizeBytes
                                            );
                                            $media->setFileSize(filesize($imagePath));


                                            // Read the media file and upload it chunk by chunk.
                                            $status = false;
                                            $handle = fopen($imagePath, "rb");
                                            while (!$status && !feof($handle)) {
                                              $chunk = fread($handle, $chunkSizeBytes);
                                              $status = $media->nextChunk($chunk);
                                            }

                                            fclose($handle);
                                            unlink($uploadimg);
                                            if (file_exists($uploadimg1))
                                                unlink($uploadimg1);
                                            // unlink($img_resize);
                                            
                                        // end set thum
                                        }
                                        
                                        //encode to update database
                                        $v_name=urlencode($v_name);
                                        $desc=urlencode($desc);
                                        $tag=urlencode($tag);
                                    
                                        DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(['link'=>$status1['id'],'running'=>0,'name'=>$v_name,'description'=>$desc,'tag'=>'$tag']);
                                        echo $file_reup." upload xong xoa... \n";
                                        // xoa file 
                                        array_map('unlink', glob("public/download1/*"));
                                        // end xoa file
                                        // If you want to make other calls after the file upload, set setDefer back to false
                                        $client->setDefer(false);
                                        DB::table('reupchannel')->where('pk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->update(array('time'=>$time));
                                        $ren_count++;
                                    }
                                    catch(\Google_Exception $e) {
                                      //DB::table('reupchannel')->where('pk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->update(array('loi'=>1));
                                      continue;
                                    }
                                    
                                }// end foreach reupvideo
                            } catch (Google_Service_Exception $e) {
                                $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                                    htmlspecialchars($e->getMessage()));
                            } catch (Google_Exception $e) {
                            //DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(['die'=>1]);
                                $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                                    htmlspecialchars($e->getMessage()));
                            }
                        }// end ton tai token
                    } else{
                        DB::table('reupchannel')->where('pk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->update(array('running'=>0));
                        continue;
                    }//neu chua du thoi gian gian
                    DB::table('reupchannel')->where('pk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->update(array('running'=>0));
                    if($ren_count!=0){
                        break;
                    }
                }// end foreach reupchannel
            }//end ton tai api
            if($ren_count!=0){
                    break;
            }
        } //end foreach user
        }
    }// handle
}//end class
