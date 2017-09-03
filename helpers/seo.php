<?php
if (!function_exists('seo')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\SEO
     */
    function seo()
    {
        return \CleanSoft\Modules\Core\Facades\SeoFacade::getFacadeRoot();
    }
}
