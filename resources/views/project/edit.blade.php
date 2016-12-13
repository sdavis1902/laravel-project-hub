@extends('layouts.panel')

@section('content')
	<div class="row">
        <div claass="col-lg-12">
			<h1 class="page-header">{{ $project ? 'Edit':'New' }} Project</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Project Details
				</div>
				<div class="panel-body">
					<div class="row">
						<form role="form" method="POST">
							<input type="hidden" name="_token" value="{!! csrf_token() !!}" />
							<div class="col-lg-12">
								<div class="form-group{{ $errors->has('name') ? ' has-error':'' }}">
									<label>Name</label>
									<input name="name" class="form-control">
									@if( $errors->has('name') )
                                        @foreach( $errors->get('name') as $error )
                                            <p class="help-block">
                                                {{ $error }}
                                            </p>
                                        @endforeach
                                    @endif
								</div>
								<div class="form-group{{ $errors->has('status') ? ' has-error':'' }}">
									<label>Status</label>
									<select name="status" class="form-control">
										@foreach( $statuses as $status )
											<option{{ $project && $project->status == $status ? ' selected':'' }} value="{{ $status }}">{{ $status }}</option>
										@endforeach
									</select>
									@if( $errors->has('status') )
                                        @foreach( $errors->get('status') as $error )
                                            <p class="help-block">
                                                {{ $error }}
                                            </p>
                                        @endforeach
                                    @endif
								</div>
								<div class="form-group{{ $errors->has('user_id') ? ' has-error':'' }}">
									<label>Assigned To</label>
									<select name="user_id" class="form-control">
										@foreach( $users as $user )
											<option{{ $project && $project->user_id == $user->id ? ' selected':'' }} value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
										@endforeach
									</select>
									@if( $errors->has('user_id') )
                                        @foreach( $errors->get('user_id') as $error )
                                            <p class="help-block">
                                                {{ $error }}
                                            </p>
                                        @endforeach
                                    @endif
								</div>
								<div class="form-group{{ $errors->has('description') ? ' has-error':'' }}">
									<label>Description</label>
									<textarea name="description" class="form-control" rows="3"></textarea>
									@if( $errors->has('description') )
                                        @foreach( $errors->get('description') as $error )
                                            <p class="help-block">
                                                {{ $error }}
                                            </p>
                                        @endforeach
                                    @endif
								</div>
								<button type="submit" class="btn btn-default">Save</button>
							</div>
						</form>
						<!-- /.col-lg-6 (nested) -->
					</div>
					<!-- /.row (nested) -->                        </div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
@endsection
