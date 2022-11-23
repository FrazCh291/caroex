<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\Collection;
use App\Models\Delivery;
use App\Models\DeliveryItem;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use Illuminate\Support\Facades\DB;
use App\Models\WarehouseContainer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CalenderController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'asc')->get();

        $orders = Order::select([
            'order_date',
            DB::raw('COUNT(order_date) as product_name')
        ])->groupBy('order_date')->get();

        $deliveryItems = DeliveryItem::select([
            'delivery_date',
            DB::raw('COUNT(delivery_date) as delivery_type')
        ])->groupBy('delivery_date')->get();

        $collections = Collection::select([
            'return_at',
            DB::raw('COUNT(return_at) as return_status')
        ])->groupBy('return_at')->get();

        $shipments = Shipment::select([
            'expected_container_delivery_date',
            DB::raw('COUNT(expected_container_delivery_date	) as container_number')
        ])->groupBy('expected_container_delivery_date')->get();

        $mergedCollection = $orders->toBase()->merge($deliveryItems)->merge($collections)->merge($shipments);

        return Inertia::render(
            'Calender/Index',
            [
                'events' => $mergedCollection

            ]
        );
    }

    public function searchEvent()
    {
        $events = Event::all();
        return Inertia::render(
            'Calender/Index',
            [
                'events' =>  $events

            ]
        );
    }

    public function orders()
    {
        $events = Event::orderBy('id', 'asc')->get();

        $events = Event::select([
            'start',
            DB::raw('COUNT(start) as title')
        ])->groupBy('start')->get();

        $events = Event::all();
        return Inertia::render(
            'Calender/Index',
            [
                'events' => $events

            ]
        );
    }

    public function orderEvent()
    {
        $orders = Order::orderBy('id', 'asc')->get();

        $orders = Order::select([
            'order_date',
            DB::raw('COUNT(order_date) as product_name')
        ])->groupBy('order_date')->get();

        return Inertia::render(
            'Calender/OrderEvents',
            [
                'events' => $orders,


            ]
        );
    }
    public function deliveryEvent()
    {
      
        $deliveryItems = DeliveryItem::select([
            'delivery_date',
            DB::raw('COUNT(delivery_date) as delivery_type')
        ])->groupBy('delivery_date')->get();
        return Inertia::render(
            'Calender/DeliveryEvents',

            [
                'events' =>  $deliveryItems,
            ]
        );
    }

    public function CollectionEvent()
    {
        $collections = Collection::select([
            'return_at',
            DB::raw('COUNT(return_at) as return_status')
        ])->groupBy('return_at')->get();

        return Inertia::render(
            'Calender/CollectionEvents',

            [
                'events' =>  $collections
            ]
        );
    }

    public function shipmentEvent()
    {
        $shipments = Shipment::select([
            'expected_container_delivery_date',
            DB::raw('COUNT(expected_container_delivery_date	) as container_number')
        ])->groupBy('expected_container_delivery_date')->get();
     
        return Inertia::render(
            'Calender/ShipmentEvents',

            [
                'events' =>   $shipments
            ]
        );
    }


    public function searchOrder(Request $request)
    {

        $orders = Order::with('product')->where('order_date', $request->order_date)->get();

        return response()->json($orders);
    }

    public function searchCollectionEvent(Request $request)
    {

        $createdAt = Carbon::parse($request->return_at)->addDay();
        $return_at = $createdAt->format('Y-m-d');

        $collections = Collection::where('return_at', $return_at)->get();

        return response()->json($collections);
    }
    public function searchShipmentEvent(Request $request)
    {
        $createdAt = Carbon::parse($request->expected_container_delivery_date)->addDay();
        $expected_container_delivery_date = $createdAt->format('Y-m-d');
       
        $shipments =  Shipment::where('expected_container_delivery_date', $expected_container_delivery_date)->get();
        return response()->json($shipments);
    }

    public function searchDeliveryEvent(Request $request)
    {
        $createdAt = Carbon::parse($request->delivery_date)->addDay();
        $delivery_date= $createdAt->format('Y-m-d');
        $deliveryItems = DeliveryItem::with('orderItem')->where('delivery_date', $delivery_date)->get();
        
        
        return response()->json($deliveryItems);
    }

    public function searchOrderEvent(Request $request)
    {
        $createdAt = Carbon::parse($request->order_date)->addDay();
        $order_date = $createdAt->format('Y-m-d');
        
        $orders = Order::with('product')->where('order_date', $order_date)->get();

        // dd($orders);
       
        return response()->json($orders);
        
        return Inertia::render(
            'Calender/Index',
            [
                'events' => $orders

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Calender/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
      {
        $this->validate($request, [
            'title' => ['required'],
            'start' => ['required'],
            'end' => ['required'],
        ]);
        $events = new Event();
        $events->title = $request->title;
        $events->start = $request->start;
        $events->end = $request->end;

        $events->save();

        return redirect()->route('calendar.index')->with('success', 'event Create Successfully');
    }

    public function myClender(Request $request)
    {
        $events = Event::where('title', $request->title)->get();
        return Inertia::render(
            'Calender/Index',
            [
                'events' => $events
            ]
        );
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
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return Inertia::render('Calender/Create', [
            'event' => $event
        ]);
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
        $this->validate($request, [
            'title' => ['required'],
            'start' => ['required'],
            'end' => ['required'],
        ]);

        $event = Event::findOrFail($id);
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->background_color = $request->color;
        $event->save();  

        return redirect()->route('calendar.index')->with('success', 'Event Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('calendar.index')->with('success', 'Event Delete Successfully');
    }
}
