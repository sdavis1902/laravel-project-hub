<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use PusherHelper;

class Deployment extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at','update_at','created_at'];

	public function stage(){
		return $this->belongsTo('App\Models\DeploymentStage', 'deployment_stage_id');
	}

	protected static function boot() {
		parent::boot();

		static::updated(function($deployment) {
			PusherHelper::trigger('deployment', 'status_change', [
				'status' => $deployment->status
			]);
		});
	}

}
