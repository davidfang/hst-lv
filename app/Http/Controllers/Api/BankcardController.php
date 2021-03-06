<?php

namespace App\Http\Controllers\Api;

use App\Model\Bankcard;
use App\Http\Resources\Bankcard as BankcardResource;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use Auth;
use Validator;

class BankcardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only(['bank_card_no','name', 'verifyCode']);
        $validator = Validator::make($data, [
            'bank_card_no' => 'required|max:20,min:5',
            'name' =>'required|max:10,min:2',
            'verifyCode' => 'required|verify_code'
        ], [
            'verifyCode.verify_code' => '验证码不正确'
        ]);
        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        unset($data['verifyCode']);

        $bankcard = Bankcard::updateOrCreate([
            'user_id'=>Auth::id(),
            'channel'=>'alipay'
        ],$data);
        $this->message('操作成功');
        return $this->success($bankcard);
    }
    /**
     * 绑定支付宝2  重点是添加了手机号
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create2(Request $request)
    {

        $data = $request->only(['bank_card_no','mobile','name', 'verifyCode']);
        $validator = Validator::make($data, [
            'bank_card_no' => 'required|max:20,min:5',
            'mobile' => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'name' =>'required|max:10,min:2',
            'verifyCode' => 'required|verify_code'
        ], [
            'mobile.confirm_rule' => '确认手机号输入是否有误',
            'mobile.confirm_mobile_not_change' => '手机号或验证不正确',
            'verifyCode.verify_code' => '验证码不正确'
        ]);
        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        unset($data['verifyCode']);
        $data['created_at']=now();
        $data['updated_at']=now();
        $bankcard = Bankcard::updateOrCreate([
            'user_id'=>Auth::id(),
            'channel'=>'alipay'
        ],$data);
        $user = Auth::user();
        $user->mobile = $data['mobile'];
        $user->name = $data['name'];
        $user->save();

        $this->message('操作成功');
        return $this->success($bankcard);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Bankcard $bankcard
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //Bankcard $bankcard
        $userId = Auth::id();
        $bankcard = Bankcard::where('user_id', $userId)->first();
        if($bankcard){
            return $this->success(new BankcardResource($bankcard));
        }else {
            return $this->success($bankcard);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Bankcard $bankcard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bankcard $bankcard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Bankcard $bankcard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bankcard $bankcard)
    {
        //
    }
}
