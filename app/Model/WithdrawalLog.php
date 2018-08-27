<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalLog extends Model
{
    use SoftDeletes;

    protected $table = 'withdrawal_log';
}
