<!DOCTYPE html>
<html>
<head>
  <title>Admin page</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <base href="http://localhost/code-3/public_html/">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
	<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Hướng dẫn
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('huong-dan/api') }}">Thêm Api</a></li>
            <li><a href="{{ url('huong-dan/tim-key') }}">Hướng dẫn tìm key</a></li>
            <li><a href="{{ url('huong-dan/auto-reup') }}">Hướng dẫn Auto Reup</a></li>
            <li><a href="{{ url('huong-dan/theo-doi') }}">Thống kê, theo dõi kênh</a></li>
            <li><a href="{{ url('huong-dan/auto-comment') }}">Hướng dẫn Auto Comment</a></li>
          </ul>
        </li>
        <li><a href="{{ url('admin/key') }}">Lọc key</a></li>
        <li><a href="{{ url('admin/comment') }}">Auto Comment</a></li>
        
        @can('status') <!-- kiem tra kich hoat -->
        <li><a href="{{ url('admin/channel') }}">Theo dõi kênh</a></li>
        <li><a href="{{ url('admin/autoreup/channel') }}">Auto Reup</a></li>
        @endcan('status') <!--end kiem tra kich hoat -->

        @can('admin')
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('admin/user') }}">User</a></li>
          </ul>
        </li>
        @endcan('admin')

        <li><a href="{{ url('home') }}">Tài khoản</a></li>
        <li><a href="{{ url('admin/logout') }}">Đăng xuất</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<?php
