@extends('layouts.nopanel')

@section('content')
	@if( $new )
		<div class="row">
			There are no users yet, whatever credentials you input will be used to create the first user and log you in as them.
		</div>
	@endif
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Please Sign In</h3>
				</div>
				<div class="panel-body">
					<form role="form" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<!-- Change this to a button or input when using this as a form -->
							<button type="submit" class="btn btn-lg btn-success btn-block">Login</a>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
