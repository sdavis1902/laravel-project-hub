<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at', 'created_at'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function task(){
        return $this->belongsTo('App\Models\Task');
    }
}
