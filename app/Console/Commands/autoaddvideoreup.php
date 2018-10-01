<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_YouTube;

class autoaddvideoreup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:addvideoreup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is autoaddvideoreup';

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
        function clean($string) {
          return urlencode($string);
        }
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
              $muonthay=trim($var[1]);
              $thaybang=trim($var[0]);
              return str_replace($muonthay, $thaybang, $mau);
            }
            if ($pp==3) {
              return $thay;
            }
          } else{
            return $mau;
          } 
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("H:i Y/m/d");
        DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'auto add reup', '$date');");
        //$user=DB::table('users')->where('id','=',170)->get(); // get user active
        $user=DB::table('users')->where('status','=',1)->where('reup','=',1)->get(); // get user active
        foreach ($user as $user_rows) {
          $info=DB::table('info')->where('fk_users_id','=',$user_rows->id)->first();
          
          // lap test:view
            $DEVELOPER_KEY = $info->api;
            $client = new Google_Client();
            $client->setDeveloperKey($DEVELOPER_KEY);

            // Define an object that will be used to make all API requests.
            $youtube = new Google_Service_YouTube($client);

            $htmlBody = '';
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("H:i Y/m/d");
            try {
              
              $channel = DB::table("reupchannel")->where('fk_user_id','=',$user_rows->id)->where('auto','=',1)->where('die','=',0)->get(); // get kenh cua user active

              //$channel = DB::table("reupchannel")->where('pk_reupchannel_id','=',386)->get(); // get kenh cua user active
              foreach ($channel as $channel_rows) {
                echo $channel_rows->link." link \n";
                $url = 'https://www.youtube.com/channel/'.$channel_rows->link.'/videos';
                $kenhchinh = curl($url);
                $die = get_string_between($kenhchinh,'Tài khoản này','</div>');

                if ($die=='') { // neu kenh chinh k die
                  $channelreup = DB::table("reupchanneltd")->where('fk_reupchannel_id','=',$channel_rows->pk_reupchannel_id)->where('die','=',0)->get();
                  foreach ($channelreup as $key) {
                    echo $key->link." link reup\n";
                    $url = 'https://www.youtube.com/channel/'.$key->link.'/videos';
                    $kenhtheodoi = curl($url);
                    $die = get_string_between($kenhtheodoi,'Tài khoản này','</div>');
                    if ($die=='') {// neu kenh theo doi k die
                      $formID = explode('<li class="channels-content-item yt-shelf-grid-item">',$kenhtheodoi);
                      foreach ($formID as $rows) {
                        $v_link = get_string_between($rows,'contains-addto"><a href="/watch?v=','" class="yt-uix-sessionlink"');
                        echo $v_link."\n";
                        if ($v_link!='') {
                          $count=DB::table('reupvideo')->where('linkreup','=',$v_link)->where('fk_reupchannel_id','=',$channel_rows->pk_reupchannel_id)->count();
                          echo " count ".$count."\n";
                          if ($count!=0) {
                            break;
                          }
                          echo " ".$v_link."\n";
                          $videoResponse = $youtube->videos->listVideos('snippet,contentDetails,statistics', 
                            array('id' => $v_link)
                          );
                          // get detail video
                          foreach ($videoResponse['items'] as $video) {

                            $v_name=$video['snippet']['title'];
                            $v_view=$video['statistics']['viewCount'];
                            $name_img=time().$v_link.'.jpg';
                            $v_img="public/upload/".$name_img;
                            $duration=$video['contentDetails']['duration'];
                            $desc=$video['snippet']['description'];
                            $tag='';
                            if ($video['snippet']['tags'] != '') {
                              $tag=$video['snippet']['tags'];
                              $tag=implode(',',$tag);
                            }

                            $v_name=clean($v_name);
                            $desc=clean($desc);
                            $tag=clean($tag);
                            
                            DB::table('reupvideo')->insert(
                              [
                                'pk_reupvideo_id' => NULL, 
                                'fk_reupchannel_id' => $channel_rows->pk_reupchannel_id,
                                'link' => '', 
                                'linkreup' => $v_link,
                                'name' => $v_name,
                                'img' => $v_img,
                                'view' => $v_view,
                                'duration' => $duration,
                                'description' => $desc,
                                'tag' => $tag,
                                'run' => 1,
                                'do'=>''
                              ]
                            );
                          }
                        }
                      }
                    }else{
                      DB::table('reupchanneltd')->where('pk_reupchanneltd_id','=',$key->pk_reupchanneltd_id)->update(array('die'=>1));
                    }
                  }
                }//end neu kenh chinh k die
                else{
                    $die='';
                    $die = get_string_between($kenhchinh,'Tài khoản này','</div>');
                    $die='Tài khoản này'.$die;
                    DB::table('reupchannel')->where('pk_reupchannel_id','=',$channel_rows->pk_reupchannel_id)->update(array('die'=>1,'die_do'=>$die));
                  }
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
