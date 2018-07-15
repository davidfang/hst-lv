<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('auth:api')->only('logout');
    }
    // 登录
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'email'    => 'required|exists:users',
            'email'    => 'required',
            'password' => 'required|between:5,32',
        ]);

        if ($validator->fails()) {
            $request->request->add([
                'errors' => $validator->errors()->toArray(),
                'code' => 401,
            ]);
            return $this->sendFailedLoginResponse($request);
        }

        $credentials = $this->credentials($request);
        if ($this->guard('api')->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }


        return $this->setStatusCode(401)->failed('登录失败');
    }

    // 退出登录
    public function logout(Request $request)
    {

        if (Auth::guard('api')->check()){

            Auth::guard('api')->user()->token()->revoke();

        }

        return $this->message('退出登录成功');

    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return $this->authenticateClient($request);
    }
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $authenticated = $this->authenticated($request,$this->guard()->user());
        return $this->success(json_decode($authenticated,true));
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $msg = $request['errors'];
        $code = $request['code'];
        return $this->setStatusCode($code)->failed($msg);
    }
}
