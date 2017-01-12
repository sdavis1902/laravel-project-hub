<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DeploymentGroup extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function deployments(){
        return $this->hasMany('App\Models\Deployment');
    }
}
