<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AccountOperating;
use App\Model\Account;
use App\Http\Resources\Account as AccountResource;
use App\Model\Bankcard;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use Validator;

class AccountController extends Controller
{
    /**
     * 获得帐户信息
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $account = Account::where('user_id', $userId)->first();
        return $this->success(new AccountResource($account));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Bankcard $bankcard
     * @return \Illuminate\Http\Response
     */
    public function show(Bankcard $bankcard)
    {
        //
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

    /**
     * 提现申请
     * @param Request $request
     *          amount 提现金额
     *          remark_submit 提现备注
     * @return mixed
     * @throws \Throwable
     */
    public function withdrawal(Request $request)
    {
        $user_id = $request->user()->id;
        $amount = $request->get('amount');
        $remark_submit = $request->get('remark_submit');
        $data = ['amount' => $amount, 'remark_submit' => $remark_submit];
        $validator = Validator::make($data, [
            'amount' => 'required|numeric|min:1|max:100',
            'remark_submit' => 'sometimes|max:25'
        ]);
        if ($validator->fails()) {
            //SmsManager::forgetState();
            return $this->setStatusCode(401)->failed($validator->errors());
        }

        $bankcard = Bankcard::where([['user_id', $user_id], ['channel', 'alipay'], ['status', '1']])->first();
        if ($bankcard) {
            $out_trade_no = '支付宝';
            $bankcard_id = $bankcard->id;
            $application = AccountOperating::withdrawalApplication($user_id, $amount, $remark_submit, $out_trade_no, $bankcard_id);
            if ($application) {
                return $this->message('提现申请成功');
            } else {
                return $this->failed('申请失败，请联系客服');
            }
        } else {
            return $this->failed('未绑定支付宝');
        }
    }
}
