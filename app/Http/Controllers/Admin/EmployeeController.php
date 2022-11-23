<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmployeeAttendence;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Address;
use App\Models\accounts;
use App\Models\Employee;
use App\Models\Documents;
use Illuminate\Support\Str;
use App\Models\Attendences;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    use Sort;
    use Filter;
    use Search;
   
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Employee::class);

        $employees = Employee::query();
        $employees = $request->get('disable') ? $employees->orWhere('is_status', 0) : $employees;
        $employees = $request->get('enable') ? $employees->where('is_status', 1) : $employees;
        $employees = $this->search($employees, [
            'name',
            'email',
            'phone',
            'cnic',
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $employees = $this->sort($employees, $columns, $request->get('direction'));
        }

        $employees = $employees->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Employees/Index', [
            'employees' => $employees->withQueryString(),
            'params' => $params,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Employee::class);

        return Inertia::render('Employees/Create');
    }

    public function createDocument($id)
    {
        $employee = Employee::with('documents')->where('id', $id)->first();

        return Inertia::render('Employees/DocumentCreate', [
            'employee' => $employee
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
            'name' =>'required|regex:/^[a-zA-Z]+$/u|max:20|unique:users,name',
            'email' => ['required', 'unique:employees', 'email', 'email:rfc,dns'],
            'address_1' => ['required'],
        ]);
        if ($request->file('image') == null) {
            $image = "";
        } else {
            $image = '/storage' . '/' . $request->file('image')->store('images');
        }

        if ($request->file('image_cnic') == null) {
            $imagecnic = "";
        } else {
            $imagecnic = '/storage' . '/' . $request->file('image_cnic')->store('images');
        }
        if ($request->file('image_cnic_1') == null) {
            $imagecnic1 = "";
        } else {
            $imagecnic1 = '/storage' . '/' . $request->file('image_cnic_1')->store('images');
        }

        if ($request->filled('cnic')) {
            $cnic = $request->cnic;
        } else {
            $cnic = "";
        }

        if ($request->filled('account_no')) {
            $account_no = $request->account_no;
        } else {
            $account_no = "";
        }
        
        $employee = Employee::create([
            'name' => $request->name,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'employee_id' =>mt_rand(10000000,99999999),
            'cnic' => $cnic,
            'image' => $image,
            'email' => $request->email,
            'phone' => $request->phone,
            'image_cnic' => $imagecnic,
            'image_cnic_1' => $imagecnic1,
            'is_status' => $request->is_status,
            'department' => $request->department,
            'fb_account' => $request->fb_account,
            'designation' => $request->designation,
            'total_salary' => $request->total_salary,
            'starting_date' => $request->starting_date,
            'github_account' => $request->github_account,
            'linkedin_account' => $request->linkedin_account,
            'total_working_days' => $request->total_working_days,
        ]);
            $employee->addresses()->create([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'city' => $request['city'],
                'county' => $request['county'],
                'country' => $request['country'],
                'postcode' => $request['postcode'],
                'address_1' => $request['address_1'],
                'address_2' => $request['address_2'],
            ]);
        accounts::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'is_employee' => True,
                'city' => $request['city'],
                'email' => $request->email,
                'account_no' => $account_no,
                'employee_id' => $employee->id,
                'first_name' => $request->name,
                'address' => $request['address_1'],
                'bank_name' => $request->bank_name,
                'postcode' => $request['postcode'],
                'account_title' => $request->account_title,
                'date_of_birth' => $request['date_of_birth'],
            ]
        );

        return Redirect::route('employees.index',)->with('success', 'Employee Created Successfully');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function docStore(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
            'file' => ['required'],
        ]);

        $employee = Employee::find($request->get('employee_id'));

        if ($request->file('file')) {
            $originalname = $request->file('file')[0]->getClientOriginalName();
            $path = 'storage/' . $request->file('file')[0]->storeAs('docoments', $originalname);
            $files = $request->file('file')[0];
            $mimeType = $files->getClientOriginalExtension();
        }

        $employee->documents()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'user_id' => Auth::user() ? Auth::user()->user_id : '',
            'title' => $request->title,
            'file' => $path,
            'file_type' => $mimeType,
            'description' => $request->description,
        ]);

        return Redirect::route('employees.show', $employee->id)->with('success', 'Document created successfully');
    }

  
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show(Request $request, $id)
    {
        $employeeRecord = Attendences::query();
        $employeeRecord = $this->search($employeeRecord, [
            'date',
            'on_duty_at',
            'clock_in_at',
            'clock_out_at',
            'short_minutes',
            'late_minutes',
            'overtime_minutes',
            'work_time_minutes',
        ]);

        $period = now()->subMonths(12)->monthsUntil(now());
        $data = [];
        foreach ($period as $date) {
            $data[] = [
                'month' => $date->shortMonthName . ' ' . $date->year,
            ];
        }
        $monthYear = array_reverse($data);
        $employeeRecord = $request->get('disable') ? $employeeRecord->where('is_absent', 0) : $employeeRecord;
        $employeeRecord = $request->get('enable') ? $employeeRecord->orWhere('is_absent', 1) : $employeeRecord;

        $employeeDocuments = Documents::where('documentable_id', $id)->get();
        $employee = Employee::findOrFail($id);
        $redate = 'Please Select';
        if ($request->has('dates')) {
            $redate = $request['dates'];
            $month = date("m", strtotime($request['dates']));
            $year = date("Y", strtotime($request['dates']));
            $employeeRecord = $employeeRecord->whereYear('date', $year)->whereMonth('date', '=', $month);
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $employeeRecord = $this->sort($employeeRecord, $columns, $request->get('direction'));

        }
        $employeeRecord = $employeeRecord->where('employee_number', $employee->employee_id)->orderBy('date' , 'desc')->get();
        $address = Address::where([['addressable_id', $id], ['addressable_type', 'App\Models\Employee']])->first();
        $accounts = accounts::where('employee_id', $id)->first();
        $lateMinute = $employeeRecord->sum('late_minutes');
        $overtimeMinute = $employeeRecord->sum('overtime_minutes');
        $present = $employeeRecord->where('clock_in_at', '!=', null)->Where('clock_out_at', '!=', null)->count();
        $params = $request->all();
    
        return Inertia::render('Employees/Show', [
            'employee' => $employee,
            'redate' => $redate,
            'employeeRecord' => $employeeRecord,
            'address' => $address,
            'monthYear' => $monthYear,
            'accounts' => $accounts,
            'lateMinute' => $lateMinute,
            'overtimeMinute' => $overtimeMinute,
            'present' => $present,
            'absent' => $employeeRecord->whereNull('clock_in_at')->whereNull('clock_out_at')->count(),
            'employeeDocuments' => $employeeDocuments,
            'params' => $params,
        ]);
    }

    public function exportAttendence(Request $request ,$id)
    {
        $employee = Employee::findOrfail($id);
        return Excel::download(new EmployeeAttendence($request->month, $id) , $employee->name." ".$request->month ." " .'Attendence.csv');
    }

    public function sortables(Request $request)
    {
        $sorts = [];

        foreach ([
                     'clock_in_at',
                     'email',
                     'phone',
                     'clock_out_at',
                     'late_minutes',
                     'overtime_minutes',
                     'work_time_minutes',
                     'date',
                     'employee_id',
                     'name',
                     'on_duty_at',
                     'short_minutes',
                     'is_status'
                 ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
    }

    public function edit($id)
    {

        $this->authorize('update', Employee::class);

        $employees = Employee::where('id', $id)->with('addresses', 'account')->first();


        return Inertia::render('Employees/Create', [
            'employees' => $employees
        ]);
    }


    public function editDocuments($id)
    {
        $document = Documents::where('id', $id)->first();
        $employees = Employee::where('id', $document->documentable_id)->first();

        return Inertia::render('Employees/DocumentCreate', [
            'document' => $document,
            'employees' => $employees
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
            'name' => ['required', 'string', 'max:100'],
            'employee_id' => ['required'],
            'address_1' => ['required'],
            'total_salary' => 'required|numeric|between:0,9999999.99',
        ]);


        if ($request->file('image') == null) {
            $image = "";
        } else {
            $image = '/storage' . '/' . $request->file('image')->store('images');
        }

        if ($request->file('image_cnic') == null) {
            $imagecnic = "";
        } else {
            $imagecnic = '/storage' . '/' . $request->file('image_cnic')->store('images');
        }
        if ($request->file('image_cnic_1') == null) {
            $imagecnic1 = "";
        } else {
            $imagecnic1 = '/storage' . '/' . $request->file('image_cnic_1')->store('images');
        }

        if ($request->filled('cnic')) {
            $cnic = $request->cnic;
        } else {
            $cnic = "";
        }

        if ($request->filled('account_no')) {
            $account_no = $request->account_no;
        } else {
            $account_no = "";
        }
        $employee = Employee::findOrFail($id);
        Employee::where('id', $id)->update([
            'name' => $request->name,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'employee_id' => $request->employee_id,
            'cnic' => $cnic,
            'image' => $image,
            'email' => $request->email,
            'phone' => $request->phone,
            'image_cnic' => $imagecnic,
            'image_cnic_1' => $imagecnic1,
            'is_status' => $request->is_status,
            'department' => $request->department,
            'fb_account' => $request->fb_account,
            'designation' => $request->designation,
            'starting_date' => $request->starting_date,
            'total_salary' => $request->total_salary,
            'github_account' => $request->github_account,
            'linkedin_account' => $request->linkedin_account,
            'total_working_days' => $request->total_working_days,
        ]);

        $address = Address::where([['addressable_id', $id], ['addressable_type', 'App\Models\Employee']])->first();
        if ($address) {
            $employee->addresses()->update([
                'company_id' => Auth::user()->company_id,
                'address_1' => $request['address_1'],
                'address_2' => $request['address_2'],
                'city' => $request['city'],
                'county' => $request['county'],
                'postcode' => $request['postcode'],
                'country' => $request['country'],
            ]);
        } else {
            $employee->addresses()->create([
                'company_id' => Auth::user()->company_id,
                'address_1' => $request['address_1'],
                'address_2' => $request['address_2'],
                'city' => $request['city'],
                'county' => $request['county'],
                'postcode' => $request['postcode'],
                'country' => $request['country'],
            ]);
        }
        accounts::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'is_employee' => True,
                'city' => $request['city'],
                'email' => $request->email,
                'account_no' => $account_no,
                'employee_id' => $employee->id,
                'first_name' => $request->name,
                'address' => $request['address_1'],
                'bank_name' => $request['bank_name'],
                'postcode' => $request['postcode'],
                'account_title' => $request['account_title'],
                'date_of_birth' => $request['date_of_birth'],
            ]
        );

        return Redirect::route('employees.show', $employee->id)->with('success', 'Employee Updated Successfully');
    }

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
        $employee = Employee::where('id', $document->documentable_id)->first();
        $employeeOld = Employee::where('id', $request)->first();

        return Redirect::route('employees.show', $employee->id)->with('success', 'Deal Document Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $this->authorize('delete', Employee::class);

        $employees = Employee::find($id);
        Attendences::where('employee_number', $employees->employee_id)->delete();
        Address::where([['addressable_id', $employees->employee_id], ['addressable_type', 'App\Models\Employee']])->delete();
        Documents::where([['documentable_id', $employees->employee_id], ['documentable_type', 'App\Models\Employee']])->delete();
        accounts::where('employee_id', $employees->employee_id)->delete();
        $employees->delete();

        return redirect()->route('employees.index');
    }

    public function delete($id)
    {
        $this->authorize('delete', Employee::class);

        $attendence = Attendences::find($id);
        $attendence->delete();

        return redirect()->back();
    }

    public function attendenceEdit($id, $erid)
    {
        $attendence = Attendences::select('id', 'name', 'employee_number', 'date', 'clock_in_at', 'clock_out_at', 'late_minutes', 'overtime_minutes', 'work_time_minutes', 'is_absent')
            ->where('id', $erid)->first();

        $attendence = Attendences::where('id', $erid)->first();
        return Inertia::render('Employees/Edit', [
            'attendence' => $attendence,
            'employeeId' => $id
        ]);
    }

    public function attendenceUpdate(Request $request)
    {

        $request->validate([
            'clock_in_at' => ['required'],
            'clock_out_at' => ['required'],
        ]);


        $attendence = Attendences::where('id', $request->id)->first();

        if ($request->clock_in_at) {

            $onDuty = new Carbon($attendence->on_duty_at);
            $clockIn = new Carbon($request->clock_in_at);

            if ($clockIn > $onDuty) {


                $clockIn = new Carbon($request->clock_in_at);

                $late = $onDuty->diff($clockIn)->format('%H:%I:%S');

                $parsed = date_parse($late);
                $late = $parsed['hour'] * 60 + $parsed['minute'];
                $early = 0;

            } else {
                $onDuty = new Carbon($onDuty);
                $clockIn = new Carbon($request->clock_in_at);
                $early = $onDuty->diff($clockIn)->format('%H:%I:%S');
                $parsed = date_parse($early);
                $early = $parsed['hour'] * 60 + $parsed['minute'];
                $late = 0;
            }
        } else {


            $late = 0;
            $early = 0;
        }


        $start = Carbon::parse($request->clock_in_at);
        $end = Carbon::parse($request->clock_out_at);
        $attendanceMinutes = $start->diffInMinutes($end);

        if ($attendanceMinutes >= 480) {
            $overtime_minutes = $attendanceMinutes - 480;
            $short_minutes = 0;
        } else {
            $short_minutes = 480 - $attendanceMinutes;
            $overtime_minutes = 0;
        }
        
        $attendence->name = $request->name;
        $attendence->employee_number = $request->employee_number;
        $attendence->date = $request->date;
        $attendence->clock_in_at = $request->clock_in_at;
        $attendence->clock_out_at = $request->clock_out_at;
        $attendence->late_minutes = $late;
        $attendence->early_minutes = $early;
        $attendence->overtime_minutes = $overtime_minutes;
        $attendence->short_minutes = $short_minutes;
        $attendence->attendance_minutes = $attendanceMinutes;
        $attendence->is_absent = 0;
        $attendence->save();

        $employee = Employee::where('employee_id', $attendence->employee_number)->first();

        return Redirect::route('employees.show', $employee->id)->with('success', 'Invoice update successfully');
    }

    public function fileExport($id)
    {
        $this->authorize('view', Employee::class);
        $employeeCvExport = Documents::where([['id', $id], ['documentable_type', 'App\Models\Employee']])->first();

        return response()->download(public_path($employeeCvExport->file));
    }

    public function viewFile($id)
    {
        $this->authorize('view', Employee::class);
        $employeeFileView = Documents::where('id', $id)->firstOrFail();

        return response()->file(public_path($employeeFileView->file));
    }

    public function deleteDocument($id)
    {
        $this->authorize('delete', Employee::class);
        
        $document = Documents::find($id)->delete();

        return redirect()->back();
    }
}
