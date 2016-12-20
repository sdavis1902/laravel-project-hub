@extends('layouts.panel')

@section('pagecss')
	<link href="{{ URL::asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{ URL::asset('assets/css/project.dashboard.css') }}" rel="stylesheet" type="text/css" media="screen"/>
@endsection

@section('pagejs')
    <script src="{{ URL::asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/js/project.dashboard.js') }}" type="text/javascript"></script>
@endsection

@section('content')
	<div class="row">
        <div claass="col-lg-12">
			<h1 class="page-header">{{ $project->name }}</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>

	<div class="row">
        <div claass="col-lg-12">
			@foreach( $states as $state )
				<div class="panel panel-default dashcontainer" style="width:{{ $width }}%">
					<div class="panel-heading">
						{{ $state->name }}
					</div>
					<div class="panel-body">
						<ul class="sortable connectedSortable" data-state-id="{{ $state->id }}">
							@foreach( $state->dash_tasks as $task )
								<li class="card" data-task-id="{{ $task->id }}">
									<div class="panel panel-default">
										<div class="panel-body">
											#{{ $task->id }} {{ $task->name }}<br />
										</div>
										<div class="panel-footer">
											<a href="{{ url('task/view/'.$task->id) }}">View</a>
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection
