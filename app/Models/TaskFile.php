<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function task(){
        return $this->belongsTo('App\Models\Task');
    }

	protected static function boot() {
        parent::boot();

        static::deleting(function($file) {
            $filename = $file->url;
            if( $filename ){
                \Storage::disk('local')->delete($filename);
            }
        });
    }
}
