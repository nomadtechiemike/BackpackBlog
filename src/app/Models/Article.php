<?php

namespace AbbyJanke\Blog\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use \Carbon\Carbon;

class Article extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'slug', 'content', 'author_id', 'featured_image', 'featured_video'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    // cut the content down to a brief summary.
    public function getSummaryAttribute()
    {
      return str_limit(strip_tags($this->content), 150);
    }

    // Allow the option to have a cleaner text display the published date rather then just a date.
    public function getPublishedAttribute()
    {

      // less then 10 hours
      if(Carbon::parse($this->created_at) > Carbon::now()->subHours(10)) {
        return Carbon::parse($this->created_at)->diffForHumans();
      }

      // posted today
      if(Carbon::parse($this->created_at)->day == Carbon::now()->day) {
        return 'today at' . Carbon::parse($this->created_at)->format('h:i A');
      }

      return 'on ' . Carbon::parse($this->created_at)->format('F dS Y h:i A');
    }

    /*
    |
    | FUNCTIONS
    |
    */
    public function tagList() {
      $list = null;

      foreach ($this->tags as $tag)
      {
          $list .= $tag->slug.',';
      }

      $list = rtrim($list, ',');

      return $list;

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // get the author.
    public function author()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }

    // get the author.
    public function authors()
    {
        return $this->belongsToMany('App\User', 'article_authors', 'article_id', 'author_id');
    }

    // get the assigned categories.
    public function categories()
    {
        return $this->belongsToMany('AbbyJanke\Blog\app\Models\Category', 'article_categories');
    }

    // get the assigned tags.
    public function tags()
    {
        return $this->belongsToMany('AbbyJanke\Blog\app\Models\Tag', 'article_tags');
    }

    // get the comments.
    public function comments()
    {
        return $this->hasMany('AbbyJanke\Blog\app\Models\Comment');
    }

    // get the comments.
    public function commentsApproved()
    {
        return $this->hasMany('AbbyJanke\Blog\app\Models\Comment')->approved();
    }

    // get the comments.
    public function commentsApprovedParent()
    {
        return $this->hasMany('AbbyJanke\Blog\app\Models\Comment')->approved()->parent();
    }

    // get the comments.
    public function commentsApprovedChild($parentId)
    {
        return $this->hasMany('AbbyJanke\Blog\app\Models\Comment')->approved()->child($parentId);
    }
}
