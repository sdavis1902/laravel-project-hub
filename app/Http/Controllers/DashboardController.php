<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Validator;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Reminder;
use Mail;

class DashboardController extends Controller {

	public function getIndex(){
		return view('dashboard.index');
	}
}
