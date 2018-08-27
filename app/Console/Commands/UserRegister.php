<?php

namespace App\Console\Commands;

use App\Helpers\AccountOperating;
use Illuminate\Console\Command;

class UserRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '推荐用户注册时对上级账户奖励操作';

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
        $userId = 20;
        $registerSon = AccountOperating::registerSon($userId);
        if($registerSon['parent']){
            echo '父账户操作完成';
        }
        if($registerSon['grandpa']){
            echo '爷账户操作完成';
        }
    }
}
