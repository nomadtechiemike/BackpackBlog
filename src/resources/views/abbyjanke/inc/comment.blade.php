@if($comment->parent_id)
    <div class="childComment" style="margin-left: 50px">
@endif

@if($comment->author_id)
  {{-- Dynamically update the user's name author_id is present --}}
  <div class="comment">
    <div class="comment-header d-flex justify-content-between">
      <div class="user d-flex align-items-center" >
        <div class="image"><img src="{{ backpack_avatar_url($comment->author) }}" alt="..." class="img-fluid rounded-circle"></div>
        <div class="title"><strong>{{ $comment->author->name }}</strong><span class="date">{{ $comment->published }}</span></div>
      </div>
    </div>
    <div class="comment-body">
      <p>{{ $comment->comment }}</p>
      @if(!$comment->parent_id) <p><a href="#" id="replyTo" commentId="{{$comment->id}}">Reply</a><p> @endif
    </div>
  </div>
@else
  {{-- No author_id so use the saved data --}}
  <div class="comment">
    <div class="comment-header d-flex justify-content-between">
      <div class="user d-flex align-items-center">
        <div class="image"><img src="{{ \Gravatar::get($comment->author_email) }}" alt="..." class="img-fluid rounded-circle"></div>
        <div class="title"><strong>{{ $comment->author_name }}</strong><span class="date">{{ $comment->published }}</span></div>
      </div>
    </div>
    <div class="comment-body">
      <p>{{ $comment->comment }}</p>
      @if(!$comment->parent_id) <p><a href="#" id="replyTo" commentId="{{$comment->id}}">Reply</a><p> @endif
    </div>
  </div>
@endif

@if($comment->parent_id)
  </div>
@endif
