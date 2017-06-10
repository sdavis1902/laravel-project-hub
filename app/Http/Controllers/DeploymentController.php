<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Mail;

use App\Models\Deployment;
use App\Models\DeploymentProject;
use App\Models\DeploymentStage;

use App\Jobs\RunDeployment;

class DeploymentController extends Controller {
	public function getIndex(){
		$projects = DeploymentProject::where('status', '=', 'Active')->get();

		return view('deployment.index', [
			'projects' => $projects
		]);
	}

	public function postEditProject(Request $request, $id = 0){
		$rules = [
            'name'       => 'required',
            'repository' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);

        if( $v->fails() ){
            return redirect('deployment/'. ( $id ? "edit-project/$id" : 'create-project' ))->withErrors($v)->withInput();
        }

        if( $id ){
            $project = DeploymentProject::find($id);
            if( !$project ) return redirect('deployment')->withMessage('Could not find deployment project with the provided id');
        }else{
            $project = new DeploymentProject;
        }

        $project->name        = $request->input('name');
        $project->status      = $request->input('status');
        $project->description = $request->input('description');
        $project->repository  = $request->input('repository');
        $project->save();

        $message = 'Deployment Project has been ' . ( $id ? 'updated' : 'created' );
        return redirect('deployment')->withMessage($message);
	}

	public function getEditProject($id = 0){
		$project = $id ? DeploymentProject::find($id) : null;

		return view('deployment.edit_project', [
			'project' => $project,
		]);
	}

	public function postCreateProject(Request $request){
		return $this->postEditProject($request);
	}

	public function getCreateProject(){
		return $this->getEditProject();
	}

	public function postEditStage(Request $request, $project_id, $id = 0){
		$rules = [
            'name'        => 'required',
            'branch'      => 'required',
            'host'        => 'required',
            'host_user'   => 'required',
            'deploy_path' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);

        if( $v->fails() ){
            return redirect('deployment/'. ( $id ? "edit-stage/$project_id/$id" : "create-stage/$project_id" ))->withErrors($v)->withInput();
        }

        if( $id ){
            $stage = DeploymentStage::find($id);
            if( !$stage ) return redirect('deployment')->withMessage('Could not find deployment stage with the provided id');
        }else{
            $stage = new DeploymentStage;
			$project = DeploymentProject::find($project_id);
			if(!$project) return redirect('deployment')->withError('Invalid Deployment Project');
			$stage->deployment_project_id = $project->id;
        }

        $stage->name                  = $request->input('name');
        $stage->status                = $request->input('status');
        $stage->description           = $request->input('description');
        $stage->branch                = $request->input('branch');
        $stage->host                  = $request->input('host');
        $stage->host_user             = $request->input('host_user');
        $stage->host_become           = $request->input('host_become');
        $stage->deploy_path           = $request->input('deploy_path');
        $stage->save();

        $message = 'Deployment Stage has been ' . ( $id ? 'updated' : 'created' );
        return redirect('deployment')->withMessage($message);
	}

	public function getEditStage($project_id, $id = 0){
		$stage = $id ? DeploymentStage::find($id) : null;

		return view('deployment.edit_stage', [
			'stage' => $stage,
		]);
	}

	public function postCreateStage(Request $request, $project_id){
		return $this->postEditStage($request, $project_id);
	}

	public function getCreateStage($project_id){
		return $this->getEditStage($project_id);
	}

	// stuff for actually running the deployment
	public function getStart($stage_id){
		$stage = DeploymentStage::find($stage_id);

		if(!$stage || $stage->status != 'Active') return redirect('deployment')->withError('Invalid Deployment Stage');

		$dep = new Deployment;
		$dep->status = 'Queued';
		$dep->deployment_stage_id = $stage->id;
		$dep->logs = '';
		$dep->save();

		dispatch((new RunDeployment($dep))->onQueue('deployment'));

		return redirect('deployment/view/' . $dep->id);
	}

	public function getStageHistory($id){
		$stage = DeploymentStage::find($id);
		if(!$stage) return redirect('deployment')->withError('Invalid Stage');

		return view('deployment.stage_history', [
			'stage' => $stage
		]);
	}

	public function getView($id){
		$dep = Deployment::with('stage')->find($id);
		if(!$dep) return redirect('deployment')->withError('Invalid Deployment');

		return view('deployment.view', [
			'dep' => $dep
		]);
	}
}
