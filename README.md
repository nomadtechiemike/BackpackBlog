# Backpack\Blog (AbbyJanke/Backpack-Blog)

A blogging package using the [Backpack\CRUD](https://github.com/Laravel-Backpack/crud) administration panel.

## Install

This package is currently in development and is not recommended for a production environment.

1. In your terminal:
```
composer require abbyjanke/backpackblog
```

2. Publish the config file & run migrations.
```
php artisan vendor:publish --provider="AbbyJanke\Blog\BlogServiceProvider" #publish config files, views, migrations, and seeds.
php artisan vendor:publish --provider="AbbyJanke\BackpackMeta\MetaServiceProvider" # publish config and migrations for AbbyJanke/Meta.
php artisan vendor:publish --tag=public #publish css styling and images
php artisan migrate #create the role and permission tables.
php artisan db:seed --class="AbbyJanke\Blog\Database\Seeds\AddBlogUserMetaFields" #adding biography, and website meta fields
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

## Change log

Coming Soon..

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

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues with this package, please email me@abbyjanke.com instead of using the issue tracker.
If you discover any security related issues with the Backpack core, please email hello@tabacitu.ro instead of using the issue tracker.

Please **[subscribe to the Backpack Newsletter](http://eepurl.com/bUEGjf)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.
