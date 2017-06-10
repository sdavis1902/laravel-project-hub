<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DeploymentProject extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at','update_at','created_at'];

	public function stages(){
		return $this->hasMany('App\Models\DeploymentStage', 'deployment_project_id');
	}

	public function deployments(){
		return $this->hasManyThrough('App\Models\Deployment', 'App\Models\DeploymentStage');
	}
}
