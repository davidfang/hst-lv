<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\Model\AppVersion;
use App\Model\SystemSetting;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class AppConfigController extends Controller
{
    /**
     * 系统设置
     * @return mixed
     */
    public function index(){
        $config = SystemSetting::where('status','1')->get();
        if($config){
            $config = $config->toArray();

            return $this->success(ArrayHelper::map($config,'key','val'));
        }else{
            return $this->success([]);
        }
    }

    /**
     * app版本升级
     * @param Request $request platform 平台； name app名称； version 当前版本
     * @return mixed
     */
    public function upgrade(Request $request){
        $platform = $request->get('platform');
        $appName = $request->get('name');
        $version = $request->get('version');
        $appVersion = AppVersion::where([['name',$appName],['platform',$platform],['status',1]])->first();
        if($appVersion){//有对应app
            if($version == $appVersion->version){
                return $this->message('无需升级');
            }else{
                return $this->success($appVersion);
            }
        }else{//无对应app
            return $this->failed('错误请求');
        }
    }
}
