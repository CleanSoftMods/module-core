<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Services\FlashMessages;
use Illuminate\Support\Facades\Facade;

class FlashMessagesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FlashMessages::class;
    }
}
