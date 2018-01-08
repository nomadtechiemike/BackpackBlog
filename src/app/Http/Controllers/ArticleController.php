<?php namespace AbbyJanke\Blog\app\Http\Controllers;

use App\Http\Controllers\Controller;
use AbbyJanke\Blog\app\Models\Article;
use AbbyJanke\Blog\app\Models\Category;
use AbbyJanke\Blog\app\Models\Tag;

class ArticleController extends Controller
{

  public function index($type = null, $slug = null) {

    if($type == 'category') {
      $data['articles'] = Category::findBySlug($slug)->articles()->orderBy('created_at', 'desc')->simplePaginate(config('backpack.blog.list_size'));
    } elseif($type == 'tag') {
      $sort = Tag::findBySlug($slug);
    } else {
      $data['articles'] = Article::orderBy('created_at', 'desc')->simplePaginate(config('backpack.blog.list_size'));
    }

    $data['categories'] = Category::get();

    return view('blog::index', $data);
  }

}
