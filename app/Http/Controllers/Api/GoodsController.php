<?php

namespace App\Http\Controllers\Api;

use App\Model\Goods;
use App\Http\Resources\Goods as GoodsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
//use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * 首页推荐
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goods = Goods::where('status',1)->paginate(20);
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