function clean($string) {
   return urlencode($string);
}
function id_video($tring){
  $dai=strlen($tring);
  return substr($tring,32, $dai-32);
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

$id = Auth::user()->id;
$dem = DB::table('info')->where('fk_users_id','=',$id)->count();
if ($dem == 0) {
    DB::insert("insert into info (fk_users_id,api,clientID,clientSecret,ngaykichhoat,time,goi) values ($id,'','','','','',0) ");
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
/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
if (!file_exists('public/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once 'public/vendor/autoload.php';
$htmlBody = '';
date_default_timezone_set('Asia/Ho_Chi_Minh');
$date = date("H:i d/m/Y");
$fk_user_id = Auth::user()->id;
$info = DB::table('info')->where('fk_users_id','=',$fk_user_id)->first();
// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
  /*
   * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
   * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
   * Please ensure that you have enabled the YouTube Data API for your project.
   */
  $DEVELOPER_KEY = $info->api;

  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);

  $htmlBody = '';
  try {



    // add channel theo doi
    if (isset($_GET['q'])) {
      
      $count=DB::table('channel')->where('c_link','=',$_GET['q'])->where('fk_user_id','=',$fk_user_id)->count();

      if ($count == 0) {
        $channelsResponse = $youtube->channels->listChannels('snippet,contentDetails,statistics', array(
          'id' => $_GET['q']
        ));
        $time = time();
        foreach ($channelsResponse['items'] as $channel) {
          $c_link=$_GET['q'];
          $c_name=$channel['snippet']['title'];
          $c_name = clean($c_name);
          $c_sub=$channel['statistics']['subscriberCount'];
          $c_view=$channel['statistics']['viewCount'];
          $c_publish=$channel['snippet']['publishedAt'];
          $c_tongvideo=$channel['statistics']['videoCount'];
          $ghichu=$_GET['ghichu'];
          
          //insert channel
          DB::insert("INSERT INTO `channel` 
            (`pk_channel_id`, `fk_user_id`, `c_name`, `c_link`, `c_sub`, `c_view`,`c_publish`, `c_tongvideo`, `c_date`, `c_time`, `ghichu`) VALUES (NULL, '$fk_user_id','$c_name', '$c_link', '$c_sub', '$c_view','$c_publish', '$c_tongvideo', '$date','$time','$ghichu');");
          
          //get playlist video uploaded
          $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
          $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
            'playlistId' => $uploadsListId,
            'maxResults' => $_GET['sl']
          ));

          //get fk_video_id
          $arr = DB::select("SELECT * FROM channel WHERE fk_user_id = $fk_user_id ORDER BY pk_channel_id DESC limit 0,1");
          $fk_video_id = $arr[0]->pk_channel_id;
          
          //get id video
          foreach ($playlistItemsResponse['items'] as $playlistItem) {
            $v_link=$playlistItem['snippet']['resourceId']['videoId'];
            $videoResponse = $youtube->videos->listVideos('snippet,contentDetails,statistics', 
              array('id' => $v_link)
            );
            //get detail video
            foreach ($videoResponse['items'] as $video) {
              $v_img=$video['snippet']['thumbnails']['default']['url'];
              $v_name=$video['snippet']['title'];
              $v_name = str_replace("'", "&#39", $v_name);
              $v_name = clean($v_name);
              $v_view=$video['statistics']['viewCount'];  
              $v_publish=$video['snippet']['publishedAt'];

              DB::insert("INSERT INTO `tbl_video` (`pk_video_id`, `fk_video_id`, `c_img`, `c_name`, `c_view`, `c_link`, `c_publish`, `c_die`, `c_song`, `c_died`,`c_time`) VALUES (NULL, '$fk_video_id', '$v_img', '$v_name', '$v_view','$v_link', '$v_publish', '', '', 0,'$time');");
            }
          }
        }
        // return back();
        // return redirect()->to('/route'); 
        echo "<div style='margin-top:50px; color:red; font-size:30px'>Kênh đã được thêm!!!</div>";
      } else{ echo "<div style='margin-top:50px; color:red; font-size:30px'>Kênh đã tồn tại!!!</div>";}
    }
    // end add channel theo doi




    // add video theo doi
    if (isset($_GET['video'])) {
      $v_link=id_video($_GET['video']);

      $fk_user_id = Auth::user()->id;
      $count=DB::table('channel')->where('c_link','=',$_GET['kenh'])->where('fk_user_id','=',$fk_user_id)->first();
      $arr=DB::table('tbl_video')->where('fk_video_id','=',$count->pk_channel_id)->get();
      $flag=0;
      foreach ($arr as $rows) {
        if ($v_link == $rows->c_link) {
          $flag=1;
          break;
        }
      }
      if ($flag == 0) {
        $videoResponse = $youtube->videos->listVideos('snippet,contentDetails,statistics', 
          array('id' => $v_link)
        );
        foreach ($videoResponse['items'] as $video) {
          if ($_GET['kenh'] == $video['snippet']['channelId']) {
            $v_img=$video['snippet']['thumbnails']['default']['url'];
            $v_name=$video['snippet']['title'];
            $v_name = str_replace("'", "&#39", $v_name);
            $v_name = clean($v_name);
            $v_view=$video['statistics']['viewCount'];  
            $v_publish=$video['snippet']['publishedAt'];
            $time = time();
            DB::insert("INSERT INTO `tbl_video` (`pk_video_id`, `fk_video_id`, `c_img`, `c_name`, `c_view`,`c_link`, `c_publish`, `c_die`, `c_song`, `c_died`,`c_time`) VALUES (NULL, '$count->pk_channel_id', '$v_img', '$v_name', '$v_view','$v_link', '$v_publish', '', '', 0,'$time');");
            echo "<div style='margin-top:50px; color:red; font-size:30px'>Video đã được thêm!!!</div>";
          } else{
            echo "<div style='margin-top:50px; color:red; font-size:30px'>Video không thuộc kênh này hoặc không tồn tại!!!</div>";
          }
         
        }
      }else{
        echo "<div style='margin-top:50px; color:red; font-size:30px'>Video đã tồn tại!!!</div>";
      }
    }
    // end add video theo doi




$redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    
// add my channel to reup
// echo $redirect;
$chuoi1=strpos($redirect, 'autoreup/channel/add');
if ($chuoi1>0) {

  session_start();
  // $htmlBody = 'ok';
  $OAUTH2_CLIENT_ID = $info->clientID;
  $OAUTH2_CLIENT_SECRET = $info->clientSecret;

  $client = new Google_Client();
  $client->setClientId($OAUTH2_CLIENT_ID);
  $client->setClientSecret($OAUTH2_CLIENT_SECRET);
  $client->setScopes('https://www.googleapis.com/auth/youtube');
  
  $client->setRedirectUri('http://localhost/code-3/public_html/index.php/admin/autoreup/channel/add');
  
  $client->setAccessType("offline");
  $client->setApprovalPrompt("force");

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);
  // Check if an auth token exists for the required scopes
  $tokenSessionKey = 'token-' . $client->prepareScopes();

  // ton tai dang nhap
  if (isset($_GET['code'])) {
      if (strval($_SESSION['state']) !== strval($_GET['state'])) {
          die('The session state did not match.');
      }

      $client->authenticate($_GET['code']);
      $_SESSION[$tokenSessionKey] = $client->getAccessToken();
      $access_token = $client->getAccessToken();

      $data = file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=id&mine=true&access_token='.$access_token['access_token']);
      $data = json_decode($data, true);

      // ton tai session token
      if (isset($_SESSION[$tokenSessionKey]) && isset($_GET['code'])) {
          $link = $data['items'][0]['id'];
          $client->setAccessToken($_SESSION[$tokenSessionKey]);
          $refresh_token = $_SESSION[$tokenSessionKey]['refresh_token'];
          $count = DB::table('reupchannel')->where('link','=',$link)->where('fk_user_id','=',$fk_user_id)->count();
          if ($count == 0) {
            $channelsResponse = $youtube->channels->listChannels('snippet,contentDetails,statistics', array(
              'id' => $link
            ));
            // get channel
            foreach ($channelsResponse['items'] as $channel) {
              $c_name=$channel['snippet']['title'];
              $c_name = str_replace("'", "&#39", $c_name);
              $c_name = clean($c_name);
              DB::insert("INSERT INTO `reupchannel` (`pk_reupchannel_id`, `fk_user_id`, `link`,`linkreup`, `name`, `publish`, `log`,clientID,clientSecret,tieude,mota,tag,ghichu) VALUES (NULL, '$fk_user_id', '$link','', '$c_name', '$date', '$refresh_token', '$info->clientID', '$info->clientSecret','','','','');");

              //add video reup to theo doi
              $count=DB::table('channel')->where('c_link','=',$link)->where('fk_user_id','=',$fk_user_id)->count();
        if ($count == 0) {
          $time = time();
          foreach ($channelsResponse['items'] as $channel) {
            $c_link=$link;
            $c_name=$channel['snippet']['title'];
            $c_name = clean($c_name);
            $c_sub=$channel['statistics']['subscriberCount'];
            $c_view=$channel['statistics']['viewCount'];
            $c_publish=$channel['snippet']['publishedAt'];
            $c_tongvideo=$channel['statistics']['videoCount'];
            
            //insert channel
            DB::insert("INSERT INTO `channel` 
              (`pk_channel_id`, `fk_user_id`, `c_name`, `c_link`, `c_sub`, `c_view`,`c_publish`, `c_tongvideo`, `c_date`, `c_time`) VALUES (NULL, '$fk_user_id','$c_name', '$c_link', '$c_sub', '$c_view','$c_publish', '$c_tongvideo', '$date','$time');");
            
            //get playlist video uploaded
            $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
            $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
              'playlistId' => $uploadsListId,
              'maxResults' => 10
            ));

            //get fk_video_id
            $arr = DB::select("SELECT * FROM channel WHERE fk_user_id = $fk_user_id ORDER BY pk_channel_id DESC limit 0,1");
            $fk_video_id = $arr[0]->pk_channel_id;
            
            //get id video
            foreach ($playlistItemsResponse['items'] as $playlistItem) {
              $v_link=$playlistItem['snippet']['resourceId']['videoId'];
              $videoResponse = $youtube->videos->listVideos('snippet,contentDetails,statistics', 
                array('id' => $v_link)
              );
              //get detail video
              foreach ($videoResponse['items'] as $video) {
                $v_img=$video['snippet']['thumbnails']['default']['url'];
                $v_name=$video['snippet']['title'];
                $v_name = str_replace("'", "&#39", $v_name);
                $v_name = clean($v_name);
                $v_view=$video['statistics']['viewCount'];  
                $v_publish=$video['snippet']['publishedAt'];

                DB::insert("INSERT INTO `tbl_video` (`pk_video_id`, `fk_video_id`, `c_img`, `c_name`, `c_view`, `c_link`, `c_publish`, `c_die`, `c_song`, `c_died`,`c_time`) VALUES (NULL, '$fk_video_id', '$v_img', '$v_name', '$v_view','$v_link', '$v_publish', '', '', 0,'$time');");
              }
            }
          }
        }
        //end add video reup to theo doi
            } 
            //end get channel
          }else{
                DB::update("UPDATE `reupchannel` SET `log` = '$refresh_token',`clientID` = '$info->clientID',`clientSecret` = '$info->clientSecret', die=0, loi=0, running=0 WHERE `reupchannel`.`link` = '$link';");
                $update=DB::table('reupchannel')->where('link','=',$link)->first();
                DB::table('reupvideo')->where('fk_reupchannel_id','=',$update->pk_reupchannel_id)->update(array('die'=>0,'running'=>0));
          }
          unset($_SESSION[$tokenSessionKey]);
          return redirect()->to('http://localhost/code-3/public_html/index.php/admin/autoreup/channel')->send();
      }
      // end ton tai session token
  }
  // end ton tai dang nhap

  // If the user hasn't authorized the app, initiate the OAuth flow
    $state = mt_rand();
    $client->setState($state);
    $_SESSION['state'] = $state;
    $authUrl = $client->createAuthUrl();
    $htmlBody = <<<END

    <h3>Thêm kênh REUP của bạn!</h3>
    <p><a href="$authUrl" style='font-weight:bold;' class="btn btn-primary" >Thêm kênh</a></p>
END;
  
}
// end add my channel to reup



// update link to reup
if (isset($_GET['linkreup'])) {
      $linkreup = $_GET['linkreup'];
      $linkreupchannel = $_GET['linkreupchannel'];
      $arr=DB::table('reupchannel')->where('link','=',$linkreupchannel)->first();
      $pk_reupchannel_id = $arr->pk_reupchannel_id;
      $count=DB::table('reupchanneltd')->where('fk_reupchannel_id','=',$pk_reupchannel_id)->where('link','=',$linkreup)->count();
      $dem=DB::table('reupchanneltd')->where('fk_reupchannel_id','=',$pk_reupchannel_id)->count();

      if ($count==0 && $dem < Auth::user()->kenhreup) { 
        // get channel
    $slvideo1=$_GET['sl'];
    if ($slvideo1>50) $slvideo1=50;
    if ($slvideo1==0) $slvideo1=50;
    $channelsResponse = $youtube->channels->listChannels('snippet,contentDetails,statistics', array(
      'id' => $_GET['linkreup']
    ));
    
    foreach ($channelsResponse['items'] as $channel) {
      DB::table('reupchanneltd')->insert(array('fk_reupchannel_id'=>$pk_reupchannel_id,'link'=>$linkreup));
      //get playlist video uploaded
      $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
      $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
        'playlistId' => $uploadsListId,
        'maxResults' => $slvideo1
      ));

      $fk_reupchannel_id = $pk_reupchannel_id;
      
      //get id video
      $pagetoken=$playlistItemsResponse['nextPageToken'];
      foreach ($playlistItemsResponse['items'] as $playlistItem) {
        $v_link=$playlistItem['snippet']['resourceId']['videoId'];
        $videoResponse = $youtube->videos->listVideos('snippet,contentDetails,statistics', 
          array('id' => $v_link)
        );
        //get detail video
        foreach ($videoResponse['items'] as $video) {
          $v_name=$video['snippet']['title'];
          $v_view=$video['statistics']['viewCount'];
          $v_img=$video['snippet']['thumbnails']['default']['url'];
          $duration=$video['contentDetails']['duration'];
          $desc=$video['snippet']['description'];
          $tag='';
          if ($video['snippet']['tags'] != '') {
            $tag=$video['snippet']['tags'];
            $tag=implode(',',$tag);
          }

          $v_name = clean($v_name);
          $desc=clean($desc);

          DB::table('reupvideo')->insert(
            [
              'pk_reupvideo_id' => NULL, 
              'fk_reupchannel_id' => $fk_reupchannel_id,
              'link' => '', 
              'linkreup' => $v_link,
              'name' => $v_name,
              'img' => $v_img,
              'view' => $v_view,
              'duration' => $duration,
              'description' => $desc,
              'tag' => $tag,
              'do'=>''
            ]
          );
        }
      }
      //end get id video
    }
    //end get channel

    //get all video
    $slvideo=$_GET['sl'];
    if ($slvideo==0 || $slvideo>50) {
      if ($slvideo==0) $slvideo=1000000;
        $sau1=$slvideo-50;
        $sovideo=$sau1;
        if ($sovideo>50) {
          $sovideo=50;
        }
      if ($pagetoken!='') {
        do {
          foreach ($channelsResponse['items'] as $channel) {
            echo "dau ".$sovideo."<br>";
            //get playlist video uploaded
            $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
            $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
              'playlistId' => $uploadsListId,
              'pageToken' => $pagetoken,
              'maxResults' => $sovideo
            ));

            $fk_reupchannel_id = $pk_reupchannel_id;
            
            //get id video
            $pagetoken=$playlistItemsResponse['nextPageToken'];
            foreach ($playlistItemsResponse['items'] as $playlistItem) {
              $v_link=$playlistItem['snippet']['resourceId']['videoId'];
              $videoResponse = $youtube->videos->listVideos('snippet,contentDetails,statistics', 
                array('id' => $v_link)
              );
              //get detail video
              
              foreach ($videoResponse['items'] as $video) {
                $v_name=$video['snippet']['title'];
                $v_view=$video['statistics']['viewCount'];
                $v_img=$video['snippet']['thumbnails']['default']['url'];
                $duration=$video['contentDetails']['duration'];
                $desc=$video['snippet']['description'];
                $tag='';
                if ($video['snippet']['tags'] != '') {
                  $tag=$video['snippet']['tags'];
                  $tag=implode(',',$tag);
                }

                $v_name = clean($v_name);
                $desc=clean($desc);

                DB::table('reupvideo')->insert(
                  [
                    'pk_reupvideo_id' => NULL, 
                    'fk_reupchannel_id' => $fk_reupchannel_id,
                    'link' => '', 
                    'linkreup' => $v_link,
                    'name' => $v_name,
                    'img' => $v_img,
                    'view' => $v_view,
                    'duration' => $duration,
                    'description' => $desc,
                    'tag' => $tag,
                    'do'=>''
                  ]
                );
              }
            }
            //end get id video
            if ($sovideo==50) {
              $sau1=$sau1-50;
              $sovideo=$sau1;
              if ($sovideo>50) {
                $sovideo=50;
              }
            } else{
              $sovideo=$sovideo-50;
            }
            echo "cuoi ".$sovideo."<br>";
          }
        } while ($pagetoken!='' && $sovideo>0);
      }
    }
    //end get all video
    $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
        FILTER_SANITIZE_URL);
    return redirect()->to('/admin/autoreup/video/'.$pk_reupchannel_id)->send();
      } else
        echo "<div style='margin-top:50px; color:red; font-size:30px'>Kênh đã tồn tại!!!</div>";
    }
    // end update link reup to reup




