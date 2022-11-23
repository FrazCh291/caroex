<?php

namespace App\Http\Controllers\Admin;

use App\Imports\BoomtekkImport;
use ZipArchive;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Import;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Imports\AmazonImport;
use App\Services\Traits\Sort;
use App\Imports\EjoggaImport;
use App\Imports\OrderTracking;
use App\Imports\GrouponImport;
use App\Imports\WowcherImport;
use App\Services\Traits\Logger;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Imports\GogroopieImport;
use App\Imports\XstreamgymImport;
use App\Exports\Orders\OrderExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Traits\DefaultActiveLog;

class ImportController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    public function index(Request $request)
    {
        $this->authorize('viewAny',Import::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Import',
            'activity' => 'view',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $imports = Import::query();
        $imports = $imports->where('company_id', Auth::user()->company_id);
        $imports = $request->get('enable') ? $imports->where('enable', 1) : $imports;
        $imports = $request->get('disable') ? $imports->orWhere('enable', 0) : $imports;
        $imports = $this->search($imports, [
            'file_name',
            'file_size',
            'number_of_rows',
            'user_id',
            'created_at',
        ]);

        if ($request->has('query')) {
            $imports = $imports->orWhereHas('channel', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $imports = $imports->orWhereHas('user', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $imports = $this->sort($imports, $columns, $request->get('direction'));
        }

        $imports = $imports->with('user', 'channel')->orderBy('id', 'desc')->paginate(10);

        if ($request->has('direction') && $request->get('channel_id')) {
            $sortedDta = $imports->getCollection()->sortBy(function ($import) {
                return $import->channel->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $imports->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('name')) {
            $sortedDta = $imports->getCollection()->sortBy(function ($product) {
                return $product->user->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $imports->setCollection(collect($sort));
        }

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Imports/Index', [
            'imports' => $imports->withQueryString(),
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
        foreach (['user_id', 'file_name',] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }
        return $sorts;
    }




    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create',Import::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Import',
            'activity' => 'store',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $products = Product::orderBy('name', 'asc')->get();

        $orderitems = OrderItem::with('order.import')->where('product_id', null)->paginate(10);

        return Inertia::render('Imports/Dropzone',
            ['orders' => $orderitems,
                'products' => $products
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'file'=>['array'],
//            'file.*'=>['mimetypes:text/plain']
//        ]);

//        $activeLog = new ActivityLog;
//        $className = get_class($activeLog);
//        $moduleName = Str::afterLast($className, '\\');
//        $modules = Module::where('name', $moduleName)->get();
//        dd($moduleName);
//        $activeLog->company_id = Auth::user()->company_id;
//        $activeLog->user_id = Auth::user()->id;
//        $activeLog->module_id = $moduleName;
//        $activeLog->activity = 'Import';
//        $activeLog->description = Auth::user()->name . ' '. 'Import the CSV file';
//        $activeLog->save();


        set_time_limit(1000);

        $date = Carbon::now();

        $replaceColon = str_replace(":", "-", $date->toDateString());

        $replaceSpace = str_replace(" ", "-", $replaceColon);

        $files = $request->file('file');
        // $mimeType = $files[0]->getMimeType();
        if (count($files) > 1) {
            foreach ($files as $filename) {
                $getFileTyper = $filename->getMimeType();
                if ($getFileTyper == 'application/zip') {

                    $zip = new ZipArchive();
                    if ($zip->open($filename)) {
                        $zip->setPassword(env('ZIP_FILE_PASSWORD'));
                        $zip->extractTo(public_path('storage/' . $replaceSpace . "/"));
                        if (!$zip->extractTo(public_path('storage/' . $replaceSpace . "/"))) {
                            ValidationException('in_valid_amount', 'Your given amount is more then your balance.');
                        }
                        $zip->close();
                    }
                    $path = public_path('storage/' . $replaceSpace);
                    $filenames = File::allFiles($path);

                    foreach ($filenames as $filename) {

                        $lowerCaseFileName = $filename->getFilename();
                        if (Str::contains($lowerCaseFileName, 'groupon') || Str::contains($lowerCaseFileName, 'Groupon')) {
                            $sale = SalesChannel::where('slug', 'groupon')->first();
                            $request['channel_id'] = $sale->id;
                            $filePath = $replaceSpace . "/" . $lowerCaseFileName;
                            $dbFilePath = "storage/" . $replaceSpace . "/" . $lowerCaseFileName;
                            Excel::import(new GrouponImport($dbFilePath), Storage::path($filePath));
                        }
                        if (Str::contains($lowerCaseFileName, 'gogroopie') || Str::contains($lowerCaseFileName, 'Gogroopie') || Str::contains($lowerCaseFileName, 'GOGROOPIE')) {
                            $sale = SalesChannel::where('slug', 'gogroopie')->first();
                            $request['channel_id'] = $sale->id;
                            $filePath = $replaceSpace . "/" . $lowerCaseFileName;
                            $dbFilePath = "storage/" . $replaceSpace . "/" . $lowerCaseFileName;
                            Excel::import(new GogroopieImport($dbFilePath), Storage::path($filePath));
                        }
                        if (Str::contains($lowerCaseFileName, 'wowcher') || Str::contains($lowerCaseFileName, 'Wowcher')) {
                            $sale = SalesChannel::where('slug', 'wowcher')->first();
                            $request['channel_id'] = $sale->id;
                            $filePath = $replaceSpace . "/" . $lowerCaseFileName;
                            $dbFilePath = "storage/" . $replaceSpace . "/" . $lowerCaseFileName;
                            Excel::import(new WowcherImport($dbFilePath), Storage::path($filePath));
                        }
                        if (Str::contains($lowerCaseFileName, 'xstreamgym') || Str::contains($lowerCaseFileName, 'Xstreamgym')) {
                            $sale = SalesChannel::where('slug', 'xstreamgym')->first();
                            $request['channel_id'] = $sale->id;
                            $filePath = $replaceSpace . "/" . $lowerCaseFileName;
                            $dbFilePath = "storage/" . $replaceSpace . "/" . $lowerCaseFileName;
                            Excel::import(new XstreamgymImport($dbFilePath), Storage::path($filePath));
                        }
                        if (Str::contains($lowerCaseFileName, 'tracking') || Str::contains($lowerCaseFileName, 'Tracking') || Str::contains($lowerCaseFileName, 'consignment') || Str::contains($lowerCaseFileName, 'Consignment')) {
                            $sale = SalesChannel::where('slug', 'tracking')->first();
                            $request['channel_id'] = $sale->id;
                            $filePath = $replaceSpace . "/" . $lowerCaseFileName;
                            $dbFilePath = "storage/" . $replaceSpace . "/" . $lowerCaseFileName;
                            Excel::import(new OrderTracking($dbFilePath), Storage::path($filePath));
                        }
                        if (Str::contains($lowerCaseFileName, 'amazon') || Str::contains($lowerCaseFileName, 'Amazon') || Str::contains($lowerCaseFileName, 'consignment') || Str::contains($lowerCaseFileName, 'Consignment')) {
                            $sale = SalesChannel::where('slug', 'amazon')->first();
                            $request['channel_id'] = $sale->id;
                            $filePath = $replaceSpace . "/" . $lowerCaseFileName;
                            $dbFilePath = "storage/" . $replaceSpace . "/" . $lowerCaseFileName;
                            Excel::import(new OrderTracking($dbFilePath), Storage::path($filePath));
                        }
                        if (Str::contains($lowerCaseFileName, 'boomtekk') || Str::contains($lowerCaseFileName, 'boomtekk') || Str::contains($lowerCaseFileName, 'consignment') || Str::contains($lowerCaseFileName, 'Consignment')) {
                            $sale = SalesChannel::where('slug', 'boomtekk')->first();
                            $request['channel_id'] = $sale->id;
                            $filePath = $replaceSpace . "/" . $lowerCaseFileName;
                            $dbFilePath = "storage/" . $replaceSpace . "/" . $lowerCaseFileName;
                            Excel::import(new BoomtekkImport($dbFilePath), Storage::path($filePath));
                        }
                    }

                } else {
                    $fileN = pathinfo($filename->getClientOriginalName(), PATHINFO_FILENAME);
                    $lowerCaseFileName = Str::lower($fileN);

                    if ($filename) {
                        $img = $filename;
                        $image = $img->getClientOriginalName();
                        $path = public_path('storage/' . $replaceSpace . "/");
                        $img->move($path, $image);
                    }

                    $path = 'storage/' . $replaceSpace . "/" . $image;
                    if (Str::contains($lowerCaseFileName, 'tracking') || Str::contains($lowerCaseFileName, 'Tracking') || Str::contains($lowerCaseFileName, 'consignment') || Str::contains($lowerCaseFileName, 'Consignment')) {
                        $sale = SalesChannel::where('slug', 'tracking')->first();
                        $request['channel_id'] = $sale->id;
                        Excel::import(new OrderTracking($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }
                    if (Str::contains($lowerCaseFileName, 'groupon') || Str::contains($lowerCaseFileName, 'Groupon')) {
                        $sale = SalesChannel::where('slug', 'groupon')->first();
                        $request['channel_id'] = $sale->id;

                        $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();

                        if (!$import) {
                            Excel::import(new GrouponImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                        } else {
                            $error = \Illuminate\Validation\ValidationException::withMessages([
                                'name' => ['This file is already exist']
                            ]);
                            throw $error;
                        }
//                        Excel::import(new GrouponImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }
                    if (Str::contains($lowerCaseFileName, 'gogroopie') || Str::contains($lowerCaseFileName, 'Gogroopie') || Str::contains($lowerCaseFileName, 'GOGROOPIE')) {

                        $sale = SalesChannel::where('slug', 'gogroopie')->first();
                        $request['channel_id'] = $sale->id;

                        $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                        if (!$import) {
                            Excel::import(new GogroopieImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                        } else {
                            $error = \Illuminate\Validation\ValidationException::withMessages([
                                'name' => ['This file is already exist']
                            ]);
                            throw $error;
                        }
//                        Excel::import(new GogroopieImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }
                    if (Str::contains($lowerCaseFileName, 'wowcher') || Str::contains($lowerCaseFileName, 'Wowcher')) {
                        $sale = SalesChannel::where('slug', 'wowcher')->first();
                        $request['channel_id'] = $sale->id;

                        $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                        if (!$import) {
                            Excel::import(new WowcherImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                        } else {
                            $error = \Illuminate\Validation\ValidationException::withMessages([
                                'name' => ['This file is already exist']
                            ]);
                            throw $error;
                        }
//                        Excel::import(new WowcherImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }

                    if (Str::contains($lowerCaseFileName, 'boomtekk') || Str::contains($lowerCaseFileName, 'Boomtekk')) {
                        dd('');
                        $sale = SalesChannel::where('slug', 'boomtekk')->first();
                        $request['channel_id'] = $sale->id;

                        $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                        if (!$import) {
                            Excel::import(new BoomtekkImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                        } else {
                            $error = \Illuminate\Validation\ValidationException::withMessages([
                                'name' => ['This file is already exist']
                            ]);
                            throw $error;
                        }
//                        Excel::import(new WowcherImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }
                    if (Str::contains($lowerCaseFileName, 'xstreamgym') || Str::contains($lowerCaseFileName, 'Xstreamgym')) {
                        $sale = SalesChannel::where('slug', 'xstreamgym')->first();
                        $request['channel_id'] = $sale->id;
                        $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();

                        if (!$import) {
                            Excel::import(new XstreamgymImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                        } else {
                            $error = \Illuminate\Validation\ValidationException::withMessages([
                                'name' => ['This file is already exist']
                            ]);
                            throw $error;
                        }
//                        Excel::import(new XstreamgymImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }
                    if (Str::contains($lowerCaseFileName, 'amazon') || Str::contains($lowerCaseFileName, 'Amazon')) {
                        $sale = SalesChannel::where('slug', 'amazon')->first();
                        $request['channel_id'] = $sale->id;

                        Excel::import(new AmazonImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }
                    if (Str::contains($lowerCaseFileName, 'ejogga') || Str::contains($lowerCaseFileName, 'Ejogga')) {
                        $sale = SalesChannel::where('slug', 'ejogga')->first();
                        $request['channel_id'] = $sale->id;
                        $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                        if (!$import) {
                            Excel::import(new EjoggaImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                        }
//                        else {
//                            $error = \Illuminate\Validation\ValidationException::withMessages([
//                                'name' => ['This file is already exist']
//                            ]);
//                            throw $error;
//                        }
                        Excel::import(new EjoggaImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                    }
                }
            }

            return $this->backFun();

        }
        else {

            $fileName = pathinfo($request->file('file')[0]->getClientOriginalName(), PATHINFO_FILENAME);

            $lowerCaseFileName = Str::lower($fileName);

            if ($request->file('file')[0]) {
                $img = $request->file('file')[0];
                $image = $img->getClientOriginalName();
                $path = public_path('storage/' . $replaceSpace . "/");
                $img->move($path, $image);
            }

            $path = 'storage/' . $replaceSpace . "/" . $image;

            if (Str::contains($lowerCaseFileName, 'wowcher')) {
                $sale = SalesChannel::where('slug', 'wowcher')->first();
                $request['channel_id'] = $sale->id;

                $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                if (!$import) {
                    Excel::import(new WowcherImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                } else {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'name' => ['This file is already exist']
                    ]);
                    throw $error;
                }
//                Excel::import(new WowcherImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
            }
            if (Str::contains($lowerCaseFileName, 'gogroopie')) {
                $sale = SalesChannel::where('slug', 'gogroopie')->first();
                $request['channel_id'] = $sale->id;

                $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                if (!$import) {
                    Excel::import(new GogroopieImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                } else {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'name' => ['This file is already exist']
                    ]);
                    throw $error;
                }
//                Excel::import(new GogroopieImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
            }
            if (Str::contains($lowerCaseFileName, 'boomtekk')) {
                $sale = SalesChannel::where('slug', 'boomtekk')->first();
                $request['channel_id'] = $sale->id;

                $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                if (!$import) {
                    Excel::import(new BoomtekkImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                } else {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'name' => ['This file is already exist']
                    ]);
                    throw $error;
                }
//                Excel::import(new GogroopieImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
            }
            if (Str::contains($lowerCaseFileName, 'groupon')) {
                $sale = SalesChannel::where('slug', 'groupon')->first();
                $request['channel_id'] = $sale->id;

                $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();

                if (!$import) {
                    Excel::import(new GrouponImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                } else {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'name' => ['This file is already exist']
                    ]);
                    throw $error;
                }
//                Excel::import(new GrouponImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
            }
            if (Str::contains($lowerCaseFileName, 'xstreamgym')) {

                $sale = SalesChannel::where('slug', 'xstreamgym')->first();
                $request['channel_id'] = $sale->id;
                $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
                if (!$import) {
                    Excel::import(new XstreamgymImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                } else {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'name' => ['This file is already exist']
                    ]);
                    throw $error;
                }
//                Excel::import(new XstreamgymImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
            }
            if (Str::contains($lowerCaseFileName, 'gym')) {
                $sale = SalesChannel::where('slug', 'xstreamgym')->first();
                $request['channel_id'] = $sale->id;

                Excel::import(new XstreamgymImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
            }
            if (Str::contains($lowerCaseFileName, 'amazon') || Str::contains($lowerCaseFileName, 'Amazon')) {
                $sale = SalesChannel::where('slug', 'amazon')->first();
                $request['channel_id'] = $sale->id;

                 Excel::import(new AmazonImport($path), public_path("storage/" . $replaceSpace . "/" . $image));

//                $this->logable($import, $lowerCaseFileName);
            }
            if (Str::contains($lowerCaseFileName, 'tracking') || Str::contains($lowerCaseFileName, 'Tracking') || Str::contains($lowerCaseFileName, 'consignment') || Str::contains($lowerCaseFileName, 'Consignment')) {
                $sale = SalesChannel::where('slug', 'tracking')->first();
                $request['channel_id'] = $sale->id;
                 Excel::import(new OrderTracking($path), public_path("storage/" . $replaceSpace . "/" . $image));

            }
            if (Str::contains($lowerCaseFileName, 'ejogga') || Str::contains($lowerCaseFileName, 'Ejogga')) {
                $sale = SalesChannel::where('slug', 'ejogga')->first();
                $request['channel_id'] = $sale->id;
                $import = Import::where('file_name', "storage/" . $replaceSpace . "/" . $image)->first();
//                dd($import, 'jjjjjjj');
//                $this->logable($import, $lowerCaseFileName);
                if (!$import) {
                    Excel::import(new EjoggaImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
////                    $this->logable($import, $lowerCaseFileName);
//                    $error = \Illuminate\Validation\ValidationException::withMessages([
//                        'name' => ['This file is already exist']
//                    ]);
//                    throw $error;
                } else {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'name' => ['This file is already exist']
                    ]);
                    throw $error;
//                    Excel::import(new EjoggaImport($path), public_path("storage/" . $replaceSpace . "/" . $image));
                }
            }
            return $this->backFun();
        }

        return $this->backFun();
    }

    public function backFun()
    {
        return redirect()->route('imports.index');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($id)
    {
        $this->authorize('create',Import::class);

       $attachment = Import::where('id', $id)->firstOrFail();
    //    $message = 'Export';
    //    $this->logable($attachment, $message);

        return response()->download(public_path($attachment->file_name));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportOrders()
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Import',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        return Excel::download(new OrderExport(), 'Orders.csv');
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
            'path' => $module['path'],
        ];

        $this->defaultLog($request);
    }

}
