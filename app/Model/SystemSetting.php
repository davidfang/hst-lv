<?php

namespace App\Model;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSetting extends Model
{
    use SoftDeletes;

    protected $table = 'systems_setting';
    /**
     * 创建者
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function createdBy(){
        return $this->hasOne(Administrator::class,'id','created_by');
    }

    /**
     * 修改者
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function updatedBy(){
        return $this->hasOne(Administrator::class,'id','updated_by');
    }
}
