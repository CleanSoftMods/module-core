<?php namespace CleanSoft\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class BreadcrumbsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \CleanSoft\Modules\Core\Support\Breadcrumbs::class;
    }
}
