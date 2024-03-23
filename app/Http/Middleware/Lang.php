<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('locale')) {
            $locale = $request->locale;
            session()->put('locale', $request->locale);
            cache()->put('locale', $request->locale);
        } else {
            $locale = cache('locale') ?? session()->get('locale') ?? 'en';
        }
        if (in_array($locale, ['ar','en'])) {
            app()->setLocale($locale);
        } 
        return $next($request);
    }
}
