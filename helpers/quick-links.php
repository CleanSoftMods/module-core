<?php
if (!function_exists('admin_quick_link')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\AdminQuickLink
     */
    function admin_quick_link()
    {
        return \CleanSoft\Modules\Core\Facades\AdminQuickLinkFacade::getFacadeRoot();
    }
}