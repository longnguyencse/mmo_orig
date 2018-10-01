<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_YouTube_ResourceId;
use Google_Service_YouTube;
use Google_Service_YouTube_SubscriptionSnippet;
use Google_Service_YouTube_Subscription;
class autosub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is auto sub';

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
        DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, 'test sub', '$date');");
        $channelautosub=DB::table('channelautosub')->where('status','=',0)->get(); //lấy danh sách kênh kéo sub
        foreach ($channelautosub as $channelautosub_rows) {
            // echo $channelautosub_rows->link." link ";
            $channelsub=DB::table('channelsub')->inRandomOrder()->get(); // lấy danh sách random kênh đi sub chéo
            foreach ($channelsub as $channelsub_rows) {

                $info=DB::table('info')->where('fk_users_id','=',$channelsub_rows->fk_user_id)->first(); // lấy clientID của từng kênh


                $OAUTH2_CLIENT_ID = $info->clientID;
                $OAUTH2_CLIENT_SECRET = $info->clientSecret;

                $client = new Google_Client();
                $client->setClientId($OAUTH2_CLIENT_ID);
                $client->setClientSecret($OAUTH2_CLIENT_SECRET);
                $client->setScopes('https://www.googleapis.com/auth/youtube');
                

                // // Define an object that will be used to make all API requests.
                $youtube = new Google_Service_YouTube($client);


                // echo $channelsub_rows->pk_channelsub_id." ";
                $refresh_token=$channelsub_rows->log;
                // echo $refresh_token." ";

                $client->refreshToken($refresh_token);
                $_SESSION['token'] = $client->getAccessToken();
                $access_token = $_SESSION['token']['access_token'];
                $client->setAccessToken($access_token);


                // Check to ensure that the access token was successfully acquired.
                if ($client->getAccessToken()) {
                  $htmlBody = '';
                  try {
                    // This code subscribes the authenticated user to the specified channel.

                    // Identify the resource being subscribed to by specifying its channel ID
                    // and kind.
                    $resourceId = new Google_Service_YouTube_ResourceId();
                    $resourceId->setChannelId($channelautosub_rows->link);
                    $resourceId->setKind('youtube#channel');

                    // Create a snippet object and set its resource ID.
                    $subscriptionSnippet = new Google_Service_YouTube_SubscriptionSnippet();
                    $subscriptionSnippet->setResourceId($resourceId);

                    // Create a subscription request that contains the snippet object.
                    $subscription = new Google_Service_YouTube_Subscription();
                    $subscription->setSnippet($subscriptionSnippet);

                    // Execute the request and return an object containing information
                    // about the new subscription.
                    $subscriptionResponse = $youtube->subscriptions->insert('id,snippet',
                        $subscription, array());
                    // echo "<pre>";
                    // print_r($subscriptionResponse);
                    // echo "</pre>";
                    // $htmlBody .= "<h3>Subscription</h3><ul>";
                    // $htmlBody .= sprintf('<li>%s (%s)</li>',
                    //     $subscriptionResponse['snippet']['title'],  
                    //     $subscriptionResponse['id']);
                    // $htmlBody .= '</ul>';

                  } catch (Google_Service_Exception $e) {
                    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                        htmlspecialchars($e->getMessage()));
                  } catch (Google_Exception $e) {
                    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                        htmlspecialchars($e->getMessage()));
                  }

                  // $_SESSION[$tokenSessionKey] = $client->getAccessToken();
                }


                $sub_after=$channelautosub_rows->sub_now+$channelautosub_rows->sub_tang;
                
                // sleep(2);
                $c_sub=0;
                $channelsResponse = $youtube->channels->listChannels('snippet,contentDetails,statistics', array(
                  'id' => $channelautosub_rows->link
                ));
                // get channel
                $c_sub=0;
                foreach ($channelsResponse['items'] as $channel) {
                    $c_sub=$channel['statistics']['subscriberCount'];
                    DB::table('channelautosub')->where('pk_channelautosub_id','=',$channelautosub_rows->pk_channelautosub_id)->update(array('sub_after'=>$c_sub));
                    
                }

                if ($c_sub>=$sub_after) {
                    DB::table('channelautosub')->where('pk_channelautosub_id','=',$channelautosub_rows->pk_channelautosub_id)->update(array('status'=>1));
                    // echo "string";
                    break;
                }

            }

        }

    }
}
