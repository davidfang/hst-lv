<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    protected $table = 'goods_category';
    public $incrementing = false;
    //
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','created_by','updated_by'
    ];
}
