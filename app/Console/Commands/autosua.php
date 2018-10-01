<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_YouTube;
use Google_Http_MediaFileUpload;

class autosua extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sua';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto sua';

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
        function yt_exists($videoID) {
            $theURL = "http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$videoID&format=json";
            $headers = get_headers($theURL);

            return (substr($headers[0], 9, 3) !== "404");
        }

        
    if (!file_exists(__DIR__ . '/../../../public/vendor/autoload.php')){
      $d=__DIR__ ;
      DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, '$d', '01');");
    }
    require_once __DIR__ . '/../../../public/vendor/autoload.php';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date("H:i Y/m/d");
    //DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'auto reup', '$date');");
    $user=DB::table('users')->where('status','=',1)->where('reup','=',1)->get(); // get user active
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
                        $client->setAccessToken($access_token);
                        if ($client->getAccessToken()) { //neu ton tai token
                            try { 
                                //echo $reupchannel_rows->link." ";
                                //get vieo reup cua kenh va link khac rong
                                $reupvideo=DB::table('reupvideo')->where('fk_reupchannel_id','=',$reupchannel_rows->pk_reupchannel_id)->where('link','!=','')->where('die','=',0)->where('sua','=',1)->get();
                                // echo "<pre>";
                                // print_r($reupvideo);
                                // echo "</pre>"; break;
                                foreach ($reupvideo as $reupvideo_rows) {
                                    $videoId = $reupvideo_rows->link;
                                    echo $videoId." <br> "; 
                                    if (yt_exists($videoId)) {
                                        $listResponse = $youtube->videos->listVideos("snippet",
                                            array('id' => $videoId));
                                        $video = $listResponse[0];
                                        $videoSnippet = $video['snippet'];
                                    } else {
                                        echo "Khong tim thay video trong kenh!";
                                      DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('die'=>1,'do'=>'Video không tồn tại trong kênh'));
                                    }
                                    

                                    // If $listResponse is empty, the specified video was not found.
                                    if ($videoSnippet['channelId'] != $reupchannel_rows->link) {
                                        echo $videoSnippet['channelId'];
                                      echo "Khong tim thay video trong kenh!";
                                      DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('die'=>1,'do'=>'Video không tồn tại trong kênh'));
                                    } else {
                                      // Since the request specified a video ID, the response only
                                      // contains one video resource.

                                      $tags = array($reupvideo_rows->tag);
                                      $title=urldecode($reupvideo_rows->name);
                                      $description=urldecode($reupvideo_rows->description);

                                      // Set the tags array for the video snippet
                                      $videoSnippet['title'] = $title;
                                      $videoSnippet['tags'] = $tags;
                                      $videoSnippet['description'] = $description;

                                      // Update the video resource by calling the videos.update() method.
                                      $updateResponse = $youtube->videos->update("snippet,status", $video);
                                      
                                      $img=$reupvideo_rows->img;
                                      // set thumbnail video
                                      if (file_exists($img)) {

                                          // REPLACE this value with the path to the image file you are uploading.
                                          $imagePath = $img;

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
                                          unlink($img);
                                      }
                                      // end set thum
                                    }
                                    DB::table('reupvideo')->where('pk_reupvideo_id','=',$reupvideo_rows->pk_reupvideo_id)->update(array('sua'=>0));
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
