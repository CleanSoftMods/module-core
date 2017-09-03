<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Support\CheckCurrentUserACL;
use CleanSoft\Modules\Core\Support\CheckUserACL;
use Illuminate\Support\Facades\Facade;

class CheckUserACLFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CheckUserACL::class;
    }
}
