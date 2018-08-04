<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Controllers\Api\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use SmsManager;
use Validator;

class FastLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $return =  Validator::make($data, [
            'invitation_code'     => 'exists:users,invitation_code',
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code'
        ],[
            'invitation_code.exists'     => '邀请码不正确',
            'verifyCode.verify_code' => '验证码不正确',
            'mobile.confirm_rule' => '确认手机号输入是否有误',
            'mobile.confirm_mobile_not_change' => '手机号或验证不正确'
        ]);
        return $return ;
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['invitation_code'] = isset($data['invitation_code'])?$data['invitation_code']:null;
        return User::create([
            'parent_id' => decodeInvitationCode($data['invitation_code']),
            'mobile' => $data['mobile'],
            'password' => '1'
        ]);
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //
        $validator = $this->validator($request->all());


        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        if($user = User::where('mobile',$request['mobile'])->first()){//登录
//            $token = $user->createToken('ios')->accessToken;
//            return $this->success(['token'=>$token,'password'=>false]);

            return $this->fastLogin($request, $user);
        }else{//注册
            $user = $this->create($request->all());
            $user->invitation_code = createInvitationCode($user->id);
            $user->save();
            $this->guard('api')->login($user);

            return $this->fastLogin($request, $user);
        }

    }
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function fastLogin(Request $request, $user)
    {
//        $token = $user->createToken('ios')->accessToken;
//        return $this->success(['token'=>$token,'password'=>true]);
        $authenticated = $this->authenticateClient($request,$user);
        return $this->success($authenticated);
    }
}
