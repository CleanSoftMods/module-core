<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Support\AdminQuickLink;
use Illuminate\Support\Facades\Facade;

class AdminQuickLinkFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AdminQuickLink::class;
    }
}
