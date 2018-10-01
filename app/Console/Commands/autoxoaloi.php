<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class autoxoaloi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:xoaloi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto xoa loi';

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
        DB::table('reupchannel')
            ->update(['loi' => 0,'running'=>0]);
//        DB::table('reupvideo')->update(['running' => 0]);
    }
}
