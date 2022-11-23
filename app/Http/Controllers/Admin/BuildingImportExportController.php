<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\BuildingAllImport;
use App\Exports\BuildingsAllExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;

class BuildingImportExportController extends Controller
{
    use DefaultActiveLog;

    function buildingImportExport()
    {
        return Inertia::render('Building/ImportExport/View', []);
    }

    public function fileImport(Request $request)
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\building',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);
        $request->validate([
            'file' => 'required|file|mimes:xlsx'
        ]);

        $file =  request()->file('file')->store('buildings');
    
        Excel::import(new BuildingAllImport(), $file);


        return redirect()->route('building.import.export')->with('success', 'File Imported Successfully');
    }

    function buildingAllExport()
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\building',
            'activity' => 'store',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        return Excel::download(new BuildingsAllExport, 'BuildingsAllData.xlsx');
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
