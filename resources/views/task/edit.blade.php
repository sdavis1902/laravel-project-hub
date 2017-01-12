@extends('layouts.panel')


@section('pagecss')
	<link href="{{ URL::asset('assets/plugins/dropzone/css/dropzone.css') }}" rel="stylesheet" type="text/css" media="screen"/>
@endsection

@section('pagejs')
	<script src="{{ URL::asset('assets/plugins/dropzone/dropzone.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/plugins/dropzone/dropzone.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/js/task.edit.js') }}" type="text/javascript"></script>
@endsection

@section('content')
	<div class="row">
        <div claass="col-lg-12">
			<h1 class="page-header">{{ $task ? 'Edit':'New' }} Task</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Task Details
				</div>
				<div class="panel-body">
					<div class="row">
						<form role="form" method="POST">
							<input type="hidden" name="_token" value="{!! csrf_token() !!}" />
							<input type="hidden" id="task-id" value="{{ isset( $task->id ) ? $task->id : 0 }}" />
							<div class="col-lg-12">
								<div class="form-group{{ $errors->has('name') ? ' has-error':'' }}">
									<label>Name</label>
									<input name="name" class="form-control" value="{{ old('name') ? old('name') : ($task) ? $task->name:''}}">
									@if( $errors->has('name') )
                                        @foreach( $errors->get('name') as $error )
                                            <p class="help-block">
                                                {{ $error }}
                                            </p>
                                        @endforeach
                                    @endif
								</div>
								<div class="form-group{{ $errors->has('state_id') ? ' has-error':'' }}">
									<label>Status</label>
									<select name="state_id" class="form-control">
										@foreach( $task_states as $state )
											<option{{ $task && $task->state_id == $state->id ? ' selected':'' }} value="{{ $state->id }}">{{ $state->name }}</option>
										@endforeach
									</select>
									@if( $errors->has('state_id') )
                                        @foreach( $errors->get('state_id') as $error )
                                            <p class="help-block">
                                                {{ $error }}
                                            </p>
                                        @endforeach
                                    @endif
								</div>
								<div class="form-group{{ $errors->has('project_id') ? ' has-error':'' }}">
									<label>Project</label>
									<select name="project_id" class="form-control">
										@foreach( $projects as $project )
											<option{{ $task && $task->project_id == $project->id ? ' selected':'' }} value="{{ $project->id }}">{{ $project->name }}</option>
										@endforeach
									</select>
									@if( $errors->has('project_id') )
                                        @foreach( $errors->get('project_id') as $error )
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
											<option{{ $task && $task->user_id == $user->id ? ' selected':'' }} value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
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
									<textarea name="description" class="form-control" rows="3">{{ old('description') ? old('description') : ($task) ? $task->description:''}}</textarea>
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
					<!-- /.row (nested) -->
                </div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
		@if( isset( $task->id ) )
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Attach Files
					</div>
					<div class="panel-body">
						<div class="grid-body no-border">
							<div class="row-fluid">
								<form action='{{ URL::to("task/file-upload/$task->id") }}' class="dropzone no-margin dz-clickable" id="real-dropzone">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="dz-message"></div>
									<div class="fallback"><input name="file" type="file" multiple /></div>
									<div class="dropzone-previews" id="dropzonePreview"></div>
								</form>
							</div>
							<br />
							<div class="row"><center><div>Drop files in box above to upload</div></center></div>
							<br />
							<div class="row"><center><div id='instruction'></div></center></div>
						</div>
						<div id="files-list">
							@include('task.files-upload-list')
						</div>
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		@endif

	</div>
	<!-- /.row -->
@endsection
