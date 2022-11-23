<?php

namespace App\Http\Controllers\Admin;
use Inertia\Inertia;
use App\Models\SparePart;
use App\Services\Traits\Logger;
use App\Services\Traits\Search;
use App\Services\Traits\Sort;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;


class SparePartController extends Controller
{
    use Sort;
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
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\SparePart',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $spareParts = SparePart::query();

        $spareParts = $this->search($spareParts, [
            'name',
            'code',
            'quantity',
        ]);
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $spareParts = $this->sort($spareParts, $columns, $request->get('direction'));
        }
        $spareParts = $spareParts->orderBy('name', 'asc')->paginate(10);
        $params = $request->all();
        return Inertia::render('SpareParts/Index', [
            'spareParts' => $spareParts->withQueryString(),
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
        foreach ([
                     'name',
                     'code',
                     'quantity'
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
            'module' => 'App\Module\SparePart',
            'message' => 'page',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('SpareParts/Create');
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
            'name' => ['required'],
            'code' => ['required'],
            'quantity' => ['required'],
        ]);
        if ($request->file('image')) {
            $path = 'storage/' . $request->image->store('Products');
        }
        $sparePart = SparePart::where([['name', $request->name],['code', $request->code]])->first();
        if ($sparePart) {
            $sparePart->name = $request->name;
            $sparePart->image = $request->file('image') ? $path : $sparePart->image;
            $sparePart->code = $request->code;
            $sparePart->quantity = ($sparePart['quantity']) + ($request->quantity);
            $sparePart->update();
        } else {
            $sparePart = new SparePart();
            $sparePart->company_id = Auth::user() ? Auth::user()->company_id : '';
            $sparePart->name = $request->name;
            $sparePart->image = $request->file('image') ? $path : $request->image;
            $sparePart->code = $request->code;
            $sparePart->quantity = $request->quantity;
            $sparePart->save();
        }

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $sparePart->id  .'}',
            'module' => $sparePart,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$sparePart->id,
        ];

        $this->logable($module);

        return Redirect::route('spare-parts.index')->with('success', 'Spare Part created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $sparePart = SparePart::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $sparePart->id  .'}',
            'module' => $sparePart,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice.'/'.$sparePart->id,
        ];

        $this->logable($module);

        return Inertia::render('SpareParts/Create', [
            'sparePart' => $sparePart
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
        $this->validate($request, [
            'name' => ['required'],
            'code' => ['required'],
            'quantity' => ['required'],
        ]);
        if ($request->file('image')) {
            $path = $request->file('image') ? 'storage/' . $request->image->store('Products') : $request->image;
        }
        $sparePartOld = SparePart::where('id', $id)->first();
        $sparePart = SparePart::findOrfail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $sparePart->id  .'}',
            'module' => $sparePart,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $sparePartOld;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $sparePart->company_id = Auth::user() ? Auth::user()->company_id : '';
        $sparePart->name = $request->name;
        $sparePart->image = $request->file('image') ? $path : $request->image;
        $sparePart->code = $request->code;
        $sparePart->quantity = $request->quantity;
        $sparePart->update();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $sparePart;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('spare-parts.index')->with('success', 'Spare Part updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $sparePart =  SparePart::findOrFail($id)->delete();

        $module = [
            'message' => '{' . $sparePart->id  .'}',
            'module' => $sparePart,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];
        $this->logable($module);

        return Redirect::back()->with('success', 'Spare Parts Deleted Successfully');
    }
}
