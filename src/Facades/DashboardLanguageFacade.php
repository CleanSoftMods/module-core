<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Support\DashboardLanguage;
use Illuminate\Support\Facades\Facade;

/**
 * @method static DashboardLanguage setDashboardLanguage(string $slug)
 * @method static DashboardLanguage getDashboardLanguage(string $default = null)
 */
class DashboardLanguageFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DashboardLanguage::class;
    }
}
