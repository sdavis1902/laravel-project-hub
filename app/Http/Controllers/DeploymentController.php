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
            'name' => 'required'
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
        $project->save();

        $message = 'Deployment Project has been ' . ( $id ? 'updated' : 'created' );
        return redirect('deployment')->withMessage($message);
	}

	public function getEditProject($id = 0){
		$project = $id ? DeploymentProject::find($id) : null;

		return view('deployment.project_edit', [
			'project' => $project,
		]);
	}

	public function postCreateProject(Request $request){
		return $this->postEditProject($request);
	}

	public function getCreateProject(){
		return $this->getEditProject();
	}

	public function postEditStage(Request $request, $id = 0){
		$rules = [
            'name' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);

        if( $v->fails() ){
            return redirect('deployment/'. ( $id ? "edit-stage/$id" : 'create-stage' ))->withErrors($v)->withInput();
        }

        if( $id ){
            $stage = DeploymentStage::find($id);
            if( !$stage ) return redirect('deployment')->withMessage('Could not find deployment stage with the provided id');
        }else{
            $stage = new DeploymentStage;
        }

        $stage->name                  = $request->input('name');
        $stage->status                = $request->input('status');
        $stage->description           = $request->input('description');
        $stage->deployment_project_id = $request->input('deployment_project_id');
        $stage->save();

        $message = 'Deployment Stage has been ' . ( $id ? 'updated' : 'created' );
        return redirect('deployment')->withMessage($message);
	}

	public function getEditStage($id = 0){
		$stage = $id ? DeploymentStage::find($id) : null;

		return view('deployment.stage_edit', [
			'stage' => $stage,
		]);
	}

	public function postCreateStage(Request $request){
		return $this->postEditStage($request);
	}

	public function getCreateStage(){
		return $this->getEditStage();
	}

	// stuff for actually running the deployment
	public function getStartDeployment($stage_id){
		$stage = DeploymentStage::find($stage_id);

		if(!$stage || $stage->status != 'Active') return redirect('deployment')->withError('Invalid Deployment Stage');

		$dep = new Deployment;
		$dep->status = 'Queued';
		$dep->deployment_stage_id = $stage->id;
		$dep->save();

		dispatch(new RunDeployment($deb))->onQueue('deployment');

		return redirect('deployment/view/' . $dep->id);
	}

	public function getView($id){
		$dep = Deployment::find($id);

		if(!$dep) return redirect('deployment')->withError('Invalid Deployment');

		return view('deployment.view', [
			'deb' => $deb
		]);
	}
}
