<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RebateOrder extends Model
{
    use SoftDeletes;

    protected $table = 'rebate_order';
    public $fillable = ['trade_parent_id',
        'trade_id',
        'num_iid',
        'item_title',
        'item_num',
        'price',
        'pay_price',
        'seller_nick',
        'seller_shop_title',
        'commission',
        'commission_rate',
        'unid',
        'create_time',
        'earning_time'];
}
