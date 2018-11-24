<?php

namespace App\Common;

use App\Helpers\ArrayHelper;
use App\Model\DgSearch;
use App\Model\Goods;
use App\Model\GoodsShare;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use TbkDgItemCouponGetRequest;
use TbkItemInfoGetRequest;
use TbkItemRecommendGetRequest;
use TbkTpwdCreateRequest;
use TbkUatmFavoritesItemGetRequest;
use TbkUatmFavoritesGetRequest;
use TbkDgMaterialOptionalRequest;
use TopClient;

class TaoBao
{
    private $client;
    private $error = '商品不存在';
    private $total;
    private $pageNo;
    private $pages;
    private $adZoneId;
    private $pid;

    /**
     * TaoBao constructor.
     */
    public function __construct($pid = null, $ad_zone_id = null, $app_key = null, $app_secret = null)
    {
        $app_key = is_null($app_key) ? config('taobao.app_key') : $app_key;
        $app_secret = is_null($app_secret) ? config('taobao.app_secret') : $app_secret;
        $this->client = new TopClient($app_key, $app_secret);
        $this->client->format = 'json';
        $this->adZoneId = is_null($ad_zone_id) ? config('taobao.ad_zone_id') : $ad_zone_id;
        $this->pid = is_null($pid) ? config('taobao.pid') : $pid;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getPageNo()
    {
        return $this->pageNo;
    }

    /**
     * @param mixed $pageNo
     */
    public function setPageNo($pageNo)
    {
        $this->pageNo = $pageNo;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }


    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error)
    {
        $this->error = $error;
    }


    public function item($numIid)
    {
        if (empty($numIid)) {
            $this->error = '非法的num_iid';
            return false;
        }
        $req = new TbkItemInfoGetRequest();
        $req->setFields("num_iid,title,pict_url,small_images,zk_final_price,item_url,volume");
        $req->setNumIids($numIid);
        $resp = $this->client->execute($req);
        if (!empty($resp->results->n_tbk_item)) {
            $items = $resp->results->n_tbk_item;
            foreach ($items as $row) {
                return $this->itemToModel($row);
            }
            return null;
        } else {
            if (isset($resp->code)) {
                $this->error = $resp->msg;
                return false;
            }
            return null;
        }
    }

    /**
     * 获取淘口令
     * @param $text
     * @param $url
     * @param $logo
     * @param string $ext
     * @return \SimpleXMLElement|string
     */
    public function tpwd($text, $url, $logo, $ext = '{}')
    {
        $newUrl = $url;
        if (substr($newUrl, 0, 5) != 'https') {
            $newUrl = 'https' . $url;
        }
        if (substr($newUrl, 0, 6) != 'https:') {
            $newUrl = 'https:' . $url;
        }
        $req = new TbkTpwdCreateRequest;
        $req->setText($text);
        $req->setUrl($newUrl);
        $req->setExt($ext);
        $req->setLogo($logo);
        $resp = $this->client->execute($req);
        if (isset($resp->code)) {
            return '';
        }

        return $resp->data->model;
    }

    public function recommend($numIid)
    {
        $req = new TbkItemRecommendGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,volume");
        $req->setNumIid($numIid);
        $req->setCount("20");
        $req->setPlatform("1");
        $resp = $this->client->execute($req);

        if (!empty($resp->results->n_tbk_item)) {
            $items = $resp->results->n_tbk_item;
            $list = new Collection();
            foreach ($items as $row) {
                $goods = $this->itemToModel($row);
                $list->add($goods);
            }
            return $list;
        } else {
            if (isset($resp->code)) {
                $this->error = $resp->code;
                return false;
            }
            return null;
        }
    }

    /**
     * 获取淘宝联盟选品库列表
     * @param int $pageNo
     * @param int $pageSize
     * @return \SimpleXMLElement
     */
    public function favourite($pageNo = 1, $pageSize = 100)
    {
        $req = new TbkUatmFavoritesGetRequest();
        $req->setPageNo($pageNo);
        $req->setPageSize($pageSize);
        $req->setFields("favorites_title,favorites_id,type");
        $resp = $this->client->execute($req);
        if ($resp) {
            $array = ArrayHelper::toArray($resp->results->tbk_favorites);
//            echo '<pre>';
//            var_dump($array);
//            echo '-------------------------------';
            ArrayHelper::multisort($array, 'favorites_title');
//            var_dump($array);exit;
            return $array;
        }
        return null;
    }

