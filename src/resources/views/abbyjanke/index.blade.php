@extends('blog::layout')

@section('masthead')
  <header class="masthead" style="background-image: url({{ asset('vendor/abbyjanke/blog/img/home-bg.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>{{ config('app.name', 'Laravel') }}</h1>
            <span class="subheading">Backpack Blogging Package</span>
          </div>
        </div>
      </div>
    </div>
  </header>
@endsection

@section('content')

  @if(!count($articles))<h2 class="post-title text-center">Sorry, but nothing matched your search.</h2> @endif

  <?php $i = 0; ?>
  @foreach($articles as $article)
    <?php $i++; ?>
    <div class="post-preview">
      <a href="{{ route('blog.post', ['slug' => $article->slug ]) }}">
        <h2 class="post-title">{{ $article->title }}</h2>
        <h3 class="post-subtitle">{{ $article->summary }}</h3>
      </a>
      <p class="post-meta">Posted by
        <a href="#">{{ $article->author->name }}</a> {{ $article->published }}</p>
    </div>
    @if(count($articles) !== $i)
      <hr>
    @endif
  @endforeach

  <div class="clearfix">
    @if($articles->previousPageUrl())
      <a class="btn btn-primary float-left" href="{{ $articles->previousPageUrl() }}">&larr; Newer Posts</a>
    @endif
    @if($articles->nextPageUrl())
      <a class="btn btn-primary float-right" href="{{ $articles->nextPageUrl() }}">Older Posts &rarr;</a>
    @endif
  </div>

@endsection
