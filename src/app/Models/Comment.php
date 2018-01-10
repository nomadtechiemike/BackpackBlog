<?php

namespace AbbyJanke\Blog\app\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = ['article_id', 'comment', 'parent_id', 'approved',
      'author_name', 'author_email', 'author_id', 'author_url', 'author_ip',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

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
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include approved comments
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', 1);
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

}
