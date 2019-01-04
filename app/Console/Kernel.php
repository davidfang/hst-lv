<?php

namespace App\Console;

use App\Console\Commands\HuashengCategorySpider;
use App\Console\Commands\HuashengGoodsSpider;
use App\Console\Commands\TaobaoDeleteExit;
use App\Console\Commands\TaobaoFavourite;
use App\Console\Commands\TaobaoGoodCategorySpider;
use App\Console\Commands\HuashenIndexSpider;
use App\Console\Commands\TaobaoGoodsSpiderByIds;
use App\Console\Commands\TaobaoOrder;
use App\Console\Commands\TaobaoOrderRefund;
use App\Console\Commands\TaobaoRebateOrder;
use App\Console\Commands\TaobaoUpdateGoods;
use App\Console\Commands\UserRegister;
use App\Console\Commands\UserWithdraw;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        TaobaoDeleteExit::class,
        TaobaoFavourite::class,
        TaobaoUpdateGoods::class,
        TaobaoOrder::class,
        TaobaoOrderRefund::class,
        TaobaoRebateOrder::class,
        TaobaoGoodCategorySpider::class,
        TaobaoGoodsSpiderByIds::class,
        HuashenIndexSpider::class,
        HuashengCategorySpider::class,
        HuashengGoodsSpider::class,
        UserWithdraw::class,
        UserRegister::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
