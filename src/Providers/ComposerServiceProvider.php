<?php namespace CleanSoft\Modules\Core\Providers;

use CleanSoft\Modules\Core\Http\ViewComposers\AdminBreadcrumbsViewComposer;
use CleanSoft\Modules\Core\Http\ViewComposers\BasePartialsViewComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'webed-core::admin._partials.breadcrumbs',
        ], AdminBreadcrumbsViewComposer::class);
        view()->composer([
            'webed-core::front._admin-bar',
            'webed-core::admin._partials.header',
            'webed-core::admin._partials.sidebar',
        ], BasePartialsViewComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
