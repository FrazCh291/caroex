<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Documents;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\WarehouseContainer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\WarehouseContainerContext;
use App\Services\Traits\DefaultActiveLog;

class WarehouseContainerController extends Controller
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
        $this->authorize('viewAny',WarehouseContainer::class);

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\WarehouseContainer',
            'activity' => 'View',
        ];
        $this->defaultFun($module);

        $warehouseContainers = WarehouseContainer::query();
        $warehouseContainers = $warehouseContainers->where('company_id', Auth::user()->company_id);
        $warehouseContainers = $this->search($warehouseContainers, [
            'container_no',
            'container_ordered_at'
        ]);
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $warehouseContainers = $this->sort($warehouseContainers, $columns, $request->get('direction'));
            
        }
        $params = $request->all();
        $warehouseContainers = $warehouseContainers->with(['company'])->orderBy('container_no', 'asc')->paginate(10);

        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('WarehouseContainers/Index', [
            'warehouseContainers' => $warehouseContainers->withQueryString(),
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
        foreach (['container_no',
                     'container_ordered_at',] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }
        return $sorts;
    }
    public function logable($module, $message, $message1)
    {
        $request = [
            'company_id'=> Auth::user()->company_id,
            'user_id'=> Auth::user()->id,
            'module' => $module,
            'activity' => $message1,
            'description' => $message
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
            'description' => $module['message']
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
        $this->authorize('create',WarehouseContainer::class);

        $module = [
            'message' => 'page',
            'module' => 'App\Module\WarehouseContainer',
            'activity' => 'Create'
        ];
        $this->defaultFun($module);


        return Inertia::render('WarehouseContainers/Create');
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function addContext($id)
    {
        $this->authorize('create',WarehouseContainer::class);

        $warehouseContainer = WarehouseContainer::with('warehouseContainerContext.warehouse', 'warehouseContainerContext.product')->findOrFail($id);
        $products = Product::Select('name', 'id')->get();
        $warehouses = Warehouse::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();

        return Inertia::render('WarehouseContainers/addContext', [
            'products' => $products,
            'warehouses' => $warehouses,
            'warehouseContainer' => $warehouseContainer
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function addDocuments($id)
    {
        $this->authorize('create',WarehouseContainer::class);

        $warehouseContainer = WarehouseContainer::findOrFail($id);

        return Inertia::render('WarehouseContainers/addDocument', [
            'warehouseContainer' => $warehouseContainer,
        ]);
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
            'container_no' => ['required', 'string'],
            'container_ordered_at' => ['required', 'date'],
        ]);
        $warehouseContainers = new WarehouseContainer();
        $warehouseContainers->company_id = Auth::user()->company_id;
        $warehouseContainers->container_no = $request->container_no;
        $warehouseContainers->container_ordered_at = $request->container_ordered_at;
        $warehouseContainers->save();

        $message =  '{' . $warehouseContainers->id  .'}';
        $message1 = 'Store' ;
        $this->logable($warehouseContainers, $message, $message1);

        return Redirect::route('containers.show', $warehouseContainers->id)->with('success', 'Warehouse Container created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $this->authorize('view',WarehouseContainer::class);

        $warehouseContainer = WarehouseContainer::with('warehouseContainerContext.warehouse', 'warehouseContainerContext.product')
            ->with('documents')->where('id', $id)->first();
        $products = Product::Select('name', 'id')->get();
        $warehouses = Warehouse::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();

        $warehouseContainerCotext = WarehouseContainerContext::where('warehouse_container_id', $id)->get();
        $contextcount = $warehouseContainerCotext->count();
        $unitprice = $warehouseContainerCotext->sum('unit_price');
        $quantity = $warehouseContainerCotext->sum('quantity');
        $ctn = $warehouseContainerCotext->sum('ctn');
        $totalamount = $warehouseContainerCotext->sum('total_amount');

        $message =  '{' . $warehouseContainer->id  .'}';
        $message1 = 'Show' ;
        $this->logable($warehouseContainer, $message, $message1);

        return Inertia::render('WarehouseContainers/Show', [
            'warehouseContainerCotext' => $warehouseContainerCotext,
            'warehouseContainer' => $warehouseContainer,
            'products' => $products,
            'warehouses' => $warehouses,
            'unitprice' => $unitprice,
            'contextcount' => $contextcount,
            'totalamount' => $totalamount,
            'quantity' => $quantity,
            'ctn' => $ctn
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
        $this->authorize('update',WarehouseContainer::class);

        $warehouseContainers = WarehouseContainer::findOrFail($id);
    
        $message =  '{' . $warehouseContainers->id  .'}';
        $message1 = 'Edit' ;
        $this->logable($warehouseContainers, $message, $message1);

        return Inertia::render('WarehouseContainers/Create', [
            'warehouseContainers' => $warehouseContainers,
        ]);
    }

    /**
     * @param $id
     * @param $id2
     * @return \Inertia\Response
     */
    public function editDocuments($id,$id2)
    {
        $this->authorize('update',WarehouseContainer::class);

        $document = Documents::findOrFail($id2);

        $message =  '{' . $document->id  .'}';
        $message1 = 'Edit' ;
        $this->logable($document, $message, $message1);

        return Inertia::render('WarehouseContainers/addDocument', [
            'document' => $document
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function editContext($id,$id2)
    {
        $this->authorize('update',WarehouseContainer::class);

        $warehouseContainerContext = WarehouseContainerContext::findOrFail($id2);
        $products = Product::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $warehouses = Warehouse::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();

        return Inertia::render('WarehouseContainers/addContext', [
            'products' => $products,
            'warehouses' => $warehouses,
            'warehouseContainerContext' => $warehouseContainerContext,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateContext(Request $request, $id2)
    {
        $this->validate($request, [
            'warehouse_id' => ['required'],
            'product_id' => ['required'],
            'bill_of_lading_no' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'ctn' => ['required', 'integer'],
            'unit_price' => ['required', 'numeric'],
            'total_amount' => ['required', 'numeric'],
        ]);

        $warehouseContainerContext = WarehouseContainerContext::find($request->get('id'));
        $warehouseContainerContext->company_id = Auth::user()->company_id;
        $warehouseContainerContext->warehouse_container_id = $request->warehouse_container_id;
        $warehouseContainerContext->warehouse_id = $request->warehouse_id;
        $warehouseContainerContext->product_id = $request->product_id;
        $warehouseContainerContext->bill_of_lading_no = $request->bill_of_lading_no;
        $warehouseContainerContext->quantity = $request->quantity;
        $warehouseContainerContext->ctn = $request->ctn;
        $warehouseContainerContext->unit_price = $request->unit_price;
        $warehouseContainerContext->total_amount = $request->total_amount;
        $warehouseContainerContext->save();

        $message =  '{' . $warehouseContainerContext->id  .'}';
        $message1 = 'Update' ;
        $this->logable($warehouseContainerContext, $message, $message1);

        return redirect::route('containers.show', $warehouseContainerContext->warehouse_container_id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function documentUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
            'file' => ['required'],
        ]);

        $document = Documents::find($request->id);

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('docoments');
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
            $document->company_id = Auth::user() ? Auth::user()->company_id : '';
            $document->title = $request->title;
            $document->file = $path;
            $document->description = $request->description;
            $document->file_type = $mimeType;
        } else {
            $document->company_id = Auth::user() ? Auth::user()->company_id : '';
            $document->title = $request->title;
            $document->description = $request->description;
        }
        $document->save();

        $message =  '{' . $document->id  .'}';
        $message1 = 'Update' ;
        $this->logable($document, $message, $message1);

        return Redirect::route('containers.show', $document->documentable_id)->with('success', 'Warehouse Containers DocumentsUpdated successfully');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'container_no' => ['required', 'string'],
            'container_ordered_at' => ['required', 'date'],
        ]);
        $warehouseContainers = WarehouseContainer::findOrFail($id);
        $warehouseContainers->company_id = Auth::user()->company_id;
        $warehouseContainers->container_no = $request->container_no;
        $warehouseContainers->container_ordered_at = $request->container_ordered_at;
        $warehouseContainers->update($request->all());

        $message =  '{' . $warehouseContainers->id  .'}';
        $message1 = 'Update' ;
        $this->logable($warehouseContainers, $message, $message1);

        

        return Redirect::route('containers.index')->with('success', 'Warehouse Container updated successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function documentStore(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
            'file' => ['required'],
        ]);

        $warehouseContainer = WarehouseContainer::find($request->get('warehouseContainer_id'));

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('docoments');
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
        }

        $warehouseContainer->documents()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'documentable_id' => $request->warehouse_container_id,
            'title' => $request->title,
            'file' => $path,
            'file_type' => $mimeType,
            'description' => $request->description,
        ]);

        return redirect::route('containers.show', $warehouseContainer->id)->with('success', 'Container Documents Created successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function contextStore(Request $request)
    {
        $this->validate($request, [
            'warehouse_id' => ['required'],
            'product_id' => ['required'],
            'bill_of_lading_no' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'ctn' => ['required', 'integer'],
            'unit_price' => ['required', 'numeric'],
            'total_amount' => ['required', 'numeric'],
        ]);

        $warehouseContainer = WarehouseContainer::find($request->get('warehouseContainer_id'));
        $warehouseContainerContext = new WarehouseContainerContext;
        $warehouseContainerContext->company_id = Auth::user()->company_id;
        $warehouseContainerContext->warehouse_container_id = $request->warehouseContainer_id;
        $warehouseContainerContext->warehouse_id = $request->warehouse_id;
        $warehouseContainerContext->product_id = $request->product_id;
        $warehouseContainerContext->bill_of_lading_no = $request->bill_of_lading_no;
        $warehouseContainerContext->quantity = $request->quantity;
        $warehouseContainerContext->ctn = $request->ctn;
        $warehouseContainerContext->unit_price = $request->unit_price;
        $warehouseContainerContext->total_amount = $request->total_amount;
        $warehouseContainerContext->save();

        $message =  '{' . $warehouseContainerContext->id  .'}';
        $message1 = 'Store' ;
        $this->logable($warehouseContainerContext, $message, $message1);

        return redirect::route('containers.show', $warehouseContainer->id)->with('success', 'Company Payments deleted successfully');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function viewFile($id, $id2)
    {
        $this->authorize('view',WarehouseContainer::class);

        $containerFileView = Documents::where('id', $id2)->firstOrFail();

        return response()->file(public_path($containerFileView->file));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportFile($id, $id2)
    {
        $this->authorize('view',WarehouseContainer::class);

        $containerFileView = Documents::where('id', $id2)->firstOrFail();

        return response()->download(public_path($containerFileView->file));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, $id2)
    {
        $this->authorize('delete',WarehouseContainer::class);

        $warehouseContainerContext = WarehouseContainerContext::findOrFail($id2);
        $warehouseContainerContext->delete();

        $message =  '{' . $warehouseContainerContext->id  .'}';
        $message1 = 'Delete' ;
        $this->logable($warehouseContainerContext, $message, $message1);

        return redirect::route('containers.show', $warehouseContainerContext->warehouse_container_id)->with('success', 'Company Payments deleted successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function docDelete($id, $id2)
    {
        $this->authorize('delete',WarehouseContainer::class);

        $documents = Documents::findOrFail($id2);
        $documents->delete();

        $message =  '{' . $documents->id  .'}';
        $message1 = 'Delete' ;
        $this->logable($documents, $message, $message1);

        return redirect::route('containers.show', $documents->documentable_id)->with('success', 'Company Payments deleted successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete',WarehouseContainer::class);

        $warehouseContainer = WarehouseContainer::findOrFail($id);
        $warehouseContainer->delete();
        $message =  '{' . $warehouseContainer->id  .'}';
        $message1 = 'Delete' ;
        $this->logable($warehouseContainer, $message, $message1);

        return Redirect::route('containers.index')->with('success', 'Company Payments deleted successfully');
    }
}
