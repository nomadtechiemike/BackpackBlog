@extends('layouts.app')

@section('content')

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="{{ asset('vendor/abbyjanke/blog/blog.css') }}" rel="stylesheet">

  <div class="blog">
    @yield('blog_content')
  </div>


@endsection
