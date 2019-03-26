<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //关联的表名
    public $table = 'user_art';
//    表的主键
    // public $primaryKey = 'id';

//    是否自动维护created_at和updated_at字段
    public $timestamps = false;

    public $guarded=[];

    //添加动态属性，关联权限模型
    // public function arts()
    // {
    //     return $this->belongsToMany('App\Model\Collection','role_permission','role_id','permission_id');
    // }
}
