@extends('layouts.panel')

@section('content')
	<div class="row">
		<div class="pull-right" style="margin-top:40px;">
			<a href="{{ url('project/dashboard/'.$task->project->id) }}" class="btn btn-success">Back</a>
			<a href="{{ url('task/edit/'.$task->id) }}" class="btn btn-success">Edit</a>
		</div>
        <div claass="col-lg-12">
			<h1 class="page-header">{{ $task->name }}</h1>
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
                    <dl>
						<dt>Project</dt>
						<dd>{{ $task->project->name }}</dd>
					</dl>
					<dl>
						<dt>Assigned To</dt>
						<dd>{{ $task->user->first_name }} {{ $task->user->last_name }}</dd>
					</dl>
					<dl>
						<dt>Status</dt>
						<dd>{{ $task->state->name }}</dd>
					</dl>
					<dl>
						<dt>Due Date</dt>
						<dd>{{ $task->due_date }}</dd>
					</dl>
					<dl>
						<dt>Description</dt>
						<dd>{!! nl2br($task->description) !!}</dd>
					</dl>
					<dl>
						<dt>Files</dt>
						<dd>
							@foreach( $task->files as $file )
								<div class="row">
									<div class="col-md-4">
										<a target="_blank" href="{{ url($file->url) }}">{{ $file->name }}</a>
									</div>
									<div class="col-md-4">
										{{ $file->description }}
									</div>
								</div>
							@endforeach
						</dd>
					</dl>
				</div>
			</div>
        </div>
		<div class="col-lg-6">
			<div class="chat-panel panel panel-default">
                <div class="panel-heading">
					<i class="fa fa-comments fa-fw"></i> Comments
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<ul class="chat">
						@foreach( $task->comments as $comment )
							<li class="left clearfix">
								<span class="chat-img pull-left">
									<img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle">
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="primary-font">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</strong>
										<small class="pull-right text-muted">
											<i class="fa fa-clock-o fa-fw"></i> {{ $comment->created_at }}
										</small>
									</div>
									<p>
										{!! nl2br($comment->comment) !!}
									</p>
								</div>
							</li>
						@endforeach
					</ul>
				</div>
				<!-- /.panel-body -->
				<div class="panel-footer">
					<form role="form" method="POST">
						<input type="hidden" name="_token" value="{!! csrf_token() !!}" />
						<div class="input-group">
							<textarea class="form-control input-sm" name="comment"></textarea>
							<span class="input-group-btn">
								<button class="btn btn-warning btn-sm" id="btn-chat">
									Send
								</button>
							</span>
						</div>
					</form>
				</div>
				<!-- /.panel-footer -->
			</div>
		</div>
	</div>
@endsection
