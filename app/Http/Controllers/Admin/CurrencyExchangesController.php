<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lookup;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Models\CurrencyExchange;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Charts\MonthlyCurrencyExchangeChart;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use App\Services\Traits\DefaultActiveLog;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class CurrencyExchangesController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;


    private $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', CurrencyExchange::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\CurrencyExchange',
            'activity' => 'View',
            'type' => 'super',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $currencyExchanges = Lookup::query();
        $currencyExchanges->where('type', 'currency')->get();
        $currencyExchanges = $this->search($currencyExchanges, [
            'created_at',
            'value',
        ]);
        // $currencyExchanges = $this->search($currencyExchanges, ['from_to', 'amount','date']);
        // if ($request->has('query')) {
        //     $currencyExchanges = $currencyExchanges->orWhereHas('currencyExchanges', function (Builder $query) {
        //         $this->search($query, ['name']);
        //     });
        //     // dd($request->all());
        // }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $currencyExchanges = $this->sort($currencyExchanges, $columns, $request->get('direction'));
        }
        $currencyExchanges = $currencyExchanges->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();

        return Inertia::render('CurrencyExchanges/Index', [
            'currencyExchanges' => $currencyExchanges->withQueryString(),
            'params' => $params,

        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];

        foreach (['value',  'created_at'
                 ] as $sort) {
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
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\CurrencyExchange',
            'activity' => 'Create',
            'type' => 'super',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $currency_exchanges = Lookup::where('type', 'currency_exchange')->get();

        return Inertia::render('CurrencyExchanges/Create', [
            'currency_exchanges' => $currency_exchanges,

        ]);

    }

    public function conversionCreate()
    {

        $this->authorize('viewAny', CurrencyExchange::class);

        $exchanges = CurrencyExchange::latest('date')->get()->unique('from_to');

        return Inertia::render('CurrencyExchanges/Conversion', [
            'exchanges' => $exchanges,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'from_to' => ['required'],
            'date' => ['required'],
            'amount' => 'required|numeric|between:0,999.99',
        ]);

       $currencyExchange = CurrencyExchange::create([
            'from_to' => $request->from_to,
            'date' => $request->date,
            'amount' => $request->amount,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $currencyExchange->id  .'}',
            'module' => $currencyExchange,
            'activity' => 'Store',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('exchanges-rates.index')->with('success', 'CurrencyExchange Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', CurrencyExchange::class);

        return Inertia::render('CurrencyExchanges/Show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $this->authorize('update', CurrencyExchange::class);

        $currencyExchanges = Lookup::findOrFail($id); 
        $currency_exchanges = Lookup::where('type', 'currency_exchange')->get();
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' .  $currencyExchanges->id  .'}',
            'module' =>  $currencyExchanges,
            'activity' => 'Edit',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('CurrencyExchanges/Create', [
            'currencyExchanges' => $currencyExchanges,
            'currency_exchanges' => $currency_exchanges
        ]);
   
        return Inertia::render('CurrencyExchanges/Create', [
            // 'currency_exchanges' => $currency_exchanges,
            'currencyExchanges' => $currencyExchanges,
            'currency_exchanges' => $currency_exchanges

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // $request->validate([
        //     'from_to' => ['required'],
        //     'date' => ['required'],
        //     'amount' => 'required|numeric|between:0,999.99',
        // ]);
    // $currencyExchangeOld = CurrencyExchange::where('id', $id)->first();
    // $currencyExchange = CurrencyExchange::where('id', $id)->first();
    //     $currentURL = url()->current();
    //     $slice = Str::after($currentURL, '8000');
        
    //     $module = [
    //         'message' => '{' . $currencyExchange->id  .'}',
    //         'module' => $currencyExchange,
    //         'activity' => 'Update',
    //         'type' => 'super',
    //         'path' => $slice.'/edit',
    //     ];
    //     $logData =  $this->logable($module);
    //     $details = $currencyExchangeOld;
        
	// 	$final_data = json_encode($details);
        
    //      $LogDetail = new ActivityLogsDetails();
    //      $LogDetail->activity_log_id = $logData->id;
    //      $LogDetail->company_id = Auth::user()->company_id;
    //      $LogDetail->details = $final_data;
    //      $LogDetail->is_old = 1;
    //      $LogDetail->save();

    $currencyExchange =    CurrencyExchange::where('id', $id)->update([
            "from_to" => $request->from_to,
            "date" => $request->date,
            "amount" => $request->amount,
        ]);
        $currencyExchangeNew = CurrencyExchange::where('id', $id)->first();
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

       $details = $currencyExchangeNew;
       $final_data = json_encode($details);
       
       $LogDetail = new ActivityLogsDetails();
       $LogDetail->company_id = Auth::user()->company_id;
       $LogDetail->activity_log_id = $logData->id;
       $LogDetail->is_old = 0;
       $LogDetail->details = $final_data;
       $LogDetail->save();

        return redirect()->route('exchanges-rates.index')->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', CurrencyExchange::class);

        $currencyExchanges = CurrencyExchange::find($id);
        $currencyExchanges->delete();

        $module = [
            'message' => '{' . $currencyExchanges->id  .'}',
            'module' => $currencyExchanges,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->route('exchanges-rates.index');
    }

    public function rate(Request $request)
    {
        $currencyExchanges = CurrencyExchange::find($request->id);

        $lastMonth = Carbon::now()->subMonth();
        $lastMonthCurrencyRate = CurrencyExchange::select('amount')->where('from_to', $currencyExchanges->from_to)->where('date', '>=', $lastMonth)->pluck('amount')->toArray();
        $lastMonthCurrencyDate = CurrencyExchange::select('date')->where('from_to', $currencyExchanges->from_to)->where('date', '>=', $lastMonth)->pluck('date')->toArray();

        $chart = $this->chart->lineChart()
            ->setTitle('Currency Rate')
            ->addData('Rate', $lastMonthCurrencyRate)
            ->setXAxis($lastMonthCurrencyDate)->toJson();

        return response()->json([
            'exchange' => $currencyExchanges,
            'chart' => $chart]);
    }

}
