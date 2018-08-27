<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderRefund extends Model
{
    use SoftDeletes;

    protected $table = 'order_refund';
}
