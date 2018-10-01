<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_YouTube;

class autoaddvideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:addvideo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is auto add video';

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

        // $user=DB::table('users')->where('id','=',1)->get(); // get user active
        $user=DB::table('users')->where('status','=',1)->get(); // get user active
        foreach ($user as $user_rows) {
          
          // lap test:view
            $DEVELOPER_KEY = 'AIzaSyCSoUcbMFCnPGcnQPQ2UumLqeoVksI66c8';
            $client = new Google_Client();
            $client->setDeveloperKey($DEVELOPER_KEY);

            // Define an object that will be used to make all API requests.
            $youtube = new Google_Service_YouTube($client);

            $htmlBody = '';
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("H:i Y/m/d");
            try {
              $time=time();
              $channel = DB::table("channel")->where('fk_user_id','=',$user_rows->id)->where('die','=',0)->get(); // get kenh cua user active
              foreach ($channel as $key) {
                // echo $key->c_name;
                $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
                  'id' => $key->c_link
                ));
                
                if (count($channelsResponse['items']) == 1) { //neu channel song
                  foreach ($channelsResponse as $viewChannel) { //update view sub tang
                    
                    //get playlist video uploaded
                    $uploadsListId = $viewChannel['contentDetails']['relatedPlaylists']['uploads'];
                    $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
                      'playlistId' => $uploadsListId,
                      'maxResults' => 50
                    ));
                  }
                  //get id video
                  foreach ($playlistItemsResponse['items'] as $playlistItem) {
                    $v_link=$playlistItem['snippet']['resourceId']['videoId'];
                    $count=0;
                    $count=DB::table('tbl_video')->where('c_link','=',$v_link)->where('fk_video_id','=',$key->pk_channel_id)->count();
                    if ($count==1) {
                      break;
                    }
                    // echo $v_link." ";
                    $videoResponse = $youtube->videos->listVideos('snippet,statistics', 
                      array('id' => $v_link)
                    );
                    // get detail video
                    foreach ($videoResponse['items'] as $video) {
                      $v_img=$video['snippet']['thumbnails']['default']['url'];
                      $v_name=$video['snippet']['title'];
                      $v_name = str_replace("'", "&#39", $v_name);
                      $v_view=$video['statistics']['viewCount'];  
                      $v_publish=$video['snippet']['publishedAt'];
                      
                      DB::insert("INSERT INTO `tbl_video` (`pk_video_id`, `fk_video_id`, `c_img`, `c_name`, `c_view`, `c_link`, `c_publish`, `c_die`, `c_song`, `c_died`,`c_time`) VALUES (NULL, '$key->pk_channel_id', '$v_img', '$v_name', '$v_view','$v_link', '$v_publish', '', '', 0,'$time');");
                    }
                  }
                
                } else{ // neu kenh chet
                  if ($key->die == 0) {
                    DB::update("UPDATE `channel` SET die = 1,c_time1 = '$time',`date`='$date' WHERE `channel`.`c_link` = '$key->c_link'");
                  }
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
