<?php namespace AbbyJanke\Blog\app\Http\Controllers;

use App\Http\Controllers\Controller;

use App\User;
use AbbyJanke\Blog\app\Models\Article;
use AbbyJanke\Blog\app\Models\Category;

class AuthorController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data['categories'] = Category::get();
    }

    /**
     * Display a blog article page.
     *
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->data['author'] = User::findBySlug($slug);

        if(!$this->data['author']) {
          abort(404);
        }

        $this->data['articles'] = Article::orderBy('created_at', 'desc')->where('author_id', $this->data['author']->id)->simplePaginate(config('backpack.blog.list_size'));

        return view('blog::author', $this->data);
    }
}
