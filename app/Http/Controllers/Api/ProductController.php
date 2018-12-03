<?php

namespace App\Http\Controllers\Api;

use App\Common\TaoBao;
use App\Model\BuyLog;
use App\Model\Product;
use App\Http\Resources\Product as ProductResource;
use App\Model\Tpwd;
use App\Model\DgSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;

//use App\Http\Controllers\Controller;
require_once __DIR__ . "/../../../Helpers/simple_html_dom.php";

class ProductController extends Controller
{
    /**
     * 首页推荐
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$goods = Product::where([['status',1],['my_category_id',env('INDEX_RECOMMENT_CATEGORY_ID',0)]])->paginate(20);
        $goods = Product::getModel()->orderByDesc('commission_rate')->paginate(20);
        //return $this->success(ProductResource::collection($goods));
        return $this->success(ProductResource::collection($goods)->resource);
        //
    }

    /**
     * 分类产品列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request)
    {
        $categoryId = $request->get('categoryId');
        $goods = Product::where([['my_category_id', $categoryId]])->simplePaginate(20);
        return $this->success(ProductResource::collection($goods));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Model\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->success(new ProductResource($product));
    }

    /**
     * 设置产品详情
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function setDetail(Request $request)
    {
        $ip = $request->getClientIp();
        // $ip = $request->get('ip');
        $num_iid = $request->get('num_iid');
        $detail = json_encode($request->get('detail'));
        //$detail = $request->get('detail');

        //var_dump($detail);exit;
        $goods = Product::where('num_iid', $num_iid)->first();
        $goods->detail = $detail;
        $goods->save();
        return $this->message('ok');

        $key = 'detail_' . $num_iid;
        //
        if (Cache::has($key)) {

            $cache = cache($key);
            if (count($cache) > 2) {//3次以上时，判断是否相同
                //echo '3次以上时';
                $countValue = array_count_values($cache);
                if (count($countValue) > 1) {//有不同的数据出现
                    //echo '有不同的数据出现';
                    if (in_array($detail, $cache)) {//在里面时，放进去
                        $cache[$ip] = $detail;
                        cache([$key => $cache], now()->addHours(4));
                        //echo '在里面时，放进去';
                    } else {//不在里面时，不放进去
                        //echo '不在里面时，不放进去';
                    }
                    if (in_array(4, $countValue)) {//有第四次出现的，存入数据，删除缓存
                        foreach ($countValue as $k => $v) {
                            if ($v == 4) {
                                $detail = $k;
                            }
                        }
                        //存入数据 Todo
                        $goods = Product::where('num_iid', $num_iid)->first();
                        $goods->detail = $detail;
                        $goods->save();
                        Cache::forget($key);
                        //echo '有第四次出现的，存入数据，删除缓存';
                    }
                } else {//没有不同数据
                    //echo '没有不同数据';
                    if (isset($countValue[$detail])) {//此次数据和前3次一样 存入数据 删除缓存
                        //存入数据 Todo
                        $goods = Product::where('num_iid', $num_iid)->first();
                        $goods->detail = $detail;
                        $goods->save();
                        Cache::forget($key);
                        echo '此次数据和前3次一样 存入数据 删除缓存';
                    }//否则不操作
                }
                //var_dump($countValue);

            } else {//3次以下时，继续加
                //echo '3次以下时，继续加';
                $cache[$ip] = $detail;

                cache([$key => $cache], now()->addHours(4));
            }

        } else {
            //echo '没有数据，第一次来';
            $cache = [$ip => $detail];
            cache([$key => $cache], now()->addHours(4));
        }
        //var_dump($cache);
        return $this->message('ok');
    }

    /**
     * 设置产品详情 新
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function setDetail2(Request $request)
    {
        $ip = $request->getClientIp();
        // $ip = $request->get('ip');
        $num_iid = $request->get('num_iid');
        //$detail = json_encode($request->get('detail'));
        $detail = $request->get('detail');

        $html = str_get_html($detail['pcDescContent']);
        $imgs = $html->find('img');
        $images = [];
        foreach ($imgs as $image) {
            $images[] = 'https:' . $image->src;
        }
        $html->clear();
        //var_dump($images);exit;
        //var_dump($request->get('detail'));exit;
        //var_dump($detail['pcDescContent']);exit;
        //var_dump($detail->pcDescContent);exit;
        $goods = Product::where('num_iid', $num_iid)->first();
        if ($goods) {
            $goods->detail = json_encode($images);
            $goods->save();
        }
        if (!empty($images)) {
            return $this->success($images);
        } else {
            return $this->failed('没有详情');
        }
        //return $this->message('ok');

        $key = 'detail_' . $num_iid;
        //暂时不用，使用需要修改
        if (Cache::has($key)) {

            $cache = cache($key);
            if (count($cache) > 2) {//3次以上时，判断是否相同
                //echo '3次以上时';
                $countValue = array_count_values($cache);
                if (count($countValue) > 1) {//有不同的数据出现
                    //echo '有不同的数据出现';
                    if (in_array($detail, $cache)) {//在里面时，放进去
                        $cache[$ip] = $detail;
                        cache([$key => $cache], now()->addHours(4));
                        //echo '在里面时，放进去';
                    } else {//不在里面时，不放进去
                        //echo '不在里面时，不放进去';
                    }
                    if (in_array(4, $countValue)) {//有第四次出现的，存入数据，删除缓存
                        foreach ($countValue as $k => $v) {
                            if ($v == 4) {
                                $detail = $k;
                            }
                        }
                        //存入数据 Todo
                        $goods = Product::where('num_iid', $num_iid)->first();
                        $goods->detail = $detail;
                        $goods->save();
                        Cache::forget($key);
                        //echo '有第四次出现的，存入数据，删除缓存';
                    }
                } else {//没有不同数据
                    //echo '没有不同数据';
                    if (isset($countValue[$detail])) {//此次数据和前3次一样 存入数据 删除缓存
                        //存入数据 Todo
                        $goods = Product::where('num_iid', $num_iid)->first();
                        $goods->detail = $detail;
                        $goods->save();
                        Cache::forget($key);
                        echo '此次数据和前3次一样 存入数据 删除缓存';
                    }//否则不操作
                }
                //var_dump($countValue);

            } else {//3次以下时，继续加
                //echo '3次以下时，继续加';
                $cache[$ip] = $detail;

                cache([$key => $cache], now()->addHours(4));
            }

        } else {
            //echo '没有数据，第一次来';
            $cache = [$ip => $detail];
            cache([$key => $cache], now()->addHours(4));
        }
        //var_dump($cache);
        return $this->message('ok');
    }

    /**
     * 获取淘口令
     * @param $goodsId
     * @return mixed
     */
    public function getTpwd($goodsId)
    {
        $goods = Product::find($goodsId);
        if (empty($goods)) {
            $goods = DgSearch::find($goodsId);
        }
        if ($goods) {//查到产品

            if (Auth::check()) {//是否登录
                $user = Auth::user();
                //var_dump($user->taobao_pid);
                $pid = $user->taobao_pid;
                $userId = $user->id;
                if (is_null($pid)) {//没有PID的用户使用默认的
                    $taobao = new TaoBao();
                } else {//有PID的用户使用自己的
                    $ad_zone_id = (explode('_', $pid))[3];
                    $taobao = new TaoBao($pid, $ad_zone_id);
                }

            } else {
                $userId = 29;//默认29号用户
                $taobao = new TaoBao();


            }
            $tpwd = Tpwd::where([['userId', $userId], ['num_iid', $goodsId]])->first();
            if ($tpwd) {//已经建立过淘口令
                $model = $tpwd->tpwd;
                Tpwd::where([['userId', $userId], ['num_iid', $goodsId]])->increment('click');//点击数递增

            } else {//没建立过淘口令
                $model = $taobao->tpwd($goods->title, $goods->coupon_share_url, $goods->pict_url, '{}');
                $tpwd = new Tpwd();
                $tpwd->userId = $userId;
                $tpwd->num_iid = $goodsId;
                $tpwd->tpwd = $model;
                $tpwd->title = $goods->title;
                $tpwd->pict_url = $goods->pict_url;
                $tpwd->zk_final_price = $goods->zk_final_price;
                $tpwd->real_price = $goods->real_price;
                $tpwd->coupon_info_price = $goods->coupon_info_price;
                $tpwd->commission_rate = $goods->commission_rate;
                $tpwd->commission_amount = $goods->commission_amount;
                $tpwd->click = 1;
                $tpwd->buy = 0;
                $tpwd->save();
            }
            /***设置分享页面 二维码 开始***/
            $pic1 = '/image/' . str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($tpwd->pict_url . '_600x600.jpg')) . '/dissolve/100/gravity/North/dx/0/dy/190';
            $title1 = '/text/' . str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode(mb_substr($tpwd->title, 0, 22))) . '/font/5b6u6L2v6ZuF6buR/fontsize/500/fill/IzAwMDAwMA==/dissolve/100/gravity/NorthWest/dx/117/dy/84';
            $title2 = '/text/' . str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode(mb_substr($tpwd->title, 22))) . '/font/5b6u6L2v6ZuF6buR/fontsize/500/fill/IzAwMDAwMA==/dissolve/100/gravity/NorthWest/dx/51/dy/134';
            $realPrice = '/text/' . str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($tpwd->real_price)) . '/font/5b6u6L2v6ZuF6buR/fontsize/960/fill/I0QwMDIxQg==/dissolve/100/gravity/NorthWest/dx/96/dy/835';
            $oldPrice = '/text/' . str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($tpwd->zk_final_price)) . '/font/5b6u6L2v6ZuF6buR/fontsize/720/fill/IzlCOUI5Qg==/dissolve/100/gravity/NorthWest/dx/96/dy/905';
            $coupon = '/text/' . str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($tpwd->coupon_info_price)) . '/font/5b6u6L2v6ZuF6buR/fontsize/1100/fill/I0ZGRkZGRg==/dissolve/100/gravity/NorthWest/dx/510/dy/842';

            //$shareUrlQrcode = 'http://mobile.qq.com/qrcode?url='.urlencode(env('PRODUCT_SHARE_URL').'?tpwd='.$model);//分享地址二维码
            $shareUrlQrcode = 'http://mobile.qq.com/qrcode?url=' . env('PRODUCT_SHARE_URL') . '?tpwd=' . urlencode($model);//分享地址二维码
            $shareUrl = '/image/' . base64_encode($shareUrlQrcode) . '/dissolve/100/gravity/SouthEast/dx/60/dy/80';

            if ($tpwd->user_type == 0) {
                $share_pict_url = env('QINIU_SHARE_PICT_TEMPLATE_URL_TB') . $pic1 . $title1 . $title2 . $realPrice . $oldPrice . $coupon . $shareUrl;
            } else {
                $share_pict_url = env('QINIU_SHARE_PICT_TEMPLATE_URL_TM') . $pic1 . $title1 . $title2 . $realPrice . $oldPrice . $coupon . $shareUrl;
            }


            /***设置分享页面 二维码 结束***/


            return $this->success(['tpwd' => $model, 'share_pict_url' => $share_pict_url
            ]);
        } else {//未查到产品
            return $this->failed('非法请求');
        }
    }

    /**
     * 通过淘口令获得产品信息
     * @param $tpwd
     * @return mixed
     */
    public function infoByTpwd(Request $request)
    {
        $tpwd = $request->get('tpwd');
        $tpwd = str_replace('ï¿¥', '￥', $tpwd);//腾讯的二维码有问题，人民币符号无法处理
        $tpwd = Tpwd::where([['tpwd', $tpwd]])->first(['tpwd', 'num_iid', 'title', 'pict_url', 'zk_final_price', 'real_price', 'coupon_info_price']);
        if ($tpwd) {
            return $this->success($tpwd);
        } else {
            return $this->failed('非法请求');
        }
    }

    /**
     * 记录购买行为
     * @param $goodsId
     * @return mixed
     */
    public function buy($goodsId)
    {
        $goods = Product::find($goodsId);
        if (empty($goods)) {
            $goods = DgSearch::find($goodsId);
        }
        if ($goods) {//查到产品

            if (Auth::check()) {//是否登录
                $user = Auth::user();
                //var_dump($user->taobao_pid);
                $pid = $user->taobao_pid;
                $userId = $user->id;


            } else {
                $userId = '';//默认29号用户


            }

            $buyLog = new BuyLog();
            $buyLog->userId = $userId;
            $buyLog->num_iid = $goodsId;
            $buyLog->ip = (new Request())->ip();
            $buyLog->title = $goods->title;
            $buyLog->pict_url = $goods->pict_url;
            $buyLog->price = $goods->zk_final_price;
            $buyLog->coupon_info_price = $goods->coupon_info_price;
            $buyLog->commission_rate = $goods->commission_rate;
            $buyLog->commission_amount = $goods->commission_amount;
            $buyLog->save();

            return $this->message('购买成功');
        } else {//未查到产品
            return $this->failed('非法请求');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product $goods
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $goods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Product $goods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $goods)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product $goods
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $goods)
    {
        //
    }

    /**
     * 淘口令购买提交
     * @param Request $request
     * @return mixed
     */
    public function tpwdBuy(Request $request)
    {
        $tpwd = $request->get('tpwd');
        //todo 淘口令创建时建立用户和产品关联
        //todo 对淘口令 访问+1
        Tpwd::where(['tpwd', $tpwd])->increment('buy');
        return $this->message('收到');
    }
}
