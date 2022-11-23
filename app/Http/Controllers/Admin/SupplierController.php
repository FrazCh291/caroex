<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Address;
use App\Models\Supplier;
use App\Models\Documents;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class SupplierController extends Controller
{
    use Sort;
    use Filter;
    use Search;

    public function __construct()
    {
//        return $this->authorizeResource(Supplier::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */

    public function index(Request $request)
    {
        $companies = Company::query();
        $companies = $companies->where('type', 'supplier_company')->where('parent_id', Auth::user()->company_id);

        $companies = $this->search($companies, [
            'name',
            'contact_name',
            'email',
            'phone',
            'type',
        ]);
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $companies = $this->sort($companies, $columns, $request->get('direction'));
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $companies = $this->sort($companies, $columns, $request->get('direction'));
        }

        $companies = $companies->orderBy('id', 'desc')->paginate(10);

        $params = $request->all();

        return Inertia::render('Supplier/Index', [
            'companies' => $companies->withQueryString(),
            'params' => $params
        ]);

//        $this->authorize('viewAny',Supplier::class);
//        $suppliers = Supplier::query();
//        $suppliers = $suppliers->with('lookup')->where('company_id', Auth::user()->company_id);
//        $suppliers = $request->get('disable') ? $suppliers->orWhere('status', 0) : $suppliers;
//        $suppliers = $request->get('enable') ? $suppliers->where('status', 1) : $suppliers;
//        $suppliers = $this->search($suppliers, [
//            'name',
//            'email',
//            'phone',
//            'address_1',
//            'address_2',
//            'country',
//            'city',
//            'state',
//            'status',
//        ]);
//
//
//        if ($request->has('direction')) {
//            $columns = $this->sortables($request);
//            $suppliers = $this->sort($suppliers, $columns, $request->get('direction'));
//        }
//
//        $suppliers = $suppliers->orderBy('name', 'asc')->paginate(10);
//
//        $params = $request->all();
//        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
//        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';
//
//        return Inertia::render('Supplier/Index', [
//            'suppliers' => $suppliers->withQueryString(),
//            'params' => $params
//        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
                     'name',
                     'contact_name',
                     'email',
                     'phone',
                     'type',
                 ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }
        return $sorts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Supplier::class);
        $countries = Lookup::where('type', 'country')->get();

        return Inertia::render('Supplier/Create', [
            'countries' => $countries
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function createDocuments($id)
    {
        $this->authorize('create', Supplier::class);
        $supplier = Supplier::with('documents')->where('id', $id)->first();

        return Inertia::render('Supplier/FileCreate', [
            'supplier' => $supplier
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
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'address_1' => ['required', 'string'],
            'address_2' => ['different:address_1'],
            'postal_code' => ['required', 'string', 'max:8'],
        ]);
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->company_id = Auth::user()->company_id;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email ? $request->email : '';
        $supplier->address_1 = $request->address_1;
        $supplier->address_2 = $request->address_2;
        $supplier->country = $request->country;
        $supplier->city = $request->city;
        $supplier->state = $request->state;
        $supplier->postal_code = $request->postal_code;
        $supplier->status = $request->status;
        $supplier->save();

        return Redirect::route('suppliers.index')->with('success', 'Supplier added successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function documentStore(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
            'file' => ['required'],
        ]);
        $supplier = Supplier::find($request->get('supplier_id'));

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('docoments');
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
        }

        $supplier->documents()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'title' => $request->title,
            'file' => $path,
            'file_type' => $mimeType,
            'description' => $request->description,
        ]);

        return Redirect::route('suppliers.show', $supplier->id)->with('success', 'Supplier rate created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id)
    {

        $this->authorize('view', Supplier::class);
        $supplier = Supplier::with(['documents', 'invoices.addressess', 'invoices.addresses'])->with('lookup')->where('id', $id)->orderBy('name', "desc")->first();
        $documents = $supplier->documents()->get();

        Session::put('supplier_id', $supplier->id);;

        return Inertia::render('Supplier/Show', [
            'supplier' => $supplier,
            'documents' => $documents,
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
        $this->authorize('update', Supplier::class);
        $suppliers = Supplier::findOrFail($id);
        $countries = Lookup::where('type', 'country')->get();


        return Inertia::render('Supplier/Create', [
            'suppliers' => $suppliers,
            'countries' => $countries
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function editDocuments($id)
    {
        $this->authorize('update', Supplier::class);

        $document = Documents::where('id', $id)->first();

        return Inertia::render('Supplier/FileCreate', [
            'document' => $document
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function documentUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
        ]);
        $document = Documents::find($request->get('id'));

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

        return Redirect::route('suppliers.show', $document->documentable_id)->with('success', 'Supplier added successfully');
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
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'address_1' => ['required', 'string'],
            'address_2' => ['different:address_1'],
            'postal_code' => ['required', 'string', 'max:8'],
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->company_id = Auth::user()->company_id;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address_1 = $request->address_1;
        $supplier->address_2 = $request->address_2;
        $supplier->country = $request->country;
        $supplier->city = $request->city;
        $supplier->state = $request->state;
        $supplier->postal_code = $request->postal_code;
        $supplier->status = $request->status;
        $supplier->update();

        return Redirect::route('suppliers.index')->with('success', 'Supplier Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', Supplier::class);

        $supplier = Supplier::findOrFail($supplier->id);
        $supplier->delete();

        return Redirect::route('suppliers.index')->with('success', 'Supplier deleted successfully');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function viewSupplierFile($id)
    {
        $this->authorize('view', Supplier::class);

        $supplierFileView = Documents::where('id', $id)->firstOrFail();

        return response()->file(public_path($supplierFileView->file));
    }

    /**
     * @param $id
     * @return string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportSupplierFile($id)
    {
        $this->authorize('view', Supplier::class);

        $dealsFileExport = Documents::where('id', $id)->firstOrFail();

        return response()->download(public_path($dealsFileExport->file));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $this->authorize('delete', Supplier::class);

        $document = Documents::findOrFail($id);
        $document->delete();

        return Redirect::back()->with('success', 'Supplier Document deleted successfully');
    }
}
