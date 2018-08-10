<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\Model\GoodsCategory;
use Illuminate\Http\Request;

class GoodsCategoryController extends Controller
{
    //
    public function index(){
        $parentCategories = GoodsCategory::where([['parent_id',0],['status',1]])->get(['id','parent_id','img_path','title'])->toArray();
        $children = GoodsCategory::where([['parent_id','>',0],['status',1]])->get(['id','parent_id','img_path','title'])->toArray();
        foreach ($children as $key => $child){
            $children[$key]['img_path'] = \Storage::url($child['img_path']);
        }
        $children = ArrayHelper::index($children,null,'parent_id');
        foreach ($parentCategories as $key => $parentCategory){
            $parentCategories[$key]['data'] = isset($children[$parentCategory['id']])?$children[$parentCategory['id']]:[];
        }
        return $this->success($parentCategories);
    }
}
