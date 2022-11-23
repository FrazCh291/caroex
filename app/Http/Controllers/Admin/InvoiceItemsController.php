<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Support\Facades\Redirect;

class InvoiceItemsController extends Controller
{
    use Logger;
    use DefaultActiveLog;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module = [
            'message' => 'grid',
            'module' => 'App\Module\InvoiceItems',
            'activity' => 'View',
            'type' => 'erp'
        ];
        $this->defaultFun($module);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($name,$id,$invoiceId)
    {
        return Inertia::render('InvoiceItems/Create', [
            'invoice_id' => $invoiceId,
            'name' => $name,
            'id' => $id
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
            'item_name' => ['required'],
            'carton' => ['required', 'integer', 'min:1'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:1.00'],
        ]);

        $invoiceItem = new InvoiceItem();
        $invoiceItem->company_id = Auth::user() ? Auth::user()->company_id : '';
        $invoiceItem->invoice_id = $request->invoice_id;
        $invoiceItem->item_name = $request->item_name;
        $invoiceItem->carton = $request->carton;
        $invoiceItem->quantity = $request->quantity;
        $invoiceItem->total_quantity = $request->carton * $request->quantity;
        $invoiceItem->unit_price = $request->unit_price;
        $invoiceItem->total_price = $request->carton * $request->quantity * $request->unit_price;
        $invoiceItem->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $invoiceItem->id  .'}',
            'module' => $invoiceItem,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$invoiceItem->id,
        ];

        $this->logable($module);

        return Redirect::route('invoice.show', [$request->name,$request->id,$invoiceItem->invoice_id])->with('success', 'Invoiceitem create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name,$id,$invoiceId,$invoiceItemId)
    {
        $invoiceItem = InvoiceItem::findorFail($invoiceItemId);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $invoiceItem->id  .'}',
            'module' => $invoiceItem,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('InvoiceItems/Create', [
            'name' => $name,
            'id' => $id,
            'invoice_id' => $invoiceId,
            'invoiceItem' => $invoiceItem,
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
        $this->validate($request, [
            'item_name' => ['required'],
            'carton' => ['required', 'integer', 'min:1'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:1.00'],
        ]);

        $invoiceItem = InvoiceItem::findorFail($id);
        $invoiceItem->item_name = $request->item_name;
        $invoiceItem->carton = $request->carton;
        $invoiceItem->quantity = $request->quantity;
        $invoiceItem->total_quantity = $request->carton * $request->quantity;
        $invoiceItem->unit_price = $request->unit_price;
        $invoiceItem->total_price = $request->carton * $request->quantity * $request->unit_price;
        $invoiceItem->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $invoiceItem->id  .'}',
            'module' => $invoiceItem,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);



        return Redirect::route('invoice.show', [$request->name,$request->mid,$invoiceItem->invoice_id])->with('success', 'Invoiceitem update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoiceItem = InvoiceItem::findorFail($id);
        $invoiceItem->delete();

        $module = [
            'message' => '{' . $invoiceItem->id  .'}',
            'module' => $invoiceItem,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);


        return Redirect::back()->with('success', 'Invoiceitem deleted successfully');
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
     return  $this->log($request);
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
