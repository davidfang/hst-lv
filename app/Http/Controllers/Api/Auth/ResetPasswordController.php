<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('reset');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function change(Request $request)
    {
        $data = $this->credentials($request);
        $validator = Validator::make($data, [
            'mobile' => 'required|zh_mobile',
            'password' => 'required|min:6|max:20',
        ], [
            'mobile.required' => '手机号不能为空',
            'mobile.zh_mobile' => '手机号格式不正确'
        ]);
        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        $user = $this->guard()->user();//echo '<pre>';var_dump($user);
        if ($user->mobile == $request['mobile']) {
            $this->resetPassword($user, $request['password']);
            return $this->message('修改成功');
        } else {
            return $this->failed('无权操作,请填写注册时手机', 401);
        }
    }
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function set(Request $request)
    {
        $data = $request->only(
            'mobile', 'password','invitation_code'
        );;
        $validator = Validator::make($data, [
            'invitation_code' => 'exists:users,invitation_code',
            'mobile' => 'required|zh_mobile',
            'password' => 'required|min:6|max:20',
        ], [
            'invitation_code.exists' => '邀请码不正确',
            'verifyCode.verify_code' => '验证码不正确',
            'mobile.required' => '手机号不能为空',
            'mobile.zh_mobile' => '手机号格式不正确'
        ]);
        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        $user = $this->guard()->user();
        if ($user->mobile == $data['mobile']) {
            $user->password = Hash::make($data['password']);


            if (isset($data['invitation_code'])) {//有邀请码
                $parent_id = decodeInvitationCode($data['invitation_code']);
                $parent = User::find($parent_id);
                if ($parent->grade == '2') {//运营商
                    $user->grandpa_id = $parent->id;
                    $user->operator_id = $parent->id;
                } else {
                    $user->grandpa_id = $parent->parent_id;
                    $user->operator_id = $parent->operator_id;
                }
                $user->parent_id = $parent->id;
            } else {//无邀请码
                //$data['grandpa_id'] = $data['operator_id'] = $parent_id = null;
            }

            $user->save();
            return $this->message('修改成功');
        } else {
            return $this->failed('无权操作,请填写注册时手机', 401);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        //$this->guard()->login($user);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'mobile', 'password'
        );
    }
}
