@extends('layouts.nopanel')

@section('content')
		<div class="row login-container column-seperation">  
			<div class="col-md-5 col-md-offset-1">
				<h2></h2>
				<p>
				</p>
			</div>
			<div class="col-md-5 ">
				<br>
				<form id="login-form" class="login-form" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="row">
						<div class="form-group col-md-10">
							<label class="form-label">Email</label>
							<div class="controls">
								<div class="input-with-icon  right">                                       
									<i class=""></i>
									<input type="text" name="email" id="email" class="form-control">                                 
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10">
							<button class="btn btn-primary btn-cons pull-right" type="submit">Send Reminder</button>
						</div>
					</div>
				</form>
			</div>	
		</div>
@endsection
