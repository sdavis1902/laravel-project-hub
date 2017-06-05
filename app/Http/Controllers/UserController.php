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
use Illuminate\Validation\Rule;

use App\Models\User;

class UserController extends Controller {
	public function getIndex(){
		$users = User::get();

		return view('user.index', [
			'users' => $users
		]);
	}

	public function postEdit(Request $request, $id = 0){
		if( env('DEMO') ) return redirect('user')->withMessage('Updating users is disabled on demo site');

		$rules = [
            'first_name' => 'required',
            'last_name'  => 'required',
			'email' => [
                'required',
				'email',
                Rule::unique('users')->where(function($q) use ($id){
                    if($id) $q->where('id', '<>', $id);
                })
            ],
            'password'   => (!$id ? 'required|' : '') . 'between:8,24|confirmed'
        ];
        $v = Validator::make($request->all(), $rules);

        if( $v->fails() ){
            return redirect('user/'. ( $id ? "edit/$id" : 'create' ))->withErrors($v)->withInput();
        }

	    $credentials = [
			'email'    => $request->input('email'),
			'password' => $request->input('password')
		];

        if( $id ){
            $user = User::find($id);
            if( !$user ) return redirect('user')->withMessage('Could not find user with the provided id');
			$user = Sentinel::update($user, $credentials);
        }else{
			$user = Sentinel::registerAndActivate($credentials);
        }

		$user->first_name = $request->input('first_name');
		$user->last_name  = $request->input('last_name');
        $user->save();

        $message = $id ? 'User has been updated' : 'User has been created';
        return redirect('user')->withMessage($message);
	}

	public function getEdit(Request $request, $id = 0){
		$user = $id ? User::find($id) : null;

		if($id && !$user) return redirect('user')->withMessage('Could not find user');

		return view('user.edit', [
			'user' => $user
		]);
	}

	public function postCreate(Request $request){
		return $this->postEdit($request, 0);
	}

	public function getCreate(Request $request){
		return $this->getEdit($request, 0);
	}

	public function getDelete($id){
		if( env('DEMO') ) return redirect('user')->withMessage('User delete is disabled on demo site');

		$user = User::find($id);

		if(!$user) return redirect('user')->withError('Could not find user');
		$user->delete();

		return redirect('user')->withMessage('User has been removed');
	}
}