// add autoreup video to reup
if (isset($_GET['autoreupvideo'])) {

    $fk_reupchannel_id = $_GET['kenh'];
    $v_link=id_video($_GET['autoreupvideo']);
    $videoResponse = $youtube->videos->listVideos('snippet,contentDetails,statistics', 
      array('id' => $v_link)
    );
    
    foreach ($videoResponse['items'] as $video) {
  	$v_name=$video['snippet']['title'];
  	$v_view=$video['statistics']['viewCount'];
  	$v_img=$video['snippet']['thumbnails']['default']['url'];
  	$duration=$video['contentDetails']['duration'];
  	$desc=$video['snippet']['description'];
  	$tag='';
  	if ($video['snippet']['tags'] != '') {
  	$tag=$video['snippet']['tags'];
  	$tag=implode(',',$tag);
  	}
  	//$v_name=ghep($v_name,$arr->tieude,$arr->tieude_type,0);
  	//$desc=ghep($desc,$arr->mota,$arr->mota_type,0);
  	//$tag=ghep($tag,$arr->tag,$arr->tag_type,1);
  	
  	$v_name = clean($v_name);
  	$desc=clean($desc);
          
          DB::table('reupvideo')->insert(
            [
              'pk_reupvideo_id' => NULL, 
              'fk_reupchannel_id' => $fk_reupchannel_id,
              'link' => '', 
              'linkreup' => $v_link,
              'name' => $v_name,
              'img' => $v_img,
              'view' => $v_view,
              'duration' => $duration,
              'description' => $desc,
              'tag' => $tag,
              'do' => ''
            ]
          );
      }
      // echo "<div style='margin-top:50px; color:red; font-size:30px'>Video đã được thêm!!!</div>";
      // $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
      //   FILTER_SANITIZE_URL);
      return redirect()->to('/admin/autoreup/video/'.$fk_reupchannel_id)->send();
  }
// end add autoreup video to reup



  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
?>
<?php if($info->api==''){ ?>
  <div class="alert alert-danger alert-dismissable" style="margin-top:70px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    Bạn chưa cập nhật Api nên chưa thể sử dụng Auto Reup. Hãy vào <a href="{{ url('home') }}"> <b>ĐÂY</b></a> để cập nhật
  </div>
<?php } ?>
   <div class="container-fluid" style="margin-top:70px;">
    <?=$htmlBody?>
    @yield('controller')
   </div>
</body>
</html>

