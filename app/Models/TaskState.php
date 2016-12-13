<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TaskState extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function tasks(){
        return $this->hasMany('App\Models\Task');
    }
}
