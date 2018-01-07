<?php namespace AbbyJanke\Blog\app\Http\Controllers;

use App\Http\Controllers\Controller;
use AbbyJanke\Blog\app\Models\Article;

class ArticleController extends Controller
{

  public function index() {
    $articles = Article::orderBy('created_at', 'desc')->simplePaginate(10);

    return view('blog::index', ['articles' => $articles]);
  }

}
