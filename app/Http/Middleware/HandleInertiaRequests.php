<?php

namespace App\Http\Middleware;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? $request->user() : null,
                'userRole' => $request->user() ? $request->user()->role : null,
                'permissions' => $request->user() ? $request->user()->permissions() : null,
            ],
            'packages' => Package::with('modules')->get(),
//            'product' => session()->get('product'),
//            'orders' => session()->get('orders'),
//            'order' => session()->get('order'),

            'flash' => $request->session()->get('success'),
            'currentRouteName' => $request->route()->getName(),
            'app_env' => env('APP_ENV'),
            'base_path' => env('DO_BASE_PATH')
        ]);
    }
}
