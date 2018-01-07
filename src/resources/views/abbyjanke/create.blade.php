@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
        <small>{{ trans('backpack::crud.add').' '.$crud->entity_name }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.add') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-9">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
		@endif

		@include('crud::inc.grouped_errors')

		  {!! Form::open(array('url' => $crud->route, 'method' => 'post', 'files'=>$crud->hasUploadFields('create'))) !!}
		  <div class="box">

		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
		    </div>
		    <div class="box-body row">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @include('blog::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create', 'position' => 'main' ])
		    </div><!-- /.box-body -->
		    <div class="box-footer">

		    </div><!-- /.box-footer-->

		  </div><!-- /.box -->
	</div>


  	<div class="col-md-3">
  		<!-- Default box -->
  		@if ($crud->hasAccess('list'))
  			<br><br>
  		@endif

  		  <div class="box">

  		    <div class="box-header with-border" style="padding-bottom:0;">
  		      @include('crud::inc.form_save_buttons')
  		    </div>
  		    <div class="box-body row">
  		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
  		      @include('blog::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create', 'position' => 'sidebar' ])
  		    </div><!-- /.box-body -->

  		  </div><!-- /.box -->
  		  {!! Form::close() !!}
  	</div>
</div>

@endsection