    /**
     *
     * 获取淘宝联盟选品库的宝贝信息
     * @param $favoriteId
     * @param $pageNo
     * @return bool|Collection
     */
    public function favouriteItem($favoriteId, $pageNo)
    {
        $req = new TbkUatmFavoritesItemGetRequest();
        $req->setPlatform("1");
        $req->setPageSize("20");
        $req->setAdzoneId(config('taobao.ad_zone_id'));
        $req->setFavoritesId($favoriteId);
        $req->setPageNo($pageNo);
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,click_url,nick,seller_id,volume,tk_rate,zk_final_price_wap,shop_title,event_start_time,event_end_time,type,status,category,coupon_click_url,coupon_end_time,coupon_info,coupon_start_time,coupon_total_count,coupon_remain_count");
        $resp = $this->client->execute($req);
        if (!isset($resp->code)) {

            $total = $resp->total_results;
            $pageTotal = $total / 20;
            $this->total = $total;
            $this->pages = ceil($pageTotal);
            $this->pageNo = $pageNo;
            $items = $resp->results->uatm_tbk_item;

            $list = new Collection();
            foreach ($items as $row) {
                $isExit = Goods::find($row->num_iid);
                //$goods = $this->itemToModel($row);
                if (!$isExit) {
                    $goods = $this->favouriteItemToModel($row, $favoriteId);
                    $list->add($goods);
                }
            }
            return $list;
        } else {
            $this->error = $resp->code;
            return false;
        }
    }

    //获取淘宝联盟选品库的宝贝信息  入库
    protected function favouriteItemToModel($item, $category_id = null)
    {
//        echo '<pre>';
//        var_dump(isset($item->coupon_info));
//        var_dump($item);exit;
        $goods = new Goods();
        $goods->id = 0;
        if ($category_id) {
            $goods->category_id = $category_id;
        }


        // $goods->category_id = $item->title;// 分类ID,
        $goods->num_iid = $item->num_iid;// 商品ID,
        $goods->title = $item->title;// 商品标题,
        $goods->pict_url = $item->pict_url;// 商品主图,

        $goods->small_images = isset($item->small_images->string) ? $item->small_images->string : '';// 商品小图列表,

        $goods->reserve_price = $item->reserve_price;// 商品一口价格,
        $goods->zk_final_price = $item->zk_final_price;// 商品折扣价格,
        $goods->user_type = $item->user_type;// 卖家类型，0表示集市，1表示商城,
        $goods->provcity = $item->provcity;// 宝贝所在地,
        $goods->item_url = $item->item_url;// 商品地址,
        if (isset($item->click_url)) {
            $goods->click_url = $item->click_url;// 淘客地址,
        }
        $goods->nick = $item->nick;// 卖家昵称,
        $goods->seller_id = $item->seller_id;// 卖家id,
        $goods->volume = $item->volume;// 30天销量,
        $goods->tk_rate = $item->tk_rate;// 收入比例，举例，取值为20.00，表示比例20.00%,
        $goods->zk_final_price_wap = $item->zk_final_price_wap;// 无线折扣价，即宝贝在无线上的实际售卖价格。,
        $goods->shop_title = $item->shop_title;// 店铺名称,
        $goods->event_start_time = $item->event_start_time;// 招商活动开始时间；如果该宝贝取自普通选品组，则取值为1970-01-01 00:00:00；,
        $goods->event_end_time = $item->event_end_time;// 招行活动的结束时间；如果该宝贝取自普通的选品组，则取值为1970-01-01 00:00:00,
        $goods->type = $item->type;// 宝贝类型：1 普通商品； 2 鹊桥高佣金商品；3 定向招商商品；4 营销计划商品;,
        $goods->status = $item->status;// 宝贝状态，0失效，1有效；注：失效可能是宝贝已经下线或者是被处罚不能在进行推广,
        if (isset($item->category)) {
            $goods->category = $item->category;// 淘宝 后台一级类目,
        }
        if (isset($item->coupon_click_url)) {
            $goods->coupon_click_url = $item->coupon_click_url;// 商品优惠券推广链接,
        }

        if (isset($item->coupon_end_time)) {
            $goods->coupon_end_time = $item->coupon_end_time;// 优惠券结束时间,
        }

        if (isset($item->coupon_info)) {
            $goods->coupon_info = $item->coupon_info;// 优惠券面额,
        }

        if (isset($item->coupon_start_time)) {
            $goods->coupon_start_time = $item->coupon_start_time;// 优惠券开始时间,
        }

        if (isset($item->coupon_total_count)) {
            $goods->coupon_total_count = $item->coupon_total_count;// 优惠券总量,
        }

        if (isset($item->coupon_remain_count)) {
            $goods->coupon_remain_count = $item->coupon_remain_count;// 优惠券剩余量,
        }


        //$goods->detail = $item->title;// 产品详情,

        //$goods->from_site_url = $item->title;// 采集第三方网站,

        if ($goods->isCoupon()) {// 优惠券状态
            $goods->coupon_status = 1;
        }

        return $goods;

    }

