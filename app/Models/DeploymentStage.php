<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DeploymentStage extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at','update_at','created_at'];

	public function deployments(){
		return $this->hasMany('App\Models\Deployment');
	}

	public function project(){
		return $this->belongsTo('App\Models\DeploymentProject');
	}
}
