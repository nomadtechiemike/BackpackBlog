# Backpack\Blog (AbbyJanke/Backack-Blog)

A blogging package using the [Backpack\CRUD](https://github.com/Laravel-Backpack/crud) administration panel.

## Install

This package is currently in development and is not recommended for a production environment.

## Change log

Coming Soon..

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
