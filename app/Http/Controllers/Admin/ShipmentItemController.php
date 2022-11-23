<?php


namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\ShipmentItem;
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;

class ShipmentItemController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $companies = Company::Where('parent_id', Auth::user()->company_id)->get();

        return Inertia::render('ShipmentItems/Create', [
            'companies' => $companies,
            'shipmentId' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'freight_forwarder_id' => ['required'],
            'shipment_id' => ['required'],
            'item_name' => ['required'],
            'carton' => ['required'],
            'qty_ctn' => ['required'],
            'total_qty' => ['required'],
            'unit_price' => ['required']
        ]);

        $shipmentitem = new ShipmentItem();
        $shipmentitem->company_id = Auth::user()->company_id;
        $shipmentitem->freight_forwarder_id = $validate['freight_forwarder_id'];
        $shipmentitem->shipment_id = $validate['shipment_id'];
        $shipmentitem->item_name = $validate['item_name'];
        $shipmentitem->carton = $validate['carton'];
        $shipmentitem->qty_ctn = $validate['qty_ctn'];
        $shipmentitem->total_qty = $validate['total_qty'];
        $shipmentitem->unit_price = $validate['unit_price'];
        $shipmentitem->save();

        $message =  '{' . $shipmentitem->id  .'}';
        $message1 = 'Store' ;
        $type = 'erp';
        $this->logable($shipmentitem, $message, $message1,$type);


        return Redirect::route('shipments.show', $request->shipment_id)->with('success', 'Sipment created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$shipmentItemId)
    {
        $shipmentItem = ShipmentItem::findOrFail($shipmentItemId);

        $companies = Company::Where('parent_id', Auth::user()->company_id)->get();

        return Inertia::render('ShipmentItems/Create', [

            'shipmentId' => $id,
            'companies' => $companies,
            'shipmentItem' => $shipmentItem
        ]);

        $message =  '{' . $shipmentItem->id  .'}';
        $message1 = 'Edit' ;
        $type = 'erp';
        $this->logable($shipmentItem, $message, $message1,$type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shipmentItem = ShipmentItem::find($id);
        $shipmentItem->update($request->all());

        $this->validate($request, [
            'company_id' => ['required'],
            'freight_forwarder_id' => ['required'],
            'shipment_id' => ['required'],
            'item_name' => ['required'],
            'carton' => ['required'],
            'qty_ctn' => ['required'],
            'total_qty' => ['required'],
            'unit_price' => ['required']

        ]);

        $message =  '{' . $shipmentItem->id  .'}';
        $message1 = 'Update' ;
        $type = 'erp';
        $this->logable($shipmentItem, $message, $message1,$type);

        return Redirect::route('shipments.show', $request->shipment_id)->with('success', 'Shipment item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipmentItem = ShipmentItem::findOrFail($id);
        $shipmentItem->delete();

        $message =  '{' . $shipmentItem->id  .'}';
        $message1 = 'Delete' ;
        $type = 'erp';
        $this->logable($shipmentItem, $message, $message1,$type);

        return Redirect::back()->with('success', 'Shipment item deleted successfully');

    }
    public function logable($module, $message, $message1, $type)
    {
        $request = [
            'company_id'=> Auth::user()->company_id,
            'user_id'=> Auth::user()->id,
            'module' => $module,
            'activity' => $message1,
            'type' => $type,
        ];
        $this->log($request);
    }

    public function defaultFun($module)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module['module'],
            'activity' => $module['activity'],
            'type' => $module['type'],
        ];

        $this->defaultLog($request);
    }
}
