<?php

namespace App\Console\Commands;

use App\Helpers\ArrayHelper;
use App\Model\CategorySpider;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use zgldh\QiniuStorage\QiniuAdapter;

class HuashengCategorySpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huasheng:categorySpider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '花生分类抓取 采集分类  （每周只需要操作一次）';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 抓取图片到七牛
     * @param $url
     */
    public function fetchImgToQiniu($url){
        $accessKey = getenv('QINIU_ACCESS_KEY');
        $secretKey = getenv('QINIU_SECRET_KEY');
        $bucket = getenv('QINIU_BUCKET');
        $auth = new Auth($accessKey, $secretKey);
        $bucketManager = new BucketManager($auth);
        //$url = 'http://devtools.qiniu.com/qiniu.png';

        $key = 'category/'.uniqid().'.png';
        list($ret, $err) = $bucketManager->fetch($url, $bucket, $key);
        //echo "=====> fetch $url to bucket: $bucket  key: $(etag)\n";
        if ($err !== null) {
            //var_dump($err);
            return null;
        } else {
            //print_r($ret);
            return $ret['key'];
            return \Storage::disk(env('DISK'))->url($ret['key']);
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //$img = $this->fetchImgToQiniu('http://devtools.qiniu.com/qiniu.png');
        //exit($img);

        //
        $client = new Client();
        $uri = 'https://api.drgou.com/category/queryTypeList';

        $res = $client->request('POST', $uri, ['form_params' => [
            'categoryId' => '-1',
            //'sign' => 'l035smTMsQMNokDTH/jMapORMJk=',
            //'timeStamp' => '1546407573000',
            //'token' => 'f194253e8cdf42b38493af9a6bc3d46d_17245226_2',
        ]]);
        if($res->getStatusCode() == '200') {
            $body = $res->getBody();
            //dd(json_decode($body,true));
            $categorys = json_decode($body,true);
            $array = [];
            foreach ($categorys['data']['list'] as $category){
//                $father[''] = $category[''];
                $father["my_category_id"] = $father["id"]=$category['id'];
                $father["parentId"]=$category['parentId'];
                $father["categoryCode"]=$category['categoryCode'];
                $father["name"]=$category['name'];
                $father["linkType"]=$category['linkType'];
                $father["linkParam"]=$category['linkParam'];
                $father["pic"]=$category['pic'];
                $father["my_pic"]=$this->fetchImgToQiniu($category['pic']);
                $father["queryTag"]=$category['queryTag'];
                $father["showSubTotal"]=$category['showSubTotal'];
                $array[] = $father;
                if(!empty($category['subList'])){
                    foreach ($category['subList'] as $subList){
                        //$child[''] = $subList[''];
                        $child["my_category_id"] = $child["id"] = $subList['id'];
                        $child["parentId"] = $subList['parentId'];
                        $child["categoryCode"] = $subList['categoryCode'];
                        $child["name"] = $subList['name'];
                        $child["linkType"] = $subList['linkType'];
                        $child["linkParam"] = $subList['linkParam'];
                        $child["pic"] = $subList['pic'];
                        $child["my_pic"] = $this->fetchImgToQiniu($subList['pic']);
                        $child["queryTag"] = $subList['queryTag'];
                        $child["showSubTotal"] = $subList['showSubTotal'];
                        //$child["subList"] = $subList[''];
                        //$child["posterList"] = $subList[''];
                        $array[] = $child;
                    }
                }

            }
            \DB::table('categorySpider')->insert($array);
            dd($array);
        }else{
            $this->line('花生分类抓取请求失败');
        }
    }
}
