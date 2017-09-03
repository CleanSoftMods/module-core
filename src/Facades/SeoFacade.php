<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Support\SEO;
use Illuminate\Support\Facades\Facade;

class SeoFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SEO::class;
    }
}
