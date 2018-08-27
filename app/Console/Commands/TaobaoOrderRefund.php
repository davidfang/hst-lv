<?php

namespace App\Console\Commands;

use App\Helpers\AccountOperating;
use Illuminate\Console\Command;

class TaobaoOrderRefund extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:orderRefund';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '25号淘宝订单归整';

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
        $user_id = 20;
        AccountOperating::orderRefund($user_id);

    }
}
