<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //主键
    public $primaryKey = 'id';

    //黑名单
    protected $guarded = [];

    //添加动态属性 关联权限模型
    public function permission()
    {
        return $this->belongsToMany('App\Models\Permission','role_permission','role_id','permission_id');
    }
}
