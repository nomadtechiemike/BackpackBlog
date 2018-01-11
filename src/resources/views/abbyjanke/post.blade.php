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

      <form class="form-horizontal" method="POST" action="{{ route('blog.post', ['slug' => $article->slug]) }}">

        {{ csrf_field() }}

        <div class="form-group">
          <textarea class="form-control" name="comment" placeholder="Comment" rows="3" required>{{ old('comment')}}</textarea>
        </div>

        @guest
          <div class="form-group">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Your Name *" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address *" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="website" value="{{ old('website') }}" placeholder="Website" required>
          </div>
        @else
          <div class="form-group">
            <input type="hidden" class="form-control" name="author_id" value="{{ Auth::user()->id }}" required>
          </div>
        @endguest

          <div class="form-group">
             <input type="hidden" class="form-control" id="replying_to" name="replying_to" value="" required>
          </div>

        <button type="submit" class="btn btn-primary float-right">Post Comment</button>

      </form>
    </div>
  </div>

</div>
@endsection

@section('after_scripts')

  <script>
  (function($) {
    "use strict";
    $("#replyTo").click(function(e) {
      e.preventDefault();
      var commentId = $("#replyTo").attr("commentId");
      $("#replying_to").val(commentId);
    });
  })(jQuery);
  </script>

@endsection
