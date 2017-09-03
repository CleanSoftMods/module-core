<?php namespace CleanSoft\Modules\Core\Http\ViewComposers;

use Illuminate\View\View;

class AdminBreadcrumbsViewComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('pageBreadcrumbs', breadcrumbs()->render());
    }
}
