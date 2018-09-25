<?php

namespace App\Http\Controllers\Api\Auth;

use App\Model\Account;
use App\User;
use App\Http\Controllers\Api\Controller;
use Carbon\Carbon;
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
            $user->ip = $request->ip();
            $user->save();
            $account = Account::initAcount($user->id);
            $this->guard('api')->login($user);

            return $this->fastLogin($request, $user);
        }

    }

}
