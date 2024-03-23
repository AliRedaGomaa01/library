<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'check' => auth()->check(),
                'id' => auth()->id(),
                'isAdmin' => auth()->check() && auth()->user()->is_admin,
            ],
            'flash' => [
                'success' => session('success'),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'isEn' => app()->isLocale('en'),
            'lang' => app()->currentLocale(),
            'appUrl' => asset('/'),
            'storageUrl' => asset('/storage'),
            'langRoute' =>  app()->isLocale('ar') ?  $request->url().'?locale='.'en' : $request->url().'?locale='.'ar'  ,
            'routeName' => $request->route() ? $request->route()->getName() : null,
            'routeUrl' => $request->url(),
        ];
    }
}
