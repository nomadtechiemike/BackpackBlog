@extends('blog::layout')

@section('blog_content')

<div class="container">
    <div class="row">
        <div class="col-md-9">
          <div class="panel panel-default">
              <div class="panel-body">
                @if(!count($articles))
                    <h2 class="post-title text-center">Sorry, but nothing matched your search.</h2>
                @endif

                <ul class="posts">
                @foreach($articles as $article)
                    <li class="post-preview">
                      <a href="post.html">
                        <h2 class="post-title">
                          {{ $article->title }}
                        </h2>
                        <h3 class="post-subtitle">
                          {{ $article->summary }}
                        </h3>
                      </a>
                      <p class="post-meta">Posted by
                        <a href="#">{{ $article->author->name }}</a> {{ $article->published }}</p>
                    </li>
                  @endforeach
                </ul>
              </div>
          </div>

            <div class="pagination-wrapper col-md-12 text-center">
                {{ $articles->links() }}
            </div>
        </div>

        <div class="col-md-3">
          ..
        </div>
    </div>
</div>
@endsection
