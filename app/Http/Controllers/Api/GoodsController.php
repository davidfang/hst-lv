<?php

namespace App\Http\Controllers\Api;

use App\Common\TaoBao;
use App\Model\Article;
use App\Model\Goods;
use App\Http\Resources\Goods as GoodsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
//use App\Http\Controllers\Controller;
require_once __DIR__."/../../../Helpers/simple_html_dom.php";

class GoodsController extends Controller
{
    /**
     * 首页推荐
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goods = Goods::where([['status',1],['category_id',env('INDEX_RECOMMENT_CATEGORY_ID',0)]])->paginate(20);
        //return $this->success(GoodsResource::collection($goods));
        return $this->success(GoodsResource::collection($goods)->resource);
        //
    }

    /**
     * 分类产品列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request){
        $categoryId = $request->get('categoryId');
        $goods = Goods::where([['status',1],['category_id',$categoryId]])->simplePaginate(20);
        return $this->success(GoodsResource::collection($goods));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Goods  $goods
     * @return \Illuminate\Http\Response
     */
    public function show(Goods $goods)
    {
        return $this->success(new GoodsResource($goods));
    }

    /**
     * 设置产品详情
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function setDetail(Request $request){
        $ip = $request->getClientIp();
        // $ip = $request->get('ip');
        $num_iid = $request->get('num_iid');
        $detail = json_encode($request->get('detail'));
        //$detail = $request->get('detail');

        //var_dump($detail);exit;
        $goods = Goods::where('num_iid',$num_iid)->first();
        $goods->detail = $detail;
        $goods->save();
        return $this->message('ok');

        $key = 'detail_'.$num_iid;
        //
        if(Cache::has($key)){

            $cache = cache($key);
            if(count($cache)>2) {//3次以上时，判断是否相同
                //echo '3次以上时';
                $countValue = array_count_values($cache);
                if(count($countValue)>1){//有不同的数据出现
                    //echo '有不同的数据出现';
                  if(in_array($detail,$cache)){//在里面时，放进去
                      $cache[$ip] = $detail;
                      cache([$key => $cache], now()->addHours(4));
                      //echo '在里面时，放进去';
                  }else{//不在里面时，不放进去
                      //echo '不在里面时，不放进去';
                  }
                  if(in_array(4,$countValue)){//有第四次出现的，存入数据，删除缓存
                      foreach ($countValue as $k =>$v){
                          if($v == 4){
                              $detail = $k;
                          }
                      }
                      //存入数据 Todo
                      $goods = Goods::where('num_iid',$num_iid)->first();
                      $goods->detail = $detail;
                      $goods->save();
                      Cache::forget($key);
                      //echo '有第四次出现的，存入数据，删除缓存';
                  }
                }else{//没有不同数据
                    //echo '没有不同数据';
                    if(isset($countValue[$detail])){//此次数据和前3次一样 存入数据 删除缓存
                        //存入数据 Todo
                        $goods = Goods::where('num_iid',$num_iid)->first();
                        $goods->detail = $detail;
                        $goods->save();
                        Cache::forget($key);
                        echo '此次数据和前3次一样 存入数据 删除缓存';
                    }//否则不操作
                }
                //var_dump($countValue);

            }else{//3次以下时，继续加
                //echo '3次以下时，继续加';
                $cache[$ip] = $detail;

                cache([$key => $cache], now()->addHours(4));
            }

        }else{
            //echo '没有数据，第一次来';
            $cache = [$ip=>$detail];
            cache([$key=>$cache],now()->addHours(4));
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
    public function setDetail2(Request $request){
        $ip = $request->getClientIp();
        // $ip = $request->get('ip');
        $num_iid = $request->get('num_iid');
        //$detail = json_encode($request->get('detail'));
        $detail = $request->get('detail');

        $html = str_get_html($detail['pcDescContent']);
        $imgs = $html->find('img');
        $images = [];
        foreach ($imgs as $image){
            $images[] = 'https:'.$image->src;
        }
        $html->clear();
        //var_dump($images);exit;
        //var_dump($request->get('detail'));exit;
        //var_dump($detail['pcDescContent']);exit;
        //var_dump($detail->pcDescContent);exit;
        $goods = Goods::where('num_iid',$num_iid)->first();
        if($goods) {
            $goods->detail = json_encode($images);
            $goods->save();
        }
        if(!empty($images)){
            return $this->success($images);
        }else{
            return $this->failed('没有详情');
        }
        //return $this->message('ok');

        $key = 'detail_'.$num_iid;
        //暂时不用，使用需要修改
        if(Cache::has($key)){

            $cache = cache($key);
            if(count($cache)>2) {//3次以上时，判断是否相同
                //echo '3次以上时';
                $countValue = array_count_values($cache);
                if(count($countValue)>1){//有不同的数据出现
                    //echo '有不同的数据出现';
                  if(in_array($detail,$cache)){//在里面时，放进去
                      $cache[$ip] = $detail;
                      cache([$key => $cache], now()->addHours(4));
                      //echo '在里面时，放进去';
                  }else{//不在里面时，不放进去
                      //echo '不在里面时，不放进去';
                  }
                  if(in_array(4,$countValue)){//有第四次出现的，存入数据，删除缓存
                      foreach ($countValue as $k =>$v){
                          if($v == 4){
                              $detail = $k;
                          }
                      }
                      //存入数据 Todo
                      $goods = Goods::where('num_iid',$num_iid)->first();
                      $goods->detail = $detail;
                      $goods->save();
                      Cache::forget($key);
                      //echo '有第四次出现的，存入数据，删除缓存';
                  }
                }else{//没有不同数据
                    //echo '没有不同数据';
                    if(isset($countValue[$detail])){//此次数据和前3次一样 存入数据 删除缓存
                        //存入数据 Todo
                        $goods = Goods::where('num_iid',$num_iid)->first();
                        $goods->detail = $detail;
                        $goods->save();
                        Cache::forget($key);
                        echo '此次数据和前3次一样 存入数据 删除缓存';
                    }//否则不操作
                }
                //var_dump($countValue);

            }else{//3次以下时，继续加
                //echo '3次以下时，继续加';
                $cache[$ip] = $detail;

                cache([$key => $cache], now()->addHours(4));
            }

        }else{
            //echo '没有数据，第一次来';
            $cache = [$ip=>$detail];
            cache([$key=>$cache],now()->addHours(4));
        }
        //var_dump($cache);
        return $this->message('ok');
    }

    /**
     * 获取淘口令
     * @param $goodsId
     * @return mixed
     */
    public function getTpwd($goodsId){
        $goods = Goods::find($goodsId);
        if($goods) {//查到产品


            $url = $goods->click_url;
            if ($goods->isCoupon()) {
                $url = $goods->coupon_click_url;
            }
            if (empty($url)) {
                $url = $goods->item_url;
            }

            if (Auth::check()) {
                $user = Auth::user();
                //var_dump($user->taobao_pid);
                $pid = $user->taobao_pid;
                if(is_null($pid)){//没有PID的用户使用默认的
                    $taobao = new TaoBao();
                }else{//有PID的用户使用自己的
                    $ad_zone_id = (explode('_',$pid))[3];
                    $taobao = new TaoBao($pid,$ad_zone_id);
                }
                $model = $taobao->tpwd($goods->title, $url, $goods->pict_url, '{}');
            } else {
                $taobao = new TaoBao();
                $model = $taobao->tpwd($goods->title, $url, $goods->pict_url, '{}');
            }
            return $this->success(['tpwd'=>$model]);
        }else{//未查到产品
            return $this->failed('非法请求');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Goods  $goods
     * @return \Illuminate\Http\Response
     */
    public function edit(Goods $goods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Goods  $goods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goods $goods)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Goods  $goods
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goods $goods)
    {
        //
    }
}
