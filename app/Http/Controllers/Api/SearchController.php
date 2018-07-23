<?php

namespace App\Http\Controllers\Api;

use App\Common\TaoBao;
use App\Model\GoodsShare;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * 搜索产品
     * @param Request $request
     *      @param $keyWorld
     *      @param int $page
     *      @param int $sortId [0:人气,1:销量,2:到手价,3:推荐,4:默认]
     *      商品查询
     *      排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate）， 累计推广量（tk_total_sales），总支出佣金（tk_total_commi）
     * @return mixed
     */
    public function index(Request $request){
        $keyWord = $request->get('keyWord');
        $page = $request->get('page',1);
        $sortId = $request->get('sortId',3);
        $taobao = new TaoBao();
        $list = $taobao->searchDg($keyWord, $page, $sortId);
        if($list) {
            /*foreach ($list as $k => $v) {
                $list[$k]->category_id = 21779;//默认是搜索
                $goods = GoodsShare::getByNumIid($v->original_id);
                if (!empty($goods)) {
                    $v->id = $goods->id;
                    $v->exists = true;
                }
                $v->save();
            }*/
            return $this->success($list);
        }else{
            return $this->failed('没找到商品'.$taobao->getError());
        }
    }
    /**
     * 搜索产品
     * @param $keyWorld
     * @param int $page
     * @param int $sortId [0:人气,1:销量,2:到手价,3:推荐,4:默认]
     * @return array|mixed|\ResultSet|\SimpleXMLElement|void
     */
    /**
     * 商品查询
     * 排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate）， 累计推广量（tk_total_sales），总支出佣金（tk_total_commi）
     */
    public function actionSearch2($keyWord, $page = 1, $sortId = 1)
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

        /*$req = new \TbkItemGetRequest();//TbkItemGetRequest
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
        $req->setQ($keyWord);
        $req->setCat("16,18");
        // $req->setItemloc("杭州");
        $req->setSort($sortArr[$sortId]);
        $req->setIsTmall("false");
        $req->setIsOverseas("false");
        $req->setStartPrice("10");
        $req->setEndPrice("1000");
        $req->setStartTkRate("9910");
        $req->setEndTkRate("1");
        $req->setPlatform("2");
        $req->setPageNo($page);
        $req->setPageSize("20");*/






        $req = new \TbkDgMaterialOptionalRequest();
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
        $req->setHasCoupon("false");
//        $req->setIp("13.2.33.4");
        $req->setAdzoneId("1468146615");//推广位  第三段
        $req->setNeedFreeShipment("true");
        $req->setNeedPrepay("true");
        $req->setIncludePayRate30("true");
        $req->setIncludeGoodRate("true");
        $req->setIncludeRfdRate("true");
        $req->setNpxLevel("2");
        //$resp = $c->execute($req);

        /*$c = new \TopClient();
        $c->format = 'json';
        $c->appkey = env('TBK_APP_KEY');
        $c->secretKey = env('TBK_APP_SECRET');
        $resp = $c->execute($req);*/

        $c = new Tbk();
        $c->cache = \Yii::$app->request->get('cache', 1);
        $resp = $c->execute($req);
//        return $resp;
        return $resp->total_results > 0 ? $resp->result_list->map_data : [];
    }
}
