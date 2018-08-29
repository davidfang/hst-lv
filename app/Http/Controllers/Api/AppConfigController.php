<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\Model\SystemSetting;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class AppConfigController extends Controller
{

    public function index(){
        $config = SystemSetting::where('status','1')->get();
        if($config){
            $config = $config->toArray();

            return $this->success(ArrayHelper::map($config,'key','val'));
        }else{
            return $this->success([]);
        }
    }
}
