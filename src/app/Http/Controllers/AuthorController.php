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
     * Display the blog index page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $slug = null)
    {
        if ($type == 'category') {
            $this->data['articles'] = Category::findBySlug($slug)->articles()->orderBy('created_at', 'desc')->simplePaginate(config('backpack.blog.list_size'));
        } elseif ($type == 'tag') {
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
    public function show($id)
    {
        $this->data['author'] = User::find($id);
        $this->data['articles'] = Article::orderBy('created_at', 'desc')->where('author_id', $this->data['author']->id)->simplePaginate(config('backpack.blog.list_size'));

        return view('blog::author', $this->data);
    }
}
