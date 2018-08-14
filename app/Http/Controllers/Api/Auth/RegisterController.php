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

class RegisterController extends Controller
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
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required|unique:users',
            'verifyCode' => 'required|verify_code',
            'password' => 'required|min:6'
        ],[
            'invitation_code.exists'     => '邀请码不正确',
            'verifyCode.verify_code' => '验证码不正确',
            'mobile.confirm_rule' => '确认手机号输入是否有误',
            'mobile.confirm_mobile_not_change' => '手机号或验证不正确',
            'mobile.unique' => '手机号码已注册',
            'password.required' => '密码不能为空',
            'password.min' => '密码不能小于6位',
        ]);
        return $return ;
    }
    /**
     * @api {post} /sendCode 获取手机验证码
     * @apiDescription 获取手机的验证码，以便用于注册，验证等操作
     * @apiGroup Auth
     * @apiParam {String} mobile 用户用于获取验证码的手机号
     * @apiVersion 0.0.0
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "验证码发送成功"
     *        }
     * @apiErrorExample {json} Error-Response:
     *     {
     *          "status": "error",
     *          "code": 400,
     *          "error": {
     *              "message": "请求错误,请确认手机号是否有误"
     *          }
     *      }
     *
     */
    public function sendCheckCode(Request $request)
    {
        // 添加用户请求的标识
//        $request->request->add([
//            'access_token' => $request->mobile
//        ]);
        $validate = SmsManager::validateFields();
        if ($validate["success"] == false){
            return $this->failed("请求错误,请确认手机号是否有误",400);
        }
        $result = SmsManager::requestVerifySms();
        if ($result["success"] == true){
            return $this->success("验证码发送成功");
        }
        return $this->internalError('验证码发送失败,请重试');
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
            'password' => Hash::make($data['password']),
        ]);
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //
        $validator = $this->validator($request->all());


        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        //event(new Registered($user = $this->create($request->all())));
        $user = $this->create($request->all());
        $user->invitation_code = createInvitationCode($user->id);
        $user->ip = $request->ip();
        $user->save();
        $this->guard('api')->login($user);

        return $this->registered($request, $user);
    }
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
//        $token = $user->createToken('ios')->accessToken;
//        return $this->success(['token'=>$token,'password'=>true]);

        $authenticated = $this->authenticateClient($request,$user);
        return $this->success($authenticated);
    }
}