    protected function itemToModel($item)
    {
        $goodsShare = new GoodsShare();
        $goodsShare->id = 0;
        $goodsShare->name = $item->title;
        $goodsShare->title = $item->title;
        $goodsShare->pictures = isset($item->small_images->string) ? $item->small_images->string : '';
        $goodsShare->price = $item->zk_final_price;
        $goodsShare->original_id = $item->num_iid;;
        $goodsShare->item_url = $item->item_url;
        $goodsShare->cover = $item->pict_url;
        $goodsShare->volume = $item->volume;
        $goodsShare->status = 1;
        if (isset($item->coupon_info)) {
            $goodsShare->coupon_info = $item->coupon_info;
        }
        if (isset($item->coupon_end_time)) {
            $goodsShare->coupon_end_time = $item->coupon_end_time;
        }
        if (isset($item->coupon_amount)) {
            $goodsShare->coupon_amount = $item->coupon_amount;
        }
        if (isset($item->coupon_start_time)) {
            $goodsShare->coupon_start_time = $item->coupon_start_time;
        }
        if (isset($item->coupon_price)) {
            $goodsShare->coupon_price = $item->coupon_price;
        }/*
        if (isset($item->coupon_status)) {
            $goodsShare->coupon_status = $item->coupon_status;
        }*/
        if (isset($item->coupon_click_url)) {
            $goodsShare->coupon_click_url = $item->coupon_click_url;
        }
        if (isset($item->coupon_remain_count)) {
            $goodsShare->coupon_remain_count = $item->coupon_remain_count;
        }
        if (isset($item->coupon_start_fee)) {
            $goodsShare->coupon_start_fee = $item->coupon_start_fee;
        }
        if (isset($item->click_url)) {
            $goodsShare->click_url = $item->click_url;
        }
        if ($goodsShare->isCoupon()) {
            $goodsShare->coupon_status = 1;
        }
        return $goodsShare;
    }

