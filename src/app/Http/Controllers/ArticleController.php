<?php namespace AbbyJanke\Blog\app\Http\Controllers;

use App\Http\Controllers\Controller;
use AbbyJanke\Blog\app\Models\Article;
use AbbyJanke\Blog\app\Models\Category;
use AbbyJanke\Blog\app\Models\Tag;

class ArticleController extends Controller
{

  private $data = [];

  public function __construct() {
    $this->data['categories'] = Category::get();
  }

  /**
   * Display the blog index page.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index($type = null, $slug = null) {

    if($type == 'category') {
      $this->data['articles'] = Category::findBySlug($slug)->articles()->orderBy('created_at', 'desc')->simplePaginate(config('backpack.blog.list_size'));
    } elseif($type == 'tag') {
      $this->data['articles'] = Tag::findBySlug($slug)->articles()->orderBy('created_at', 'desc')->simplePaginate(config('backpack.blog.list_size'));
    } else {
      $this->data['articles'] = Article::orderBy('created_at', 'desc')->simplePaginate(config('backpack.blog.list_size'));
    }

    return view('blog::index', $this->data);
  }

  /**
   * Display a blog article page.
   *
   * @param $slug
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
   public function show($slug) {
     $this->data['article'] = Article::where('slug', $slug)->firstOrFail();

     if(! $this->data['article']) {
       return redirect()->route('blog.index');
     }

     return view('blog::post', $this->data);
   }

}
