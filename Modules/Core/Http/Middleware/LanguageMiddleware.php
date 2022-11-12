<?php

namespace Modules\Core\Http\Middleware;

use Closure;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * check if the languages is sent with
         * request, if so change the dashboard language
         * @author BaRaa
         */
        $lang = $request->header('language');
        if (isset($lang) && $lang != "null") {
            app()->setLocale($lang);                    // update the language @author Amr
        }
        return $next($request);
    }
}
