<?php namespace WebEd\Base\Core\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Core\Support\SEO;

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
