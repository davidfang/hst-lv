<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryByGoods extends Model
{
    use SoftDeletes;

    protected $table = 'category_by_goods';
    public $fillable = ['categoryName',//'分类名称'
        'categoryId',//'分类ID'
        'goodsId',//'产品IDs'
        'date',//'日期'
        'channel',//'采集渠道'
    ];
}
