<?php

namespace AbbyJanke\Blog;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    protected $commands = [
        \AbbyJanke\Blog\app\Console\Commands\BlogUpdatev2::class,
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/backpack/blog.php';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

        // publish config file
        $this->publishes([__DIR__.'/config' => config_path()], 'config');

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__.'/config/backpack/blog.php',
            'backpack.blog'
        );

        // define the routes for the application
        $this->setupRoutes($this->app->router);

        // - first the published/overwritten views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/vendor/abbyjanke/backpack/blog'), 'blog');
        $this->loadViewsFrom(resource_path('views/vendor/backpack/crud'), 'crud');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/abbyjanke'), 'blog');
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/backpack/crud'), 'crud');

        // publish public assets
        $this->publishes([__DIR__.'/public' => public_path('vendor/abbyjanke')], 'public');

        // publish views
        $this->publishes([__DIR__.'/resources/views/abbyjanke' => resource_path('views/vendor/abbyjanke/backpack/blog')], 'views');
        $this->publishes([__DIR__.'/resources/views/backpack/crud' => resource_path('views/vendor/backpack/crud')], 'views');

        // load migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;
        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }
        $this->loadRoutesFrom($routeFilePathInUse);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
