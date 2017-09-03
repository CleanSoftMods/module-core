<?php namespace CleanSoft\Modules\Core\Http\Middleware;

use CleanSoft\Modules\Core\Facades\DashboardLanguageFacade;
use Closure;

class DashboardLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = DashboardLanguageFacade::getDashboardLanguage();
        app()->setLocale($locale);
        return $next($request);
    }
}
