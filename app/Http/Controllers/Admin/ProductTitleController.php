<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductTitle;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Traits\DefaultActiveLog;

class ProductTitleController extends Controller
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
        $this->authorize('viewAny', ProductTitle::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\ProductTitle',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $products = ProductTitle::query();
        // $products = $products->where('company_id', Auth::user()->company_id);
        $products = $request->get('enable') ? $products->where('enable', 1) : $products;
        $products = $request->get('disable') ? $products->orWhere('enable', 0) : $products;
        $products = $this->search($products, [
            'product_title',
        ]);

        if ($request->has('query')) {
            $products = $products->orWhereHas('product', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('query')) {
            $products = $products->orWhereHas('product', function (Builder $query) {
                $this->search($query, ['sku']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $products = $this->sort($products, $columns, $request->get('direction'));
        }
        $products = $products->with('company')->orderBy('id', 'desc')->paginate(10);

        if ($request->has('direction') && $request->get('name')) {
            $sortedDta = $products->getCollection()->sortBy(function ($role) {
                return $role->role->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $products->setCollection(collect($sort));
        }

        if ($request->has('direction') && $request->get('order')) {
            $sortedDta = $products->getCollection()->sortBy(function ($role) {
                return $role->role->order;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $products->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('company_id')) {
            $sortedDta = $products->getCollection()->sortBy(function ($role) {
                return $role->role->company_id;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $products->setCollection(collect($sort));
        }


        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('ProductTitle/Index', [
            'products' => $products->withQueryString(),
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
        foreach ($sorts as $sort) {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create($id)
    {

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\ProductTitle',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $productTitle = ProductTitle::where('product_id', $id)->orderBy('id', 'desc')->get();

        return Inertia::render('ProductTitle/Create', [
            'product_id' => $id,
            'productTitle' => $productTitle,
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
            'product_title' => ['required'],
        ]);
        $id = DB::table('product_titles')->max('id') + 1;

        $product = new ProductTitle();
        $product->id = $id;
        $product->product_id = $request->product_id;
        $product->company_id = Auth::user() ? Auth::user()->company_id : '';
        $product->product_title = $request->product_title;
        $product->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $request->product_id  .'}',
            'module' => $product,
            'activity' => 'Store',
            'type' => 'super',
            'path' => 'erp/add/product/title'.'/'.$request->product_id,
        ];

        $this->logable($module);


        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $productTitle = ProductTitle::where('product_id' , $id)->get();

        // return Inertia::render('ProductTitle/Create', [
        //     'product-titles' =>  $productTitle,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('update', ProductTitle::class);

        $productTitle = ProductTitle::where('product_id', $id)->get();
        $productTitle = ProductTitle::findorfail($id);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $productTitle->id  .'}',
            'module' => $productTitle,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice.'edit',
        ];

        $this->logable($module);



        return Inertia::render('ProductTitle/Create', [
            'productt' => $productTitle,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_title' => ['required'],
            'product_id' => ['required'],
        ]);
        $productTitleOld = ProductTitle::where('id',$request->id)->first();
        $productTitle =  ProductTitle::where('id', $request->id)->first();
        $productTitle->product_title = $request->product_title;

        // ProductTitle::where('id', $request->id)->update([
        //     "product_title" => $request->product_title,
        // ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $productTitle->id  .'}',
            'module' => $productTitle,
            'activity' => 'Update',
            'type' => 'erp',
            'path' =>  $slice.'edit',
        ];
        $logData =  $this->logable($module);
        $details = $productTitleOld;

		$final_data = json_encode($details);

         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->save();

        $productTitle->update();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $productTitle;

		$final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', ProductTitle::class);

        $ProductTitle = ProductTitle::findOrFail($id);
        $ProductTitle->delete();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $ProductTitle->id  .'}',
            'module' => $ProductTitle,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];
        $this->logable($module);

        return redirect()->back();
    }
}
