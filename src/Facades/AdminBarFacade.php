<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Support\AdminBar;
use Illuminate\Support\Facades\Facade;

class AdminBarFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AdminBar::class;
    }
}
