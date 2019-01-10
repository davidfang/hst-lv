<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Model\ThirdLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Validator;
use App\Model\Account;

class ThirdLoginController extends Controller
{
    /**
     * 第三方登录并绑定
     * @param  \Illuminate\Http\Request  $request
     */
    public function loginAndBind(Request $request){
        $data = $request->only(['uid', 'platform', 'screen_name', 'iconurl', 'accessToken', 'refreshToken', 'gender', 'unionid', 'openid', 'expires_in','other']);
        //1校验
        $validator = $this->validator($data);

        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        if ($thirdLoginLog = ThirdLogin::where([['uid', $request['uid']], ['platform', $request['platform']]])->first()) {//是否有第三方登录信息
            //die('d');
            if ($thirdLoginLog->userId != null) {//已绑定 3 登录
                $user = $thirdLoginLog->userInfo;
                //var_dump($user);die();
                $data['userId'] = $user->id;
                $thirdLogin = ThirdLogin::create($data);
                //客户端授权登录
                $authenticated = $this->authenticateClientByThirdLogin($request,$user);
                $user->last_login_ip = $request->ip();
                $user->last_login_time = Carbon::now()->toDateTimeString();
                $user->save();
                return $this->success(['bind'=>true,'loginInfo'=>$authenticated]);
            } else {//未绑定 要求绑定
                $user = User::thirdCreate($request->ip(),$data['uid'],$data['iconurl'],$data['screen_name'],$data['gender']);
                $data['userId'] = $user->id;



                $thirdLogin = ThirdLogin::create($data);
                //客户端授权登录
                $authenticated = $this->authenticateClientByThirdLogin($request,$user);
                return $this->success(['bind'=>true,'loginInfo'=>$authenticated]);
            }
        } else {//无第三方登录信息 2 注册 绑定
            //die('c');
            $user = User::thirdCreate($request->ip(),$data['uid'],$data['iconurl'],$data['screen_name'],$data['gender']);
            $data['userId'] = $user->id;



            $thirdLogin = ThirdLogin::create($data);
            //var_dump($user);
            //die('u');
            //客户端授权登录
            $authenticated = $this->authenticateClientByThirdLogin($request,$user);
            return $this->success(['bind'=>true,'loginInfo'=>$authenticated]);
        }
    }
    /**
     * 第三方登录
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $data = $request->only(['uid', 'platform', 'screen_name', 'iconurl', 'accessToken', 'refreshToken', 'gender', 'unionid', 'openid', 'expires_in','other']);
        //1校验
        $validator = $this->validator($data);


        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        if ($thirdLoginLog = ThirdLogin::where([['uid', $request['uid']], ['platform', $request['platform']]])->first()) {//是否有第三方登录信息
            if ($thirdLoginLog->userId != null) {//已绑定 3 登录
                $user = $thirdLoginLog->userInfo;
                $data['userId'] = $user->id;
                $thirdLogin = ThirdLogin::create($data);
                //客户端授权登录
                $authenticated = $this->authenticateClient($request,$user);
                $user->last_login_ip = $request->ip();
                $user->last_login_time = Carbon::now()->toDateTimeString();
                $user->save();
                return $this->success(['bind'=>true,'loginInfo'=>$authenticated]);
            } else {//未绑定 要求绑定
                $thirdLogin = ThirdLogin::create($data);
                return $this->success(['bind'=>false,'thirdLoginId'=>$thirdLogin->id,'uid'=>$thirdLogin->uid,'platform'=>$thirdLogin->platform]);
            }

        } else {//无第三方登录信息 2 注册 绑定
            $thirdLogin = ThirdLogin::create($data);
            return $this->success(['bind'=>false,'thirdLoginId'=>$thirdLogin->id,'uid'=>$thirdLogin->uid,'platform'=>$thirdLogin->platform]);
        }
        /**
         * 已经有三方登录信息，取出对应的userId，用户信息，直接登录
         *                  无对应的userId,要求绑定信息，注册手机号，验证码，下一步，密码或不用密码
         * 无三方登录信息 要求绑定信息
         *
         * 绑定信息完成 看是否要密码
         *
         *
         *
         */


    }

    /**
     * 绑定用户
     * @param Request $request
     * @return mixed
     */
    public function bind(Request $request){
        $data = $request->only(['thirdLoginId','uid','platform','mobile','verifyCode','invitation_code']);
        $validator = Validator::make($data,[
            'thirdLoginId'=>'required|exists:third_login,id',
            'uid'=>'required|exists:third_login,uid',
            'platform'=>'required|exists:third_login,platform',
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code',
            'invitation_code'     => 'exists:users,invitation_code'
        ],[
            'thirdLoginId'=>'三方ID不存在',
            'uid'=>'三方ID不正确',
            'platform'=>'三方平台不存在',
            'invitation_code.exists'     => '邀请码不正确',
            'verifyCode.verify_code' => '验证码不正确',
            'mobile.confirm_rule' => '确认手机号输入是否有误',
            'mobile.confirm_mobile_not_change' => '手机号或验证不正确'
        ]);
        if($validator->fails()){
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        if($user = User::where('mobile',$data['mobile'])->first()){//已经有用户，直接绑定
            ThirdLogin::where('uid',$data['uid'])
                //->where('id',$data['thirdLoginId'])
                ->where('platform',$data['platform'])
                ->update(['userId'=>$user->id]);
            $genders = ['男'=>'1','女'=>'2','未设置'=>'0'];
            $thirdLoginInfo = ThirdLogin::find($data['thirdLoginId']);
            $user->third_id = $thirdLoginInfo->uid;
            $user->avatar = $thirdLoginInfo->iconurl;
            $user->nickname = $thirdLoginInfo->screen_name;
            $user->gender = $genders[$thirdLoginInfo->gender];
            $user->save();
            return $this->fastLogin($request, $user);
        }else{//无用户注册
            $user = User::createNew($request->ip(),$request->get('mobile'),$request->get('password'),$request->get('invitation_code'));
//            $user = $this->create($data);
//            $user->invitation_code = createInvitationCode($user->id);
            $user->third_id = $data['uid'];
            $user->save();
//            $account = Account::initAcount($user->id);
            $this->guard('api')->login($user);
            return $this->fastLogin($request, $user);
        }
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (isset($data['invitation_code'])) {
            $parent_id = decodeInvitationCode($data['invitation_code']);
            $parent = User::find($parent_id);
            if ($parent->grade == '2') {//运营商
                $data['grandpa_id'] = $data['operator_id'] = $parent->id;
            } else {
                $data['grandpa_id'] = $parent->parent_id;
                $data['operator_id'] = $parent->operator_id;
            }
        } else {
            $data['grandpa_id'] = $data['operator_id'] = $parent_id = null;
        }
        return User::create([
            'parent_id' => $parent_id,
            'grandpa_id' => $data['grandpa_id'],
            'operator_id' => $data['operator_id'],
            'mobile' => $data['mobile'],
            'password' => isset($data['passord'])? Hash::make($data['password']):'1'
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $return = Validator::make($data, [
            //'invitation_code' => 'exists:users,invitation_code',
            'uid' => 'required',
            'platform' => 'required',
            'screen_name' => 'required',
            'iconurl' => 'required',
            'accessToken' => 'required',
            'refreshToken' => 'required',
            'gender' => 'required',
            'unionid' => 'required',
            'openid' => 'required',
            //'expires_in' => 'required',
            'other' => 'json'
        ], [
            'invitation_code.exists' => '邀请码不正确'
        ]);
        return $return;
    }
}
