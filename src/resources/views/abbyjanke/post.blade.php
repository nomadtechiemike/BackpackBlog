@extends('blog::layout')

@section('secondaryTItle')
- {{ $article->title }}
@endsection

@section('seo_tags')
  <!-- SEO Tags -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="{{ $article->tagList() }}">
  <meta name="author" content="{{ $article->author->name }}">
  <meta name="description" content="{{ $article->summary }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Facebook Open Graph Tags -->
  <meta property="og:title" content="{{ $article->title }}">
  @if($article->featured_image)
    <meta property="og:image" content="{{ $article->featured_image }}">
    <meta property="og:image:width" content="800">
  @endif
  @if($article->featured_video)
    <meta property="og:video" content="{{ $article->featured_video }}" />
    <meta property="og:video:width" content="800">
  @endif

  <meta property="og:description" content="{{ $article->summary }}">
  <meta name="og:type" content="blog">
  <meta name="og:site_name" content="{{ config('app.name', 'Laravel') }}">

  <!-- Twitter Cards -->
  <meta name="twitter:title" content="{{ $article->title }}">
  <meta name="twitter:description" content="{{ $article->summary }}">
  @if($article->featured_image)
    <meta name="twitter:image" content="https://demo.cnvs.io/vendor/canvas/assets/images/mocha.jpg">
  @endif
  @if($article->featured_video)
    <meta name="twitter:player:stream" content="{{ $article->featured_video }}">
  @endif

@endsection

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

<div class="post-comments">
  <header>
    <h3>Comments<span class="no-of-comments">({{ $article->commentsApproved->count() }})</span></h3>
  </header>
  @foreach($article->commentsApprovedParent as $comment)
    @include('blog::inc.comment')

    @foreach($article->commentsApprovedChild($comment->id)->get() as $comment)
      @include('blog::inc.comment')
    @endforeach
  @endforeach

  <div class="comment add-comment">
    <div class="comment-header d-flex justify-content-between">
      <div class="user" style="margin-left:58px">
        <label>Leave A Reply</label><br />
        @auth
          <p>Logged in as {{ Auth::user()->name }}.</p>
        @else
          <p>Your email address will not be published. Required fields are marked *</p>
        @endauth
      </div>
    </div>
    <div class="comment-body">

      @include('blog::inc.reply_form')

    </div>
  </div>

</div>
@endsection
