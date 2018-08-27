<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Bankcard extends Model
{
    use SoftDeletes;

    protected $table = 'bankcard';

    public $fillable = ['user_id','channel','bank_name','name','bank_card_no'];
    public $hidden = ['created_at','updated_at','updated_by'];
}
