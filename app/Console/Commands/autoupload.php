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
class autoupload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Upload ok';

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

$test=DB::table('myvideo')->where('pk_myvideo_id','=',38)->first();


$OAUTH2_CLIENT_ID = '557368165627-r3kq137fl9dos0s5c5i89aj0g7icfb8q.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'mZo--e93zXlQrRXqEibGJDiq';

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$client->setAccessType("offline");
$client->setApprovalPrompt("force");

// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

// Check if an auth token exists for the required scopes
// $tokenSessionKey = 'token-' . $client->prepareScopes();
// if (isset($_GET['code'])) {
//     if (strval($_SESSION['state']) !== strval($_GET['state'])) {
//         die('The session state did not match.');
//     }
//     $client->authenticate($_GET['code']);
//     $_SESSION[$tokenSessionKey] = $client->getAccessToken();
// }

// neu ton tai token
    if(file_exists('token.txt')) {
        $refresh_token = file_get_contents('token.txt');
        $client->refreshToken($refresh_token);
        $_SESSION['token'] = $client->getAccessToken();
        $access_token = $_SESSION['token']['access_token'];
        $client->setAccessToken($access_token);
        $refresh_token = $_SESSION['token']['refresh_token'];

    }
// end neu ton tai token

// down va xu li video
        
    $ffmpeg = "public\\ffmpeg\\bin\\ffmpeg";
    // get mychannel to reup
    $mychannel=DB::table('mychannel')->where('linkreup','!=','')->get();
    // get mychannel to reup
    $myvideo=DB::table('myvideo')->where('link','!=','')->get();

    
    $duration = $test->duration;

    // echo $duration."  ";

    $data = file_get_contents("https://www.youtube.com/get_video_info?video_id=".$test->linkreup);
    parse_str($data);
    $arr = explode(",", $url_encoded_fmt_stream_map);
    $i=0;
    foreach ($arr as $item) {
        $i++;
        parse_str($item);
        if ($i==1) {
            $time=time();
            $name = $time.".mp4";
            // luu video
            file_put_contents("public/download/".$name, fopen($url, 'r'));
            
        }
        
    }

    function get_nb($duration,$t,$s){
        $result = strstr($duration, $t);
        $result1 = strstr($result,$s, true);
        $result1=ltrim($result1,$t);
        return $result1;
    }

    if(strpos($duration, 'H')>0){
        $h = get_nb($duration,'T','H');
        $m = get_nb($duration,'H','M');
        $s = get_nb($duration,'M','S');
        $cat = ($m*60+$s)-10;
        $mm=floor($cat/60);
        $ss=$cat-$mm*60;
        $cmd = "$ffmpeg -y -ss 00:00:05 -i public/download/$name -to $h:$mm:$ss -codec copy public/download/ok.mp4";
        // echo $h." ".$m." ".$s;
    } else{
        if(strpos($duration, 'M')>0){
            $m = get_nb($duration,'T','M');
            $s = get_nb($duration,'M','S');
            $cat = ($m*60+$s)-10;
            $mm=floor($cat/60);
            $ss=$cat-$mm*60;
            $cmd = "$ffmpeg -y -ss 00:00:05 -i public/download/$name -to 00:$mm:$ss -codec copy public/download/ok.mp4";
            // echo $m." ".$mm." ".$ss;
        } else{
             $s = get_nb($duration,'T','S');

             // echo $s;
        }
    }
    $cmd1 = "$ffmpeg -y -i public/download/ok.mp4 -codec copy -metadata title='' -metadata artist='' -metadata album_artist='' -metadata album='' -metadata date='' -metadata track='' -metadata genre='' -metadata publisher='' -metadata encoded_by='' -metadata copyright='' -metadata composer='' -metadata performer='' -metadata TIT1='' -metadata TIT3='' -metadata disc='' -metadata TKEY='' -metadata TBPM='' -metadata language='eng' -metadata encoder='' -preset superfast public/download/upload.mp4";
    shell_exec($cmd);
    shell_exec($cmd1);
   
// end down va xu li video

// upload video
// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
    echo "ok";
    $htmlBody = '';
    try { 

        //REPLACE this value with the path to the file you are uploading.
        $videoPath = "public/download/upload.mp4";

        // Create a snippet with title, description, tags and category ID
        // Create an asset resource and set its snippet metadata and type.
        // This example sets the video's title, description, keyword tags, and
        // video category.
        $snippet = new Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle($test->name);
        $snippet->setDescription($test->description);
        $snippet->setTags(array($test->tag));

        // Numeric video category. See
        // https://developers.google.com/youtube/v3/docs/videoCategories/list
        $snippet->setCategoryId("22");

        // Set the video's status to "public". Valid statuses are "public",
        // "private" and "unlisted".
        $status = new Google_Service_YouTube_VideoStatus();
        $status->privacyStatus = "public";

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


    // set thumbnail video
        // REPLACE this value with the video ID of the video being updated.
        $videoId = $status1['id'];

        // REPLACE this value with the path to the image file you are uploading.
        $imagePath = $test->img;

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
        DB::table('myvideo')->where('pk_myvideo_id','=',38)->update(['link'=>$status1['id']]);
        // xoa file 
            unlink($test->img);
            unlink("public/download/".$name);
            unlink("public/download/ok.mp4");
            unlink("public/download/upload.mp4");
        // end xoa file
        // If you want to make other calls after the file upload, set setDefer back to false
        $client->setDefer(false);

    } catch (Google_Service_Exception $e) {
        $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
        $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    }

    // $_SESSION[$tokenSessionKey] = $client->getAccessToken();
}
// end upload video




    }
}
