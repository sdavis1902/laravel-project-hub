@extends('layouts.nopanel')

@section('content')
		<div class="row login-container column-seperation">  
			<div class="col-md-5 col-md-offset-1">
				<img src="{{ URL::asset('assets/img/logo-nri.png') }}" />
				<h2>Inventory</h2>
				<p>
                    Please enter your email address.  If a matching account is found, you will be send an email with instructions on resetting your password.
				</p>
			</div>
			<div class="col-md-5 ">
				<br>
				<form id="login-form" class="login-form" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" name="code" value="{{ $code }}" />
					<input type="hidden" name="userid" value="{{ $userid }}" />
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <div class="input-with-icon  right {{ $errors->has('new_password') ? 'error-control':'' }}">
                            <i class=""></i>
                            <input type="password" name="new_password" id="new_password" class="form-control">
                            @if( $errors->has('new_password') )
                                @foreach( $errors->get('new_password') as $error )
                                    <span class="error">
                                        <label for="new_password" class="error">{{ $error }}</label>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <div class="input-with-icon  right {{ $errors->has('new_password_confirmation') ? 'error-control':'' }}">
                            <i class=""></i>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                            @if( $errors->has('new_password_confirmation') )
                                @foreach( $errors->get('new_password_confirmation') as $error )
                                    <span class="error">
                                        <label for="new_password_confirmation" class="error">{{ $error }}</label>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                      </div>
					<div class="row">
						<div class="col-md-10">
							<button class="btn btn-primary btn-cons pull-right" type="submit">Reset Password</button>
						</div>
					</div>
				</form>
			</div>	
		</div>
@endsection
