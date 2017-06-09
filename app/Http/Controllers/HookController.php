<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Validator;
use Illuminate\Http\Request;
use Session;
use Reminder;
use Mail;

use PusherHelper;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskFile;
use App\Models\TaskComment;
use App\Models\TaskState;
use App\Models\User;
use App\Models\UserBitbucketUsername;
use App\Models\UserGithubUsername;

class HookController extends Controller {
	public function bitbucket(Request $request){
		$changes = $request->input('push.changes');
		foreach( $changes as $change ){
			foreach( $change['commits'] as $commit ){
				$bbusername = $commit['author']['user']['username'];
				$bbcommiturl = $commit['links']['html']['href'];
				$bbcommithash = $commit['hash'];
				$bbcomment = $commit['message'];
				if( preg_match('/sdh-(\d+)/', $bbcomment, $matches) ){
					array_shift($matches);
					foreach( $matches as $match ){
						$id = $match;
						$task = Task::find($id);
						if( !$task ) continue;

						// we have a task, lets construct our comment
						$bituser = UserBitbucketUsername::where('username', '=', $bbusername)->first();
						if( !$bituser ) continue; // could not find user, skip

						$comment = new TaskComment;
						$comment->user_id = $bituser->user_id;
						$comment->task_id = $task->id;
						$comment->comment = "$bbcomment\n<a target=\"_blank\" href=\"$bbcommiturl\">$bbcommithash</a>";
						$comment->save();

						PusherHelper::trigger('git', 'new_push', [
							'message'   => 'New Git Push',
							'task_name' => $task->name,
							'comment'   => $comment->comment
						]);
					}
				}
			}
		}
	}

	public function github(Request $request){
		if( !$request->has('commits' ) ) return;

		$commits = $request->input('commits');

		foreach( $commits as $commit ){
			$ghusername = $commit['author']['username'];
			$ghcommiturl = $commit['url'];
			$ghcommithash = $commit['id'];
			$ghcomment = $commit['message'];

			if( preg_match('/sdh-(\d+)/', $ghcomment, $matches) ){
				array_shift($matches);
				foreach( $matches as $match ){
					$id = $match;
					$task = Task::find($id);
					if( !$task ) continue;

					// we have a task, lets construct our comment
					$gituser = UserGithubUsername::where('username', '=', $ghusername)->first();
					if( !$gituser ) continue; // could not find user, skip

					$comment = new TaskComment;
					$comment->user_id = $gituser->user_id;
					$comment->task_id = $task->id;
					$comment->comment = "$ghcomment\n<a target=\"_blank\" href=\"$ghcommiturl\">$ghcommithash</a>";
					$comment->save();

					PusherHelper::trigger('git', 'new_push', [
						'message'   => 'New Git Push',
						'task_name' => $task->name,
						'comment'   => $comment->comment
					]);
				}
			}
		}
	}
}
