<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Model\GoodsCategory;
use Encore\Admin\Controllers\ModelForm;

class ApiController extends Controller
{
    use ModelForm;

    public function parentGoodsCategory(){
        return GoodsCategory::where([['status','1'],['parent_id','0']])->get(['id','title as text'])->toArray();
    }
}
