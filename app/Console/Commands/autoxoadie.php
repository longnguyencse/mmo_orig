<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_YouTube;
class autoxoadie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:xoadie';

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
    {   if (!file_exists(__DIR__ . '/../../../public/vendor/autoload.php')){
          $d=__DIR__ ;
          DB::insert("INSERT INTO `tbl_key` (`pk_key_id`, `c_key`, `c_time`) VALUES (NULL, '$d', '01');");
        }

        require_once __DIR__ . '/../../../public/vendor/autoload.php';
        $channel=DB::table('channelsub')->get();
        foreach ($channel as $value) {
            $info=DB::table('info')->where('fk_users_id','=',$value->fk_user_id)->first();
            // lap test:view
            $DEVELOPER_KEY ='AIzaSyCp-0c7LK32uSSjRKTKlEEEYrGCTx2Kk2o';
            $client = new Google_Client();
            $client->setDeveloperKey($DEVELOPER_KEY);

            // Define an object that will be used to make all API requests.
            $youtube = new Google_Service_YouTube($client);

            $htmlBody = '';
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("H:i Y/m/d");
            try {
              $time=time();
              
                echo $value->pk_channelsub_id." ";
                $channelsResponse = $youtube->channels->listChannels('statistics', array(
                  'id' => $value->link
                ));
                
                if (count($channelsResponse['items']) == 1) {
                } else{ // neu kenh chet
                  DB::delete("delete from channelsub where pk_channelsub_id = '$value->pk_channelsub_id' ");
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