    /**
     * @param $keywords
     * @param int $perPageSize
     * @return bool|LengthAwarePaginator
     */
    public function searchCoupon($keywords, $perPageSize = 10)
    {
        $page = request()->page;
        $req = new TbkDgItemCouponGetRequest();
        $req->setQ($keywords);
        $req->setAdzoneId(config('taobao.ad_zone_id'));
        $req->setPlatform('1');
        $req->setPageSize('16');
        $req->setPageNo($page);
        $resp = $this->client->execute($req);
        $result = [];

        if (empty($resp->code)) {
            if ($resp->total_results > 0) {
                if (isset($resp->results)) {
                    $list = new Collection();
                    $data = $resp->results->tbk_coupon;
                    if ($data) {
                        foreach ($data as $k => $v) {

                            preg_match_all('/\d+/', $v->coupon_info, $matches);

                            if ($matches) {
                                $v->coupon_amount = $matches[0][1];
                                $v->coupon_status = 1;
                            } else {
                                $v->coupon_amount = 0;
                            }
                            $v->zk_final_price = floatval($v->zk_final_price);
                            $v->coupon_price = floatval($v->zk_final_price - $v->coupon_amount);

                            $list->add($this->itemToModel($v));
                        }
                        $paginator = new LengthAwarePaginator($list, $resp->total_results, 16, $req->getPageNo());
                        $paginator->appends(['keywords' => $keywords]);
                        $paginator->setPath('/search/coupon');
                        return $paginator;
                    }
                }

            }
        } else {
            $this->error = $resp->msg;
        }
        return null;
    }

