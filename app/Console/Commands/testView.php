<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_YouTube;
class testView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is test view';

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
        set_time_limit(0);
        function curl($url, $socks='', $post='', $referer='') {
          global $config;
          $agent = 'Mozilla/5.0 (Windows NT 6.1; rv:13.0) Gecko/20100101 Firefox/13.0';
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: vi']);
          curl_setopt($ch, CURLOPT_URL, $url);
          if ($post) {
          curl_setopt($ch, CURLOPT_POST, true); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
          }
          curl_setopt($ch, CURLOPT_USERAGENT, $agent);
          curl_setopt($ch, CURLOPT_HEADER, 0); 
          if ($referer) {
          curl_setopt($ch, CURLOPT_REFERER, $referer);
          }
          if ($socks) {
          curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
          curl_setopt($ch, CURLOPT_PROXY, $socks);
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
          }
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,7);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
          //curl_setopt($ch, CURLOPT_COOKIEFILE,$config['cookie_file']); 
            //curl_setopt($ch, CURLOPT_COOKIEJAR,$config['cookie_file']); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
          
          $result = curl_exec($ch);
          curl_close($ch);
          return $result;
        }

        function get_string_between($string, $start, $end){
            $string = " ".$string;
            $ini = strpos($string,$start);
            if ($ini == 0) return "";
            $ini += strlen($start);
            $len = strpos($string,$end,$ini) - $ini;
            return substr($string,$ini,$len);
        }

        require_once __DIR__ . '/../../../public/vendor/autoload.php';
        date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("H:i Y/m/d");
        DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'test view', '$date');");
        $user=DB::table('users')->where('status','=',1)->get(); // get user active
        foreach ($user as $user_rows) {
        echo $user_rows->id." user \n";
          // DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'user song', '$user_rows->email');");
          $info=DB::table('info')->where('fk_users_id','=',$user_rows->id)->first();
            
          if ($info->api != '') { //neu ton tai api

          // lap test:view
            //$DEVELOPER_KEY = $info->api;
            //$client = new Google_Client();
            //$client->setDeveloperKey($DEVELOPER_KEY);

            // Define an object that will be used to make all API requests.
            //$youtube = new Google_Service_YouTube($client);

            $htmlBody = '';
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("H:i Y/m/d");
            try {
              $time=time();
              $channel = DB::table("channel")->where('fk_user_id','=',$user_rows->id)->where('die','=',0)->get(); // get kenh cua user active
              //$channel = DB::table("channel")->where('pk_channel_id','=',86)->get(); // get kenh cua user active
              foreach ($channel as $key) {
    echo $key->c_link." channel \n";
                $url = 'https://www.youtube.com/channel/'.$key->c_link.'/about';
                $channel = curl($url);
                $form = get_string_between($channel,'class="about-stats">','tham gia');
                $check=strpos($form, 'Đã' );

                //check kenh theo doi
                if($check!=false){
                  $check1=strpos($form, 'người đăng ký' );
      if ($check1!=false) {
      $formID = explode("</span>",$form);
      $c_subtang=preg_replace('/[^0-9]/', '', $formID[0]);
      
      $check3=strpos($form, 'lượt xem' );
      if ($check3!=false) {
        $c_viewtang=preg_replace('/[^0-9]/', '', $formID[1]);
      } else {
        $c_viewtang=0;
      }
      
      } else{
      $check2=strpos($form, 'lượt xem' );
      if ($check2!=false) {
        $formID = explode("lượt xem",$form);
        $c_viewtang=preg_replace('/[^0-9]/', '', $formID[0]);
        $c_subtang=0;
      } else {
        $c_subtang=0;
        $c_viewtang=0;
      }
      }

                  //update view tang
                  $hour = date("H");
                  if($hour==00)
                    DB::update("UPDATE `channel` SET `c_sub` = '$c_subtang',`c_view` = '$c_viewtang' WHERE `channel`.`c_link` = '$key->c_link'");
                  DB::update("UPDATE `channel` SET `c_subtang` = '$c_subtang',`c_viewtang` = '$c_viewtang' WHERE `channel`.`c_link` = '$key->c_link'");

                  $arr = DB::table("tbl_video")->where('fk_video_id','=',$key->pk_channel_id)->orderBy('pk_video_id', 'desc')->limit(10)->get(); // get video cua kenh
                  foreach ($arr as $rows) {
                    echo $rows->c_link."\n";
                    $url='https://www.youtube.com/watch?v='.$rows->c_link;
                    $video = curl($url);
                    $video = get_string_between($video,'class="watch-view-count">','xem');
                    $check=strpos($video, 'lượt' );
                    $checkdb = DB::select("select * from tbl_video where c_link='$rows->c_link' ");
                    if ($check!=false) {
                      $v_view = str_replace('Không','0',$video);
                      $v_view=preg_replace('/[^0-9]/', '', $v_view);

                    echo $v_view."view \n";
                      if ($checkdb[0]->c_died == 1) {//neu video trong db chet
                        DB::update("UPDATE `tbl_video` SET `c_viewtang` = '$v_view',c_song ='$date',`c_died` = 0 WHERE `c_link` = '$rows->c_link';");
                      } else{ // neu video trong db song
                        $hour = date("H");
                        if($hour==00)
                          DB::update("UPDATE `tbl_video` SET `c_view` = '$v_view' WHERE `c_link` = '$rows->c_link';");
                        DB::update("UPDATE `tbl_video` SET `c_viewtang` = '$v_view' WHERE `c_link` = '$rows->c_link';");
                      }
                    } else{
                      //set video die
                      if ($checkdb[0]->c_died == 1) {//neu video trong db chet
                      } else{ // neu video trong db song
                        $die ='';
                        $die = get_string_between($video,'unavailable-message" class="message">','</h1>');
                        DB::update("UPDATE `tbl_video` SET `c_died` = 1,`die_do`='$die',c_die ='$date' WHERE `c_link` = '$rows->c_link';");
                      }
                    }
                  }
                } else{
                  //set kenh die
                  $die='';
                  $die = get_string_between($channel,'Tài khoản này','</div>');
                  if($die!=''){
                    $die='Tài khoản này'.$die;
                    DB::update("UPDATE `channel` SET die = 1,`date`='$date',`die_do`='$die' WHERE `channel`.`c_link` = '$key->c_link'");
                  }
                }
                //end check kenh theo doi

                
              }
              
            } catch (Google_Service_Exception $e) {
              $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
            } catch (Google_Exception $e) {
              $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
            }
          // end lap test:view
            }
        }
          
    }
}
