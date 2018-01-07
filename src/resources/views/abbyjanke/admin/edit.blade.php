@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
        <small>{{ trans('backpack::crud.edit').' '.$crud->entity_name }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
  {!! Form::open(array('url' => $crud->route.'/'.$entry->getKey(), 'method' => 'put', 'files'=>$crud->hasUploadFields('update', $entry->getKey()))) !!}
	<div class="col-md-9">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
		@endif

		@include('crud::inc.grouped_errors')

		  <div class="box">
		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
		    </div>
		    <div class="box-body row">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @include('blog::admin.inc.show_fields', ['fields' => $fields, 'position' => 'main'])
		    </div><!-- /.box-body -->
		  </div><!-- /.box -->

	</div>
	<div class="col-md-3">
		<!-- Default box -->
		@include('crud::inc.grouped_errors')
			<br /><br />
			<div class="box">
				<div class="box-header with-border" style="padding-bottom: 0;">
					@include('crud::inc.form_save_buttons')
				</div>
				<div class="box-body row">
					<!-- load the view from the application if it exists, otherwise load the one in the package -->
					@include('blog::admin.form_content', [ 'fields' => $fields, 'action' => 'create', 'position' => 'sidebar' ])
				</div><!-- /.box-body -->
			</div><!-- /.box -->

	</div>
	{!! Form::close() !!}
</div>

@endsection
