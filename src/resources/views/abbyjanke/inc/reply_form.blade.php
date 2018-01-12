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
