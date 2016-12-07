<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->hasOne('App\Models\User');
    }

    public function project(){
        return $this->hasOne('App\Models\Project');
    }
}
