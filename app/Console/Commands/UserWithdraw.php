<?php

namespace App\Console\Commands;

use App\Helpers\AccountOperating;
use App\Model\WithdrawalApplication;
use Illuminate\Console\Command;

class UserWithdraw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:withdraw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用户提现';

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
        $withdrawalApplication_id = 2;
        $remark_audit = '同意提现';
        $withdraw = AccountOperating::withdraw($withdrawalApplication_id,$remark_audit);
//        $withdrawalApplication = WithdrawalApplication::find($withdrawalApplication_id);
//        echo $withdrawalApplication->status;
//        echo (json_encode($withdrawalApplication->toArray()));
        if($withdraw){
            echo ('提现成功');
        }else{
            echo ('提现失败');
        }
    }
}
