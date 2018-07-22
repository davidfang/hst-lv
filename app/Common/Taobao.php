<?php

namespace App\Common;

use App\Model\GoodsShare;
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
    public function __construct()
    {
        $this->client = new TopClient(config('taobao.app_key'), config('taobao.app_secret'));
        $this->client->format = 'json';
        $this->adZoneId = config('taobao.ad_zone_id');
        $this->pid = config('taobao.pid');
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

    public function tpwd($text, $url)
    {
        $req = new TbkTpwdCreateRequest;
        $req->setText($text);
        $req->setUrl($url);
        $req->setExt("{}");

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
    public function favourite($pageNo=1,$pageSize=100)
    {
        $req = new TbkUatmFavoritesGetRequest();
        $req->setPageNo($pageNo);
        $req->setPageSize($pageSize);
        $req->setFields("favorites_title,favorites_id,type");
        $resp = $this->client->execute($req);
        if ($resp) {
            foreach ($resp->results->tbk_favorites as $row) {
                $favourites[$row->favorites_id] = $row->favorites_title;
            }
            return $resp->results->tbk_favorites;
        }
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
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,coupon_click_url,coupon_start_time,item_url,coupon_end_time,coupon_remain_count,coupon_info,click_url,status,volume");
        $resp = $this->client->execute($req);
        if ($resp) {

            $total = $resp->total_results;
            $pageTotal = $total / 20;
            $this->total = $total;
            $this->pages = ceil($pageTotal);
            $this->pageNo = $pageNo;
            $items = $resp->results->uatm_tbk_item;

            $list = new Collection();
            foreach ($items as $row) {
                $goods = $this->itemToModel($row);
                $list->add($goods);
            }
            return $list;
        } else {
            if (isset($resp->code)) {
                $this->error = $resp->code;
            }
            return false;
        }
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
        }
        if (isset($item->coupon_status)) {
            $goodsShare->coupon_status = $item->coupon_status;
        }
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
                            } else {
                                $v->coupon_amount = 0;
                            }
                            $v->zk_final_price = floatval($v->zk_final_price);
                            $v->coupon_price = floatval($v->zk_final_price - $v->coupon_amount);
                            $v->coupon_status = 1;
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
     * 通用物料搜索API（导购）
     * @param $keyWord
     * @param int $page
     * @param int $sortId
     * @return bool|Collection
     */
    public function searchDg($keyWord, $page = 1, $sortId = 3){
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
        $req->setSort($sortArr[$sortId]);
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
        if (empty($resp->code) ){

            $total = $resp->total_results;
            $pageTotal = $total / 20;
            $this->total = $total;
            $this->pages = ceil($pageTotal);
            $this->pageNo = $page;
            $items = $resp->result_list->map_data;
            //echo '<pre>';var_dump($items);exit;
            $list = new Collection();
            foreach ($items as $row) {
                $goods = $this->itemToModel($row);
                $list->add($goods);
            }
            return $list;
        } else {
            $this->error = $resp->code;
            return false;
        }
    }

}