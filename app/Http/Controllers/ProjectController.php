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

class ProjectController extends Controller {

	public function getIndex(){
		$projects = Project::get();

		return view('project.index', [
			'projects' => $projects
		]);
	}

}
