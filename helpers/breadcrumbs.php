<?php
if (!function_exists('breadcrumbs')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\Breadcrumbs
     */
    function breadcrumbs()
    {
        return \CleanSoft\Modules\Core\Facades\BreadcrumbsFacade::getFacadeRoot();
    }
}