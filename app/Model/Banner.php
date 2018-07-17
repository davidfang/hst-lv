<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
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
