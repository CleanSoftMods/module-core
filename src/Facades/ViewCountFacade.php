<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Support\ViewCount;
use Illuminate\Support\Facades\Facade;

class ViewCountFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ViewCount::class;
    }
}
