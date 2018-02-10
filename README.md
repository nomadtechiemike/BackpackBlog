# Backpack\Blog (AbbyJanke/BackpackBlog)

A complete open-source blogging package for use with the [Backpack\CRUD](https://github.com/Laravel-Backpack/crud) administration panel.

## Install

1. In your terminal:
```
composer require abbyjanke/backpackblog
```

2. Publish the config file & run migrations.
```
php artisan vendor:publish --provider="AbbyJanke\Blog\BlogServiceProvider" #publish config files, views, migrations, and seeds.
php artisan vendor:publish --provider="AbbyJanke\BackpackMeta\MetaServiceProvider" # publish config and migrations for AbbyJanke/Meta.
php artisan vendor:publish --provider="AbbyJanke\Blog\BlogServiceProvider" --tag=public #publish css styling and images
php artisan vendor:publish --provider="nickurt\Akismet\ServiceProvider" --tag="config" #publish the akismet package
php artisan migrate #create the necessary tables
```

3. We need to add some configuration to your `.env` file for Akismet. If you don't already have an API Key for Akismet get one at: [Akismet.com](https://akismet.com/)

```
AKISMET_APIKEY=MY_UNIQUE_APIKEY
AKISMET_BLOGURL=https://yourapplication.dev
```

4.[optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php:
```
<li class="treeview">
  <!-- AbbyJanke/Blog -->
  <a href="#"><i class="fa fa-newspaper-o"></i> <span>Blog</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href="{{ backpack_url('blog/article') }}"><i class="fa fa-newspaper-o"></i> <span>Articles</span></a></li>
    <li><a href="{{ backpack_url('blog/comment') }}"><i class="fa fa-comments-o"></i> <span>Comment</span></a></li>
    <li><a href="{{ backpack_url('blog/category') }}"><i class="fa fa-list"></i> <span>Categories</span></a></li>
    <li><a href="{{ backpack_url('blog/tag') }}"><i class="fa fa-tags"></i> <span>Tags</span></a></li>
  </ul>
</li>

<!-- AbbyJanke/Meta -->
<li><a href="{{ backpack_url('meta') }}"><i class="fa fa-plus-square"></i> <span>Model Meta Options</span></a></li>
```

5. We use the user's name for a slug to display their profile so we need to include EloquentSluggable and a few functions into our User Model.

```
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class User extends Authenticatable
{
    use Sluggable, SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'name' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->name != '') {
            return $this->name;
        }
        return str_slug($this->name);
    }

    // convert name to slug
    public function getSlugAttribute() {
      return str_slug($this->name);
    }
}
```

## Optional Installation Steps

### Author URL/Biography Fields

1. We are using the [AbbyJanke\BackpackMeta](https://github.com/AbbyJanke\BackpackMeta) package to create additional fields without having to modify the user's table. Add the following to your User's Model:

```
use AbbyJanke\BackpackMeta\ModelTraits\Meta as MetaTrait; // This..

class User extends Authenticatable
{
    use Notifiable;
    use MetaTrait; // This too..

```

2. Run the database seeder.
```
$ php artisan db:seed --class="AbbyJanke\Blog\Database\Seeds\AddBlogUserMetaFields" #adding biography, and website meta fields
```

3. [Optional] Adding the fields to the user's account page within backpack. In your `resources/views/vendor/backpack/base/auth/account/update_info.blade.php` file add these lines after your last field currently there:
```
@foreach(Auth::user()->getMetaOptions() as $option)
  <div class="form-group">
      <label class="required">{{ $option->display }}</label>
      <input class="form-control" type="textarea" name="{{ $option->key }}" value="{{ old($option->key) ? old($option->key) : $user->{$option->key} }}">
  </div>
@endforeach
```


## Change log

#### 2.0 [Upgrade Guide](https://github.com/AbbyJanke/BackpackBlog/wiki/Upgrade-from-v1-to-v2)
- Multiple Authors

## Upcoming Feaures

- Tests
- Easy Buttons To Approve & Report Spam/HAM
- Comment Filters
- Auto-publish to social media
- Installation wizard
- Newsletter subscription system
- Permission check (using backpack/permissionmanager)

## Overwriting functionality

If you need to modify how this works in a project:
- create a ```routes/backpack/blog.php``` file; the package will see that, and load _your_ routes file, instead of the one in the package;
- create controllers/models that extend the ones in the package, and use those in your new routes file;
- modify anything you'd like in the new controllers/models;

## Security

If you discover any security related issues with this package, please email me@abbyjanke.com instead of using the issue tracker.
If you discover any security related issues with the Backpack core, please email hello@tabacitu.ro instead of using the issue tracker.

Please **[subscribe to the Backpack Newsletter](http://eepurl.com/bUEGjf)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.
