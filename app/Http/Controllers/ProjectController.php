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

use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskState;

class ProjectController extends Controller {

	public function getIndex(){
		$projects = Project::get();

		return view('project.index', [
			'projects' => $projects
		]);
	}

	public function postEdit(Request $request, $id = 0){
		$rules = [
            'name' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);

        if( $v->fails() ){
            return redirect('project/edit'. ($id?"/$id":''))->withErrors($v)->withInput();
        }

        if( $id ){
            $project = Project::find($id);
            if( !$project ) return redirect('project')->withMessage('Could not find project with the provided id');
        }else{
            $project = new Project;
        }

        $project->name = $request->input('name');
        $project->status = $request->input('status');
        $project->user_id = $request->input('user_id');
        $project->description = $request->input('description');
		$project->due_date = date('Y-m-d H:i:s', time()+60*60*24*7);
        $project->save();

        $message = $id ? 'Project has been updated' : 'Project has been created';
        return redirect('project')->withMessage($message);
	}

	public function getEdit($id = 0){
		$project = $id ? Project::find($id) : null;
		$users = User::get();
		$statuses = ['Active','Done','Backlog'];

		return view('project.edit', [
			'project' =>  $project,
			'users'   =>  $users,
			'statuses' => $statuses
		]);
	}

	public function getDashboard($id){
		$project = Project::find($id);
		$states = TaskState::orderBy('priority','asc')->get();

		foreach( $states as $key => $state ){
			$tasks = Task::where('project_id', '=', $project->id)->where('state_id', '=', $state->id)->orderBy('priority', 'asc');
			if( $state->name == 'Done' ){
				$tasks = $tasks->where('updated_at', '>', date('Y-m-d H:i:s', time()-(60*60*24*6)));
			}
			$states[$key]->dash_tasks = $tasks->get();
		}

		$width = floor(100/$states->count());

		return view('project.dashboard', [
			'project' => $project,
			'states' => $states,
			'width' => $width
		]);
	}

	public function postDashboardUpdate(Request $request){
		$tasks = $request->input('tasks');

		if( !$tasks ) return ['status' => 'success'];

		foreach( $tasks as $task ){
			$t = Task::find($task['task_id']);
			if( !$t ) continue;

			$t->state_id = $task['state_id'];
			$t->priority = $task['priority'];
			$t->save();
		}

        return ['status' => 'success'];
	}
}
