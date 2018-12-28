<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TaobaoDeleteExit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:deleteExit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除优惠券过期产品';

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
        $this->info('--------'.date('Y-m-d H:i:s').'--------');
        $couponRows = DB::delete('delete from product where coupon_end_time < now();');
        $this->info("优惠券过期删除了 $couponRows 行");
        $exitRows = DB::delete('delete from product where  created_at < date_sub(now(),interval 4 day);');
        $this->info("4天前的删除了 $exitRows 行");

    }
}
