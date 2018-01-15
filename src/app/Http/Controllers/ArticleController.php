<?php namespace AbbyJanke\Blog\app\Http\Controllers;

use App\Http\Controllers\Controller;

use AbbyJanke\Blog\app\Models\Article;
use AbbyJanke\Blog\app\Models\Category;
use AbbyJanke\Blog\app\Models\Tag;
use AbbyJanke\Blog\app\Models\Comment;


use Validator;
use \App\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
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
    public function show($slug)
    {
        $this->data['article'] = Article::where('slug', $slug)->firstOrFail();

        return view('blog::post', $this->data);
    }

    /**
     * Save a new comment for an article
     *
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveComment(Request $request, $slug)
    {

        $article = Article::where('slug', $slug)->firstOrFail();

        $userModel = new User;

        $comment = new Comment;
        $comment->article_id = $article->id;

        $validator = Validator::make($request->all(), [
          'comment' => 'required|min:5',
          'name' => 'required_without:author_id',
          'email' => 'required_without:author_id',
          'author_id' => 'required_without:name,email|integer|exists:'.$userModel->getTable().',id',
          'website' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->has('replying_to')) {
          $comment->parent_id = $request->get('replying_to');
        }

        if($request->has('author_id')) {
          $user = User::find($request->get('author_id'));
          $request->merge([
            'name' => $user->name,
            'email' => $user->email,
          ]);
          $comment->author_id = $user->id;
        }

        if( \Akismet::validateKey() ) {
          $markSpam = false;
          \Akismet::setCommentAuthor($request->get('name'))
                        ->setCommentAuthorEmail($request->get('email'))
                        ->setCommentContent($request->get('comment'))
                        ->setCommentType('comment')
                        ->setIsTest(config('backpack.blog.akismetTest'));
          if($request->has('website')) {
            \Akismet::setCommentAuthorUrl("https://www.google.com");
          }

          if(\Akismet::isSpam()) {
            $markSpam = true;
          }

        } else {
          $markSpam = true;
        }

        $akismetData = \Akismet::toArray();

        $comment->author_name = $request->get('name');
        $comment->author_email = $request->get('email');
        $comment->author_url = $request->get('url');
        $comment->author_ip = $akismetData['user_ip'];
        $comment->comment = $request->get('comment');

        if(config('backpack.blog.autoapprove') && !$markSpam) {
          $comment->approved = true;
        }

        $comment->save();

        return redirect()->back();
    }
}
