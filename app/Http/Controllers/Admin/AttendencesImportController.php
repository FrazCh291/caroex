<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Documents;
use App\Models\Attendences;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Models\AttendenceFile;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Imports\AttendencesImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Services\Traits\DefaultActiveLog;


class AttendencesImportController extends Controller
{
    use Sort;
    use Filter;
    use Search;
   

    function attendenceImport(Request $request)
    {
        $this->authorize('create', AttendenceFile::class);

        $datetimes = AttendenceFile::query();
        $datetimes = $request->get('enable') ? $datetimes->where('status', 1) : $datetimes;
        $datetimes = $request->get('disable') ? $datetimes->orWhere('status', 0) : $datetimes;
        $datetimes = $this->search($datetimes, [
            'user_name',
            'starting_date',
            'ending_date',
            'created_at',
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $datetimes = $this->sort($datetimes, $columns, $request->get('direction'));
        }

        $datetimes = $datetimes->orderby('id', 'desc')->with('documents')->paginate(10);
        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Attendence/Import/Index', [
            'datetimes' => $datetimes->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
                     'name',
                     'user_name',
                     'created_at',
                     'ending_date',
                     'clock_in_at',
                     'clock_out_at',
                     'late_minutes',
                     'starting_date',
                 ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
    }

    public function createAttendence()
    {

        return Inertia::render('Attendence/Import/Create');
    }

    public function fileImport(Request $request)
    {

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $fileName =  $file->getClientOriginalName();
                $extention = substr($fileName, strpos($fileName, ".csv"));
                $originalname = $file->getClientOriginalName();
                $path = 'storage/' . $file->storeAs('attendence', $originalname);
           
            }

            if($extention === ".csv") {
             
                Excel::import(new AttendencesImport, $file);
                $attendenceFile = AttendenceFile::orderBy('id', 'desc')->select('id')->first();
                $attendenceFile->documents()->create([
                    'company_id' => Auth::user()->company_id,
                    'file' => $path,
                    'title' => $originalname,
                    'description' => $originalname . " " . "Attendence-File",
                ]);
    
                return redirect()->route('attendence.import')->with('success', 'File Imported Successfully');
            } 
            
            else{
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'file' => ['The file must be a file of type: csv.']
                ]);
                throw $error;
            }


        }

        else{
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'file' => ['The file field is Required']
            ]);
            throw $error;
        }
 
       
    }

    public function fileExport($id)
    {
        $this->authorize('view', AttendenceFile::class);
        $attendenceFileExport = Documents::where('id', $id)->first();

        return response()->download(public_path($attendenceFileExport->file));
    }

    public function show(Request $request)
    {
        $this->authorize('view', AttendenceFile::class);

        $employeeAttendences = Attendences::query();
        $employeeAttendences = $employeeAttendences->where('deleted_at', null);

        $employeeAttendences = $this->search($employeeAttendences, [
            'name',
            'date',
            'clock_in_at',
            'clock_out_at',
        ]);

        $datetime = $request->all();
        if ($request->has('date') && !$request->has('query')) {
            $date = $datetime['date'] ? trim(date('Y-m-d', strtotime(Str::before($datetime['date'], ' ')))) : '';
            $totalemployees = Attendences::select('employee_number')->distinct()->where('date', $date)->get()->count();
            $ontime = Attendences::select('employee_number')->distinct()->where([['date', $date], ['late_minutes', 0]])->whereNotNull('clock_in_at')->where('deleted_at', null)->get()->count();
            $late = Attendences::select('employee_number')->distinct()->where([['date', $date], ['late_minutes', '>', 0]])->whereNotNull('clock_in_at')->where('deleted_at', null)->get()->count();
            $absent = Attendences::where([['date', $date], ['clock_in_at', '=', null], ['clock_out_at', '=', null]])->where('deleted_at', null)->get()->count();
            $present1 = Attendences::where('date', $date)->whereNotNull('clock_in_at')->whereNull('clock_out_at')->where('deleted_at', null)->get()->count();
            $present2 = Attendences::where('date', $date)->whereNotNull('clock_out_at')->whereNull('clock_in_at')->whereNotNull('clock_out_at')->where('deleted_at', null)->get()->count();
            $present3 = Attendences::where('date', $date)->whereNotNull('clock_in_at')->whereNotNull('clock_out_at')->where('deleted_at', null)->get()->count();
            $present = $present1 + $present2 + $present3;

            $employeeAttendences = $request->get('enable') ? $employeeAttendences->where('is_absent', 1) : $employeeAttendences;
            $employeeAttendences = $request->get('disable') ? $employeeAttendences->Where('is_absent', 0) : $employeeAttendences;

            if ($request->has('direction')) {
                $columns = $this->sortables($request);
                $employeeAttendences = $this->sort($employeeAttendences, $columns, $request->get('direction'));
            }
            

            $employeeAttendences = $employeeAttendences->where('date', $date)->get();
        } else if ($request->has('date') && $request->has('query')) {
            $date = $datetime['date'] ? trim(date('Y-m-d', strtotime(Str::before($datetime['date'], ' ')))) : '';
            $queryString = $request->all()['query'];
            $employeeAttendences = Attendences::where([['name', 'LIKE', "%$queryString%"], ['date', $date]])
                ->orWhere([['late_minutes', 'LIKE', "%$queryString%"], ['date', $date]])
                ->orWhere([['clock_in_at', 'LIKE', "%$queryString%"], ['date', $date]])
                ->orWhere([['clock_out_at', 'LIKE', "%$queryString%"], ['date', $date]])->get();

            $employeeAttendences = $request->get('disable') ? $employeeAttendences->orWhere('is_status', 0) : $employeeAttendences;
            $employeeAttendences = $request->get('enable') ? $employeeAttendences->where('is_status', 1) : $employeeAttendences;
            $totalemployees = Attendences::select('employee_number')->distinct()->where('date', $date)->get()->count();
            $ontime = Attendences::select('employee_number')->distinct()->where([['date', $date], ['late_minutes', 0]])->whereNotNull('clock_in_at')->get()->count();
            $late = Attendences::select('employee_number')->distinct()->where([['date', $date], ['late_minutes', '>', 0]])->whereNotNull('clock_in_at')->get()->count();
            $absent = Attendences::where([['date', $date], ['clock_in_at', '=', null], ['clock_out_at', '=', null]])->get()->count();
            $present1 = Attendences::where('date', $date)->whereNotNull('clock_in_at')->whereNull('clock_out_at')->get()->count();
            $present2 = Attendences::where('date', $date)->whereNotNull('clock_out_at')->whereNull('clock_in_at')->whereNotNull('clock_out_at')->get()->count();
            $present3 = Attendences::where('date', $date)->whereNotNull('clock_in_at')->whereNotNull('clock_out_at')->get()->count();
            $present = $present1 + $present2 + $present3;

            // $employeeAttendences = $request->get('enable') ? $employeeAttendences->where('is_absent', 1) : $employeeAttendences;
            // $employeeAttendences = $request->get('disable') ? $employeeAttendences->Where('is_absent', 0) : $employeeAttendences;

            if ($request->has('direction')) {
                $columns = $this->sortables($request);
                $employeeAttendences = $this->sort($employeeAttendences, $columns, $request->get('direction'));
            }
        } else {
            $totalemployees = Attendences::select('employee_number')->distinct()->get()->count();
            $date = date("Y-m-d", strtotime(Carbon::today()));
            $ontime = Attendences::select('employee_number')->distinct()->where([['date', $date], ['late_minutes', 0]])->whereNotNull('clock_in_at')->get()->count();
            $late = Attendences::select('employee_number')->distinct()->where([['date', $date], ['late_minutes', '>', 0]])->whereNotNull('clock_in_at')->get()->count();
            $absent = Attendences::where([['date', $date], ['clock_in_at', '=', null], ['clock_out_at', '=', null]])->get()->count();
            $present1 = Attendences::where('date', $date)->whereNotNull('clock_in_at')->whereNull('clock_out_at')->get()->count();
            $present2 = Attendences::where('date', $date)->whereNotNull('clock_out_at')->whereNull('clock_in_at')->whereNotNull('clock_out_at')->get()->count();
            $present3 = Attendences::where('date', $date)->whereNotNull('clock_in_at')->whereNotNull('clock_out_at')->get()->count();
            $present = $present1 + $present2 + $present3;

            $employeeAttendences = $request->get('enable') ? $employeeAttendences->where('is_absent', 1) : $employeeAttendences;
            $employeeAttendences = $request->get('disable') ? $employeeAttendences->orWhere('is_absent', 0) : $employeeAttendences;

            if ($request->has('direction')) {
                $columns = $this->sortables($request);
                $employeeAttendences = $this->sort($employeeAttendences, $columns, $request->get('direction'));
            }
            $employeeAttendences = Attendences::where('date', $date)->get();

        }

        $params = $request->all();

        return Inertia::render(
            'Attendence/Import/Show',
            [
                'date' => $date,
                'late' => $late,
                'params' => $params,
                'absent' => $absent,
                'ontime' => $ontime,
                'present' => $present,
                'totalemployees' => $totalemployees,
                'employeeAttendences' => $employeeAttendences,

            ]
        );

    }

    public function destroy($id)
    {
        $this->authorize('delete', AttendenceFile::class);

        $attendencefile = AttendenceFile::find($id);
        $attendencefile->delete();

        return redirect()->route('attendence.import');
    }

}
