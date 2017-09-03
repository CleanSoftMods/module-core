<?php namespace CleanSoft\Modules\Core\Http\Controllers;

use CleanSoft\Modules\Core\Facades\DashboardLanguageFacade;

class DashboardLanguageController extends BaseController
{
    protected $module = 'webed-core';

    public function getChangeLanguage($languageSlug)
    {
        DashboardLanguageFacade::setDashboardLanguage($languageSlug);
        return redirect()->back();
    }
}
