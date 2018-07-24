<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\Model\GoodsCategory;
use Illuminate\Http\Request;

class GoodsCategoryController extends Controller
{
    //
    public function index(){
        $parentCategories = GoodsCategory::where('parent_id',0)->get()->toArray();
        $children = GoodsCategory::where('parent_id','>',0)->get()->toArray();
        $children = ArrayHelper::index($children,null,'parent_id');
        foreach ($parentCategories as $key => $parentCategory){
            $parentCategories[$key]['data'] = isset($children[$parentCategory['id']])?$children[$parentCategory['id']]:[];
        }
        return $this->success($parentCategories);
    }
}
