<?php
namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Models\PaymentGateway;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\PaymentGatewayMeta;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;

class PaymentGatewayController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',PaymentGateway::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\PaymentGateway',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $paymentgateways = PaymentGateway::query();
        $paymentgateways = $paymentgateways->where('company_id', Auth::user()->company_id);
        $paymentgateways = $this->search($paymentgateways, [
            'name',
            'private_key',
            'secret_key',
        ]);

        $params = $request->all();
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $paymentgateways = $this->sort($paymentgateways, $columns, $request->get('direction'));
        }
        $paymentgateways = $paymentgateways->orderBy('id', 'asc')->paginate(10);

        return Inertia::render('PaymentGateways/Index', [
            'paymentgateways' => $paymentgateways->withQueryString(),
            'params' => $params
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['name',
                     'name',
                     'private_key',
                     'secret_key',] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }
        return $sorts;
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create',PaymentGateway::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\PaymentGateway',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('PaymentGateways/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:3'],
            'private_key' => ['required', 'string'],
            'secret_key' => ['required', 'string'],
        ]);
        $paymentgateway = new PaymentGateway();
        $paymentgateway->name = $request->name;
        $paymentgateway->company_id = Auth::user()->company_id;
        $paymentgateway->private_key = $request->private_key;
        $paymentgateway->secret_key = $request->secret_key;
        $paymentgateway->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $paymentgateway->id  .'}',
            'module' => $paymentgateway,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$paymentgateway->id,
        ];

        $this->logable($module);

        $paymentgatewaymeta = new PaymentGatewayMeta();
        $paymentgatewaymeta->payment_gateway_id = $paymentgateway->id;
        $paymentgatewaymeta->save();

        return Redirect::route('payment-gateways.index')->with('success', 'Payment Gateway created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show()
    {
        $this->authorize('view',PaymentGateway::class);

        $paymentgateways = PaymentGateway::all();
        $paymentgateways = PaymentGateway::first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $paymentgateways->id  .'}',
            'module' => $paymentgateways,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('PaymentGateways/Show', [
            'paymentgateways' => $paymentgateways,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('view',PaymentGateway::class);

        $paymentgateways = PaymentGateway::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $paymentgateways->id  .'}',
            'module' => $paymentgateways,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('PaymentGateways/Create', [
            'paymentgateways' => $paymentgateways,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $paymentgateway = PaymentGateway::findOrFail($id);
        
        $this->validate($request, [
            'name' => ['required', 'string', 'min:3'],
            'private_key' => ['required', 'string'],
            'secret_key' => ['required', 'string'],
        ]);
        
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $paymentgateway->id  .'}',
            'module' => $paymentgateway,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];

        $logData =  $this->logable($module);
        $details = $paymentgateway;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $this->logable($module);

        $paymentgateway->update($request->all());
        $paymentgateway->name = $request->name;
        $paymentgateway->company_id = Auth::user()->company_id;
        $paymentgateway->private_key = $request->private_key;
        $paymentgateway->secret_key = $request->secret_key;
        $paymentgateway->save();
      
         $currentURL = url()->current();
         $slice = Str::after($currentURL, '8000');

        $details = $paymentgateway;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('payment-gateways.index')->with('success', 'Payment Gateway updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete',PaymentGateway::class);

        $paymentgateway = PaymentGateway::findOrFail($id);
        $paymentgateway->delete(); 

        $module = [
            'message' => '{' . $paymentgateway->id  .'}',
            'module' => $paymentgateway,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);


        return Redirect::route('payment-gateways.index')->with('success', 'Payment Gateway deleted successfully');
    }
}
