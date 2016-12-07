<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function runs(){
        return $this->hasMany('App\Models\DeploymentRun');
    }
}
