<?php namespace CleanSoft\Modules\Core\Providers;

use CleanSoft\Modules\Core\Http\Middleware\AdminBarMiddleware;
use CleanSoft\Modules\Core\Http\Middleware\BootstrapModuleMiddleware;
use CleanSoft\Modules\Core\Http\Middleware\ConstructionModeMiddleware;
use CleanSoft\Modules\Core\Http\Middleware\CorsMiddleware;
use CleanSoft\Modules\Core\Http\Middleware\DashboardLanguageMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        if (!is_admin_panel()) {
            $router->pushMiddlewareToGroup('web', ConstructionModeMiddleware::class);
            $router->pushMiddlewareToGroup('web', AdminBarMiddleware::class);
            $router->pushMiddlewareToGroup('api', CorsMiddleware::class);
        } else {
            $router->pushMiddlewareToGroup('web', DashboardLanguageMiddleware::class);
        }
    }
}
