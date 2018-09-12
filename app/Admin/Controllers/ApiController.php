<?php

namespace App\Admin\Controllers;

use App\Common\TaoBao;
use App\Http\Controllers\Controller;
use App\Model\ArticleCategory;
use App\Model\GoodsCategory;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    use ModelForm;

    /**
     * 获得产品的父级分类
     * @return mixed
     */
    public function parentGoodsCategory()
    {
        return GoodsCategory::where([['status', '1'], ['parent_id', '0']])->get(['id', 'title as text'])->toArray();
    }
    /**
     * 获得文章的父级分类
     * @return mixed
     */
    public function parentArticleCategory()
    {
        return ArticleCategory::where([['status', '1'], ['parent_id', '0']])->get(['id', 'title as text'])->toArray();
    }

    public function allArticleCategory()
    {

    }

    /**
     * 获得七牛token
     * @param Request $request
     * @return array
     */
    public function qiniuToken(Request $request)
    {
        $disk = \Storage::disk('qiniu');
        $token = $disk->uploadToken();
        return ["uptoken"=>$token];
    }

}
