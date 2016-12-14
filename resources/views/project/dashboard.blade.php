@extends('layouts.panel')

@section('pagecss')
	<link href="{{ URL::asset('assets/plugins/jquery-gridster/jquery.gridster.min.css') }}" rel="stylesheet" type="text/css" media="screen"/>
@endsection

@section('pagejs')
	<script src="{{ URL::asset('assets/plugins/jquery-gridster/jquery.gridster.min.js') }}" type="text/javascript"></script> 
    <script src="{{ URL::asset('assets/js/project.dashboard.js') }}" type="text/javascript"></script>
@endsection

@section('content')
	<div id="container">
        <div class="gridster">
            <ul style="list-style: none;">
                @foreach( $grids as $grid )
                    <li data-row="{{ $grid->row }}" data-col="{{ $grid->col }}" data-sizex="{{ $grid->width }}" data-sizey="{{ $grid->height }}" id="{{ $grid->key }}">
                        @include('dashboard.snippets.' . $grid->key)
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
