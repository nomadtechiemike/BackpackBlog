@extends('blog::layout')

@section('masthead')
<header class="masthead" style="background-color: #f4645f; background-image: url({{ $article->featured_image }})">
  @if($article->featured_image)<div class="overlay"></div>@endif
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="post-heading">
          <h1>{{ $article->title }}</h1>
          <span class="meta">Posted by
              <a href="#">{{ $article->author->name }}</a>
              {{ $article->published }}</span>
        </div>
      </div>
    </div>
  </div>
</header>
@endsection

@section('content')
<article>
  {!! $article->content !!}
</article>

<hr />
@endsection
