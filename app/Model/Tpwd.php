<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tpwd extends Model
{
    use SoftDeletes;

    protected $table = 'tpwd';
}
