@extends('blog::layout')

@section('masthead')
  <header class="masthead" style="background-image: url({{ asset('vendor/abbyjanke/blog/img/author-bg.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>{{ $author->name }}</h1>
            <span class="subheading">{{ $author->biography }}</span>
          </div>
        </div>
      </div>
    </div>
  </header>
@endsection

@include('blog::inc.list_articles')
