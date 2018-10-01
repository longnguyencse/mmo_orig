<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_YouTube;
use Google_Http_MediaFileUpload;

class autostatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    $user=DB::table('users')->where('status','=',1)->where('reup','=',1)->get(); // get user 
    //$user=DB::table('users')->where('status','=',1)->where('id','=',1)->get(); // get user active
    //DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'auto reup', 'user');");
        if (0==0){
            foreach ($user as $user_rows) {
              $info=DB::table('info')->where('fk_users_id','=',$user_rows->id)->first();
                if ($info->api != '') { //neu ton tai api
                    $reupchannel = DB::table('reupchannel')->where('fk_user_id','=',$user_rows->id)->where('die','=',0)->get(); //get channel cua user active
                    foreach ($reupchannel as $reupchannel_rows) { 
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
                                //echo $reupchannel_rows->link." ";
                                //get vieo reup cua kenh va link khac rong
                                

                                $reupvideo=DB::table('reupvideo')->where('fk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->whereColumn('trangthai','<>','trangthai1')->where('die','=',0)->get();
                                //echo "<pre>"; print_r($reupvideo); break;
                                foreach ($reupvideo as $reupvideo_rows) { echo "ok";
                                	$videoId = $reupvideo_rows->link;
                                    if ($reupvideo_rows->trangthai==2) {
                                    	echo "xoa";
                                        $response=$youtube->videos->delete($videoId);
                                        DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->delete();
                                        break;
                                    }
                                    
                                    echo $videoId." ";
                                    // Call the API's videos.list method to retrieve the video resource.
                                    $listResponse = $youtube->videos->listVideos("status",
                                        array('id' => $videoId));
                                    // echo $videoId."<br>";
                                    $video = $listResponse[0];
                                    $videoStatus = $video['status'];

                                    // If $listResponse is empty, the specified video was not found.
                                    if (empty($listResponse)) {
                                      echo "Khong tim thay video trong kenh!";
                                      DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('sua'=>0));
                                      DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('trangthai1'=>$reupvideo_rows->trangthai));
                                    } else {
                                      $time=time(); 
                                      $check=$time-$reupvideo_rows->time;
                                    echo $check." ";
                                      if ($check>$reupvideo_rows->sau*60) {
                                          if($reupvideo_rows->trangthai==0){
                                            $videoStatus['privacyStatus'] = "public";
                                          }else{
                                            $videoStatus['privacyStatus'] = "private";
                                          }echo $check." ";
                                          $updateResponse = $youtube->videos->update("status", $video);
                                          DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('trangthai1'=>$reupvideo_rows->trangthai));
                                      }

                                      // end set thum
                                    }
                                }
                                //end foreach array
                            } catch (Google_Service_Exception $e) {
                                $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                                    htmlspecialchars($e->getMessage()));
                            } catch (Google_Exception $e) {
                                $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                                    htmlspecialchars($e->getMessage()));
                            }
                        }// end ton tai token
                    }// end foreach reupchannel
                }//end ton tai api
            } //end foreach user
        }
    
    }
}
