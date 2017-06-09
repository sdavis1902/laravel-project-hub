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

	protected static function boot() {
		parent::boot();

		static::created(function($comment) {
			$view = \View::make('task.snippets.view_comment_line', [
				'comment' => $comment
			]);
			$comment_html = $view->render();

			PusherHelper::trigger('task', 'new_comment', [
				'message'      => 'New Task Comment',
				'task_name'    => $comment->task->name,
				'comment'      => $comment->comment,
			]);

			PusherHelper::trigger('task_' . $comment->task->id, 'new_comment', [
				'comment_html' => $comment_html
			]);
		});
	}
}
