<?php namespace CleanSoft\Modules\Core\Providers;

use CleanSoft\Modules\Core\Exceptions\Handler;
use CleanSoft\Modules\Core\Facades\SeoFacade;
use CleanSoft\Modules\Core\Http\Middleware\StartSessionMiddleware;
use CleanSoft\Modules\Core\Support\Helper;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Load helpers
        Helper::loadModuleHelpers(__DIR__);
        //Load helpers
        //load_module_helpers(__DIR__);
        $this->app->singleton(ExceptionHandler::class, Handler::class);
        //Register related facades
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
        $loader->alias('Seo', SeoFacade::class);
        //Merge configs
        $configs = split_files_with_basename($this->app['files']->glob(__DIR__ . '/../../config/*.php'));
        foreach ($configs as $key => $row) {
            $this->mergeConfigFrom($row, $key);
        }
        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', StartSessionMiddleware::class);
        /**
         * Other packages
         */
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        /**
         * Base providers
         */
        $this->app->register(HookServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ValidateServiceProvider::class);
        $this->app->register(ComposerServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(CollectiveServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);
        /**
         * Other module providers
         */
        $this->app->register(\CleanSoft\Modules\Core\Shortcode\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\Caching\Providers\ModuleProvider::class);
        //$this->app->register(\CleanSoft\Modules\Core\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\ModulesManagement\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\AssetsManagement\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\Hook\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\Menu\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\Settings\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\ThemesManagement\Providers\ModuleProvider::class);
        $this->app->register(\CleanSoft\Modules\Core\Users\Providers\ModuleProvider::class);
        foreach (config('webed.external_core', []) as $item) {
            $this->app->register($item);
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'webed-core');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'webed-core');
        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/webed-core',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/webed-core'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('assets'),
        ], 'webed-assets');
        $this->publishes([
            __DIR__ . '/../../resources/root' => base_path(),
            __DIR__ . '/../../resources/public' => public_path(),
        ], 'webed-public-assets');
    }
}
