<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //主键
    public $primaryKey = 'id';

    //黑名单
    protected $guarded = [];

    //不维护
    public $timestamps = false;

}
