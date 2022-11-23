<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Card;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Services\DirectPayment;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;

class SubscriptionController extends Controller
{
    use Logger;
    use DefaultActiveLog;


    /**
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', Subscription::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Subscription',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $packages = Package::orderBy('name', 'asc')->with('modules')->get();

        return Inertia::render('Subscription/Index', [
            'packages' => $packages
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id)
    {
        $this->authorize('create', Subscription::class);
        return Inertia::render('Subscription/Create', [
            'package_id' => $id
        ]);
    }

    /**]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function start(Request $request)
    {
        $this->authorize('start', Subscription::class);

        $this->validate($request, [
            'package_id' => ['required', 'integer', 'exists:packages,id'],
            'card_type' => ['required', 'string'],
            'card_number' => ['required', 'integer'],
            'expire' => ['date_format:m-Y'],
            'cvv2' => ['required', 'integer'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'street' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'zip' => ['required', 'string'],
            'price' => ['numeric', 'min:1'],
        ]);

        DB::transaction(function () use ($request) {
            Subscription::where('user_id', Auth::user()->id)->update(['is_active' => 0]);
            $package = Package::findOrfail($request->package_id);
            $package_modules = $package->modules()->get();
            Auth::user()->role->permissions()->detach();

            foreach ($package_modules as $package_module) {
                $permissionIds = $package_module->permissions()->get()->pluck('id')->toArray();
                $role = Auth::user()->role;
                $role->permissions()->attach($permissionIds);
            }

            $requestData = $request->all();
            $requestData['ip'] = $request->ip();

            $payment = new DirectPayment($requestData, $package->price);
            $data = $payment->pay();
            $data['card_number'] = strval($request->get('card_number'));
            $data['package_id'] = $package->id;
            $payment = $payment->storePayment($data);

            $subscription = new Subscription();
            $subscription->user_id = Auth::user()->id;
            $subscription->company_id = $payment->company_id;
            $subscription->package_id = $payment->package_id;
            $subscription->is_active = 1;

            $subscription->started_at = now();
            // $subscription->end_at = Carbon::now()->addDays($package->duration);
            $subscription->save();

            $card = new Card();
            $card->user_id = Auth::user()->id;
            $card->first_name = $request->first_name;
            $card->last_name = $request->last_name;
            $card->card_type = $request->card_type;
            $card->card_number = $request->card_number;
            $card->expire = $request->card_number;
            $card->cvv2 = $request->cvv2;
            $card->street = $request->street;
            $card->city = $request->city;
            $card->state = $request->state;
            $card->zip = $request->zip;
            $card->country = $request->country;
            $card->save();

        });

        return Redirect::route('dashboard.index')->with('success', 'Subscription created successfully');
    }
    public function logable($module)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module['module'],
            'activity' => $module['activity'],
            'type' => $module['type'],
            'path' => $module['path'],
        ];
       return $this->log($request);
    }

    public function defaultFun($module)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module['module'],
            'activity' => $module['activity'],
            'type' => $module['type'],
            'path' => $module['path'],
        ];

        $this->defaultLog($request);
    }
}