    /**
     * 通用物料搜索API（导购） 用户搜索专用
     * @param $keyWord
     * @param int $page
     * @param int $sortId
     * @return bool|Collection
     */
    public function searchDgForUser($keyWord, $page = 1, $sortId = 3)
    {
        $sortArr = [
            1 => 'total_sales_des',
            2 => 'total_sales_asc',
            3 => 'tk_rate_des',
            4 => 'tk_rate_asc',
            5 => 'tk_total_sales_des',
            6 => 'tk_total_sales_asc',
            7 => 'tk_total_commi_des',
            8 => 'tk_total_commi_asc'
        ];
        $sortId = isset($sortArr[$sortId]) ? $sortId : 1;
        $req = new TbkDgMaterialOptionalRequest();
        //$req->setStartDsr("10");
        $req->setPageSize("20");
        $req->setPageNo($page);
        $req->setPlatform("2");
        //$req->setEndTkRate("1234");
        //$req->setStartTkRate("1234");
        //$req->setEndPrice("10");
//        $req->setStartPrice("10");
//        $req->setIsOverseas("false");
//        $req->setIsTmall("false");
        //$req->setSort($sortArr[$sortId]);
//        $req->setItemloc("杭州");
//        $req->setCat("16,18");
        $req->setQ($keyWord);
//        $req->setHasCoupon("false");
//        $req->setIp("13.2.33.4");
        $req->setAdzoneId($this->adZoneId);//推广位  第三段
//        $req->setNeedFreeShipment("true");
//        $req->setNeedPrepay("true");
//        $req->setIncludePayRate30("true");
//        $req->setIncludeGoodRate("true");
//        $req->setIncludeRfdRate("true");
//        $req->setNpxLevel("2");
        $resp = $this->client->execute($req);
        //echo '<pre>';var_dump($resp);exit;
//        return $resp;
        //return $resp->total_results > 0 ? $resp->result_list->map_data : [];
        if (empty($resp->code)) {

            $total = $resp->total_results;
            $pageTotal = $total / 20;
            $this->total = $total;
            $this->pages = ceil($pageTotal);
            $this->pageNo = $page;
            $items = $resp->result_list->map_data;
            //echo '<pre>';var_dump($items);exit;
            $list = new Collection();
            foreach ($items as $row) {
                //$goods = $this->itemToModel($row);
                $dgSearch = DgSearch::firstOrCreate(['num_iid' => $row->num_iid]);
                $dgSearch->keyWord = $keyWord; //关键词
                if (isset($row->coupon_start_time)) {
                    $dgSearch->coupon_start_time = $row->coupon_start_time;// 优惠券开始时间
                }
                if (isset($row->coupon_end_time)) {
                    $dgSearch->coupon_end_time = $row->coupon_end_time;// 优惠券结束时间
                    $dgSearch->coupon_status = 1;//是否有优惠券
                }
                $dgSearch->info_dxjh = $row->info_dxjh;// 定向计划信息
                $dgSearch->tk_total_sales = $row->tk_total_sales;// 淘客30天月推广量;
                $dgSearch->tk_total_commi = $row->tk_total_commi;// 月支出佣金
                if (isset($row->coupon_id)) {
                    $dgSearch->coupon_id = $row->coupon_id;// 优惠券id;
                }
                $dgSearch->num_iid = (string)$row->num_iid;// 宝贝id;
                $dgSearch->title = $row->title;// 商品标题
                $dgSearch->pict_url = $row->pict_url;// 商品主图
                if (isset($row->small_images)) {// 商品小图列表
                    $dgSearch->small_images = isset($row->small_images->string) ? $row->small_images->string : '';
                }
                $dgSearch->reserve_price = $row->reserve_price;// 商品一口价格
                $dgSearch->zk_final_price = $row->zk_final_price;// 商品折扣价格
                $dgSearch->user_type = $row->user_type;// 卖家类型，0表示集市，1表示商城->nullable();
                $dgSearch->provcity = $row->provcity;// 宝贝所在地
                $dgSearch->item_url = $row->item_url;// 商品地址
                $dgSearch->include_mkt = $row->include_mkt;// 是否包含营销计划
                $dgSearch->include_dxjh = $row->include_dxjh;// 是否包含定向计划
                $dgSearch->commission_rate = $row->commission_rate;// 佣金比率
                if (isset($row->volume)) {
                    $dgSearch->volume = $row->volume;// 30天销量->nullable();
                }
                $dgSearch->seller_id = $row->seller_id;// 卖家id->nullable();
                if (isset($row->coupon_total_count)) {
                    $dgSearch->coupon_total_count = $row->coupon_total_count;// 优惠券总量
                }
                if (isset($row->coupon_remain_count)) {
                    $dgSearch->coupon_remain_count = $row->coupon_remain_count;// 优惠券剩余量
                }
                if (isset($row->coupon_info)) {
                    $dgSearch->coupon_info = $row->coupon_info;// 优惠券面额
                }
                $dgSearch->commission_type = $row->commission_type;// 佣金类型  MKT表示营销计划，SP表示定向计划，COMMON表示通用计划->nullable();
                $dgSearch->shop_title = $row->shop_title;// 店铺名称
                if (isset($row->shop_dsr)) {
                    $dgSearch->shop_dsr = $row->shop_dsr;// 店铺dsr评分->nullable();
                }
                if (isset($row->coupon_share_url)) {
                    $dgSearch->coupon_share_url = $row->coupon_share_url;// 券二合一页面链接
                }
                $dgSearch->url = $row->url;// 商品淘客链接


                //$dgSearch->tpwd;
                //生成淘口令开始
                $url = $dgSearch->click_url;
                if ($dgSearch->isCoupon()) {
                    $url = $dgSearch->coupon_share_url;
                }
                if (empty($url)) {
                    $url = $dgSearch->item_url;
                }
                $model = $this->tpwd($dgSearch->title, $url, $dgSearch->pict_url, '{}');
                $dgSearch->tpwd = $model;
                $dgSearch->tpwd_created_at = Carbon::now();
                //生成淘口令结束


                $dgSearch->save();
                $list->add($dgSearch);
            }
            return $list;
        } else {
            $this->error = $resp->code;
            return false;
        }
    }
    public function searchDg($params){
        $req = new TbkDgMaterialOptionalRequest();

//        $req->setQ($keyWord);
        if(empty($params['adzone_id'])){
            $params['adzone_id'] = $this->adZoneId;
        }
        if(empty($params['page_size'])){
            $params['page_size'] = 20;
        }
        if(empty($params['page_no'])){
            $params['page_no'] = 1;
        }
        $params = array_filter($params);
        foreach ($params as $k => $v){
            $k = camel_case('set_'.$k);
            $req->$k($v);
        }
        $resp = $this->client->execute($req);
        //echo '<pre>';var_dump($resp);exit;
//        return $resp;
        //return $resp->total_results > 0 ? $resp->result_list->map_data : [];
        if (empty($resp->code)) {

            $total = $resp->total_results;
            $pageTotal = $total / $params['page_size'];
            $this->total = $total;
            $this->pages = ceil($pageTotal);
            $this->pageNo = $params['page_no'];
            return $items = $resp->result_list->map_data;
        }else{
            $this->error = $resp->code;
            return false;
        }
    }

}