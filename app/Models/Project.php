<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    use SoftDeletes;
	use Searchable;

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function tasks(){
        return $this->hasMany('App\Models\Task');
    }

	public function openTasks(){
        return $this->hasMany('App\Models\Task')->where('state_id', '<>', 6);
	}
}
