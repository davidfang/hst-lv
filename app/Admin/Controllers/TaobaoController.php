<?php

namespace App\Admin\Controllers;

use App\Common\TaoBao;
use App\Http\Controllers\Controller;
use App\Model\GoodsCategory;
use App\Model\GoodsShare;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Content;
use TopClient;
use TbkUatmFavoritesGetRequest;
class TaobaoController extends Controller
{
    use ModelForm;

    /**
     * 商品更新
     * @return Content|\Illuminate\Http\RedirectResponse
     */
    public function selection(){
        if(request()->isMethod('get')){
            $content                        =   new Content(function (Content $content){
                $content->header('商品更新');
                $content->description('商品更新是基于淘宝联盟选品库更新，选品库的命名规则为:一级分类名称-二级分类名称-1，例如：服装-女装-1，后面的数字用于将多个选品库合并到一个，因为淘宝联盟对选品库的选品组有限制，每个选品组最多包含200个商品，很显然一个选品组不能满足我们对分类
                的需求，因此后面加了数字角标，将多个选品组合并成一个分类');

                $content->body($this->form());
            });
            return $content;
        }


        $favoritesId                    =   request()->favorites_id;
        return redirect()->route('taobao.execute_update',['favorites_id'=>$favoritesId]);


    }

    /**
     * 选品库表单  列出选品库
     * @return string
     * @throws \Throwable
     */
    public function form(){
        $category = GoodsCategory::allSelectOptions();
        $data['categories'] =  $category;
        return view('admin.taobao.update', $data)->render();
        echo '<pre>';
        var_dump($category);exit;
        $parentCategories = GoodsCategory::where([['parent_id',0]])->get(['id','title'])->toArray();
        $children = GoodsCategory::where([['parent_id','>',0],['status',1]])->get(['id','title'])->toArray();
        //echo '<pre>';var_dump(array_merge($parentCategories , $children));
        $data['favorites'] =  array_merge($parentCategories , $children);
        return view('admin.taobao.update', $data)->render();

        $taobao                         =   new TaoBao();
        $list                           =   $taobao->favourite();
        if($list){
            session('fav');
            foreach ($list as $row){
                $favourites[$row['favorites_id']]     =   $row['favorites_title'];
            }
            session(['favorites'=>$favourites]);
            $data['favorites'] =  $list;
            return view('admin.taobao.update', $data)->render();
        }else{
            return '没有获取淘宝联盟选品库列表';
        }
    }

    public function executeUpdate($favoritesId,$pageNo=1){

        $taobao                         =   new TaoBao();
        $list                           =   $taobao->favouriteItem($favoritesId,$pageNo);
        if($list){

            $total                                      =   $taobao->getTotal();
            $pageTotal                                  =   $taobao->getPages();
            $favorites                                  =   session('favorites');
            $category                                   =   null;
            /*if($favorites){
                $categoryName                           =   $favorites[$favoritesId];
                $array                                  =   explode('-',$categoryName);

                $parent                                 =   GoodsCategory::getByName($array[0]);
                if($parent){
                    if(!isset($array[2])){
                        $category                       =   $parent;
                    }else{
                        $category                       =   GoodsCategory::getByParentIdAndName($parent->id,$array[1]);
                    }

                }

            }*/
            foreach ($list as $k=>$v){
                /*if($category){
                    $list[$k]->category_id              =   $category->id;
                }*/
//                $list[$k]->category_id              =   $favoritesId;
                //是否推荐商品
//                if(isset($channel) && !empty($channel)){
//                    $list[$k]->channel_id               =   $channel->id;
//                }
                $goods                                  =   GoodsShare::getByNumIid($v->original_id);
                if(!empty($goods)){
                    $v->id                              =   $goods->id;
                    $v->exists                          =   true;
                }
                $v->save();
            }
            $data['page_no']            =   $pageNo;
            $data['list']               =   $list;
            $data['page_total']         =   ceil($pageTotal);
            $data['total']              =   $total;
            $data['next_page_url']      =   '';
            if($data['page_total']!=$pageNo){
                $data['next_page_url']  =   url('taobao/executeUpdate',['favorites_id'=>$favoritesId,'page_no'=>$pageNo+1])   ;
            }
        }
        return view('admin.taobao.execute_update',$data);
    }
    public function executeOne(){
        $request                                    =   request();
        $goods                                      =   GoodsShare::getByNumIid($request->num_iid);

        if(empty($goods)){
            if(isset($request->recommend_id)){
                $goods                              =   new GoodsShare();
            }else{
                $goods                              =   new GoodsShare();
            }

            $goods->name                            =   $request->title;
            $goods->cover                           =   $request->pict_url;
            $goods->title                           =   $request->title;
            $goods->item_url                        =   $request->item_url;
            $goods->setPicturesAttribute($request->small_images['string']);
            $goods->original_id                     =   $request->num_iid;
        }
        if(isset($request->channel_id)){
            $goods->channel_id                      =   $request->channel_id;
        }else{
            $goods->category_id                     =   $request->category_id;
        }

        $goods->price                               =   $request->zk_final_price;
        $goods->status                              =   $request->status;

        if(!empty($request->click_url)){
            $goods->click_url                       =   $request->click_url;
        }

        if(!empty($request->coupon_click_url)){
            $goods->coupon_click_url                =   $request->coupon_click_url;
            $goods->coupon_start_time               =   $request->coupon_start_time;
            $goods->coupon_end_time                 =   $request->coupon_end_time;
            $goods->coupon_status                   =   1;
            $goods->coupon_amount                   =   $request->coupon_amount;
            $goods->coupon_start_fee                =   $request->coupon_start_fee;
        }
        $goods->volume                              =   $request->volume;
        $goods->coupon_remain_count                 =   $request->coupon_remain_count ?$request->coupon_remain_count : 0;
        $goods->save();
        return new MessageBag();
    }
}
