@extends('layouts.panel')

@section('pagecss')
	<!-- DataTables CSS -->
    <link href="{{ url('assets/plugins/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{ url('assets/plugins/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
@endsection

@section('pagejs')
	<!-- DataTables JavaScript -->
    <script src="{{ url('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ url('assets/js/task.index.js') }}"></script>
@endsection

@section('content')
	<div class="row">
        <div class="col-lg-12">
			<h1 class="page-header">Tasks List for {{ $project->name }}</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="datatables-tasks">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Status</th>
								<th>Assigned To</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($project->tasks as $task)
								<tr class="odd gradeX">
									<td><a href="{{ url('task/edit/'.$task->id) }}">{{ $task->id }}</a></td>
									<td>{{ $task->name }}</td>
									<td>{{ $task->state->name }}</td>
									<td>{{ $task->user->last_name }}, {{ $task->user->first_name }}</td>
									<td><a href="{{ url('task/view/'.$task->id) }}">View</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
@endsection
