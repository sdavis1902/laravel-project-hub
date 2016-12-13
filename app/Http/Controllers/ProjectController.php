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
}
