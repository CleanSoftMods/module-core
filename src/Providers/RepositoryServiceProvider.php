<?php namespace CleanSoft\Modules\Core\Providers;

use CleanSoft\Modules\Core\Models\ViewTracker;
use CleanSoft\Modules\Core\Repositories\Contracts\ViewTrackerRepositoryContract;
use CleanSoft\Modules\Core\Repositories\ViewTrackerRepository;
use CleanSoft\Modules\Core\Repositories\ViewTrackerRepositoryCacheDecorator;


use CleanSoft\Modules\Core\ACL\Models\Permission;
use CleanSoft\Modules\Core\ACL\Models\Role;
use CleanSoft\Modules\Core\ACL\Repositories\Contracts\PermissionRepositoryContract;
use CleanSoft\Modules\Core\ACL\Repositories\Contracts\RoleRepositoryContract;
use CleanSoft\Modules\Core\ACL\Repositories\PermissionRepository;
use CleanSoft\Modules\Core\ACL\Repositories\PermissionRepositoryCacheDecorator;
use CleanSoft\Modules\Core\ACL\Repositories\RoleRepository;
use CleanSoft\Modules\Core\ACL\Repositories\RoleRepositoryCacheDecorator;


use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ViewTrackerRepositoryContract::class, function () {
            $repository = new ViewTrackerRepository(new ViewTracker());
            if (config('webed-caching.repository.enabled')) {
                return new ViewTrackerRepositoryCacheDecorator($repository);
            }
            return $repository;
        });


        $this->app->bind(RoleRepositoryContract::class, function () {
            $repository = new RoleRepository(new Role);

            if (config('webed-caching.repository.enabled')) {
                return new RoleRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(PermissionRepositoryContract::class, function () {
            $repository = new PermissionRepository(new Permission);

            if (config('webed-caching.repository.enabled')) {
                return new PermissionRepositoryCacheDecorator($repository);
            }

            return $repository;
        });



    }
}
