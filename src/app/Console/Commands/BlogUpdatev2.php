<?php

namespace AbbyJanke\Blog\app\Console\Commands;

use Illuminate\Console\Command;
use AbbyJanke\Blog\app\Models\Article;

class BlogUpdatev2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:update2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade Backpack Blog from 1.0 to 2.0';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = Article::get();

        foreach($articles as $article) {
          $article->author()->attach($article->author_id);
        }
    }
}
