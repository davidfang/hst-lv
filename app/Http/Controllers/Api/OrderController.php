<?php

namespace App\Http\Controllers\Api;

use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    /**
     * 订单信息
     */
    public function index(Request $request){
        $status = $request->get('status','1');
        $user = Auth::user();
//        var_dump($user->taobao_pid);
        $taobaoPid = explode('_',$user->taobao_pid);
        $where = [
            ['site_id',$taobaoPid[2]],['adzone_id',$taobaoPid[3]]
        ];
        if($status !=1){
            $where[] = ['tk_status',$status];
        }
        $order = Order::where($where)->orderByDesc('created_at')->paginate(20);
//        var_dump($order);exit;
        return $this->success(OrderResource::collection($order));
    }
}
