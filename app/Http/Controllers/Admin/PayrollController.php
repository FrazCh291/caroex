<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Salary;
use App\Models\Lookup;
use App\Models\Payroll;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Adjustment;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class PayrollController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payrolls = Payroll::query();
        $payrolls = $request->get('in_progress') ? $payrolls->orWhere('status', 'in_progress') : $payrolls;
        $payrolls = $request->get('complete') ? $payrolls->where('status', 'complete') : $payrolls;
        $payrolls = $request->get('deleted') ? $payrolls->where('status', 'deleted') : $payrolls;
        $payrolls = $this->search($payrolls, [
            'reference_no',
            'to',
            'from',
            'total_tax',
            'total_paid',
            'working_days',
            'no_of_employees',

        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $payrolls = $this->sort($payrolls, $columns, $request->get('direction'));
        }
        $payrolls = $payrolls->orderBy('id', 'desc')->with('salaries.employee', 'payrollStatus')->paginate(10);

        $payrollStatus = Lookup::where('type', 'payroll_status')->get();
        $employees = Employee::where('is_status', 1)->get();
        $bankAddress = Lookup::where('type' , 'bank_address')->get();

        $params = $request->all();
        $currencys = Lookup::where('type', 'currency')->get();
        $params['in_progress'] = $request->get('in_progress') == 'true' ? 'true' : '';
        $params['complete'] = $request->get('complete') == 'true' ? 'true' : '';
        $params['deleted'] = $request->get('deleted') == 'true' ? 'true' : '';

        return Inertia::render('Payroll/Index', [
            'params' =>  $params,
            'bankAddress' => $bankAddress,
            'currencys' => $currencys,
            'payrolls' =>  $payrolls,
            'employees' =>  $employees,
            'payrollStatus' =>  $payrollStatus
        ]);
    }
    public function sortables(Request $request)
    {
        $sorts = [];
        foreach ([
            'to',
            'from',
            'total_tax',
            'total_paid',
            'working_days',
            'reference_no',
            'no_of_employees',
            'gross',
            'tax',
            'total_addition',
            'total_detuction',
            'employee_id',
            'net_total',
            'total_salary',
            'total_working_days'

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Payroll/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employees = Employee::whereIn('id', $request->Saleryemployees)->with('attendence')->get();
        $monthYear =  date('Y-m', strtotime($request->from));
        $payroll = new Payroll();
        $payroll->company_id = Auth::user() ? Auth::user()->company_id : 1;
        $payroll->reference_no = $request->reference_no;
        $payroll->from = $request->from;
        $payroll->to = $request->to;
        $payroll->currency = $request->currency;
        $payroll->working_days = $request->working_days;
        $payroll->no_of_employees = count($request->Saleryemployees);
        $payroll->status = $request->status;
        $payroll->save();

        foreach ($employees as $employee) {
            $count = 0;
            $present = 0;
            foreach ($employee->attendence as $attendenceRecord) {
                $date = $attendenceRecord->date;
                $attendnceDate = date('Y-m', strtotime($date));
                $clockIn = $attendenceRecord->clock_in_at;
                $clockOut = $attendenceRecord->clock_out_at;

                if (($attendnceDate ===  $monthYear) && ($clockIn == !null || $clockOut == !null)) {
                    $present = $count + 1;
                    $count = $present;
                }
            }
            if ($present > $request->working_days) {
                $present = $request->working_days;
            }

            $absent = $request->working_days - $present;
            $salaryPerday =  $employee->total_salary / $request->working_days;
            $salaryDeduction = $salaryPerday * $absent;
            $salaryAmount =  $employee->total_salary - $salaryDeduction;

            if ($employee->total_salary > 50000) {
                $taxAmount = $employee->total_salary - 50000;
                $tax = 5 / 100 * $taxAmount;
                $net_total = $salaryAmount - $tax;
            } else {
                $tax = 0.00;
                $net_total =  $salaryAmount;
            }
            if ($net_total < 0) {
                $net_total = 0;
            }

            $payrollSalary = Payroll::latest()->first();
            $total_paid =  $payrollSalary->total_paid;
            $total_tax = $payrollSalary->total_tax;

            if ($payrollSalary == null) {

                $total_paid = 0.00;
                $total_tax = 0.00;
            } else {

                $total_paid =  $payrollSalary->total_paid;
                $total_tax = $payrollSalary->total_tax;
            }

            Payroll::updateOrCreate(
                [
                    'id' => $payroll->id,
                ],
                [
                    'total_tax' =>  $tax + $total_tax,
                    'total_paid' =>  $net_total +  $total_paid,
                ]
            );

            $payroll = Payroll::orderBy('id', 'DESC')->first();
            Salary::updateOrCreate(

                [
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'payroll_id' => $payroll->id,
                    'employee_id' => $employee->id,
                    'gross' => $net_total,
                    'tax' => $tax,
                    'date' => $request->to,
                    'currency' => $request->currency,
                    'total_detuction' =>  $salaryDeduction + $tax,
                    'net_total' => $net_total,
                ]
            );
        }

        return Redirect::route('payrolls.index');
    }

    public function searchEmployee(Request $request)
    {
        $employee = Employee::find($request->id);

        return response()->json([
            'employeeRecord' => $employee,
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $employeeSalary = Salary::query();
        $employeeSalary = $this->search($employeeSalary, [
            'gross',
            'net_total',
            'total_addition',
            'total_detuction',

        ]);
        if ($request->has('query')) {
            $employeeSalary = $employeeSalary->orWhereHas('employee', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortabless($request);
            $employeeSalary = $this->sort($employeeSalary, $columns, $request->get('direction'));
        }
        $employeeSalary = $employeeSalary->where('payroll_id', $id)->with('employee', 'adjustments', 'payroll')->paginate(10);
        if ($request->has('direction') && $request->get('employee_id')) {
            $sortedDta = $employeeSalary->getCollection()->sortBy(function ($employeeSalary) {
                return $employeeSalary->employee->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $employeeSalary->setCollection(collect($sort));
        }

        if ($request->has('direction') && $request->get('employee_salary')) {
            $sortedDta = $employeeSalary->getCollection()->sortBy(function ($employeeSalary) {
                return $employeeSalary->employee->total_salary;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $employeeSalary->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('total_working_days')) {
            $sortedDta = $employeeSalary->getCollection()->sortBy(function ($employeeSalary) {
                return $employeeSalary->employee->total_working_days;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $employeeSalary->setCollection(collect($sort));
        }

        $reasons = Lookup::where('type','reason')->get();
        $payrolldate = Payroll::select('from')->where('id' , $id)->first();
        $time = strtotime($payrolldate->from);
        $monthName = date('m',$time);
        $dateObj   = DateTime::createFromFormat('!m', $monthName);
        $payrollMonth = $dateObj->format('F'); 
        $employees = Employee::where('is_status', 1)->get();
        $salaryStatus = Lookup::where('type', 'Salary_status')->get();
        $currencys = Lookup::where('type', 'currency')->get();

        $params = $request->all();

        return Inertia::render('Payroll/Show', [
            'employeeSalary' => $employeeSalary,
            'reasons' => $reasons,
            'payrollMonth' => $payrollMonth,
            'employees' => $employees,
            'currencys' => $currencys,
            'salaryStatus' => $salaryStatus,
            'params' => $params,
            'payrollId' => $id,
        ]);
    }

    public function sortabless(Request $request)
    {
        $sorts = [];
        foreach ([
            'employee_id',
            'gross',
            'total_addition',
            'total_detuction',
            'tax',
            'status',
            'net_total',
            'total_salary',
            'total_working_days',

        ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
    }

    public function storePayrollItem(Request $request)
    {        
        // dd($request->all());
        $employee = Employee::where('id', $request['employee']['id'])->first();
        $salary = new Salary();
        $salary->company_id = Auth::user() ? Auth::user()->company_id : '';
        $salary->payroll_id = $request->payroll_id;
        $salary->employee_id = $employee->id;
        $salary->date = $request->employee['date'];
        $salary->status = $request->employee['status'];
        $salary->currency = $request->employee['currency'];
        $salary->gross = $request->employee['salary'];
        $salary->tax = 0;
        $salary->save();
        $totalAdjustmentAdditionValue = 0;
        $totalAdjustmentDeductValue = 0;

        foreach ($request['payrollitemsstore'] as $adjustment) {
            if($adjustment['reason'] == 'other_reason'){
                Adjustment::updateOrCreate([
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'salary_id' => $request->salary_id,
                    'amount' => $adjustment['value'],
                    'reason' =>  $request->employee['other_reason']
                ]);
            }else{

            Adjustment::updateOrCreate([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'salary_id' => $request->salary_id,
                'amount' => $adjustment['value'],
                'reason' => $adjustment['reason']
            ]);

            if ($adjustment['value'] > 0) {
                $totalAdjustmentAdditionValue += $adjustment['value'];
            } else {
                $totalAdjustmentDeductValue += $adjustment['value'];
            }
         }
        }
        // foreach ($request['payrollitemsstore'] as $adjustment) {
        //     Adjustment::create([
        //         'salary_id' => $salary->id,
        //         'amount' => $adjustment['value'],
        //         'reason' => $adjustment['reason'],
        //     ]);

        //     if ($adjustment['value'] > 0) {
        //         $totalAdjustmentAdditionValue += $adjustment['value'];
        //     } else {
        //         $totalAdjustmentDeductValue += $adjustment['value'];
        //     }
        // }
        $salaryDeduct = $salary->gross + $totalAdjustmentDeductValue;
        $salaryadd = $salaryDeduct + $totalAdjustmentAdditionValue;
        $salary->net_total =  $salaryadd;
        $salary->total_detuction = $totalAdjustmentDeductValue;
        $salary->total_addition =  $totalAdjustmentAdditionValue;

        $salary->save();

        $payroll = Payroll::where('id', $request->payroll_id)->first();
        $payroll->no_of_employees = $payroll->no_of_employees + 1;
        $payroll->total_paid = $payroll->total_paid + $totalAdjustmentDeductValue;
        $payroll->total_paid = $payroll->total_paid + $totalAdjustmentAdditionValue;
        $payroll->update();

        return redirect()->back();
    }



    public function Payslips($id)
    {
        // $salaries = Salary::with('employee')->where('payroll_id' , $id)->get();
        
        $salaries = Salary::where('payroll_id' , $id)->with(['employee','adjustments' => function ($query) {
            $query->select(DB::raw("SUM(amount) as total_amount,reason,salary_id"))
            ->groupBy('reason','salary_id');
        }])->get();
        $salaryMonth = Payroll::where('id', $id)->first();
        $time = strtotime($salaryMonth->from);
        $date = date('F Y',$time);
        $userCompanyId = Auth::user()->company_id;
        $companyName = Company::where('id', $userCompanyId)->firstOrFail(['name'])->name;
        $companyEmail = Company::where('id', $userCompanyId)->firstOrFail(['name'])->name;
        $companyAdress = Company::where('id', $userCompanyId)->with('addresses')->firstOrFail();
        $address =  $companyAdress->addresses[0]['address_1']. " " .$companyAdress->addresses[0]['address_2']. ","
         .$companyAdress->addresses[0]['town']. "," .$companyAdress->addresses[0]['city']. "," .
         $companyAdress->addresses[0]['county']. "," .$companyAdress->addresses[0]['postcode']. ","
         .$companyAdress->addresses[0]['country'];

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('f4', 'potrait');

        $pdf->loadView('PaySlip', [
            'date' => $date,
            'salaries' => $salaries,
            'companyName' => $companyName,
            'address' => $address,
            'companyEmail' => $companyEmail,
        ]);

        return $pdf->download('Payslips.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $employees = Employee::whereIn('id', $request->Saleryemployees)->with('attendence')->get();
        $monthYear =  date('Y-m', strtotime($request->from));
        $payrollSalary = Payroll::where('id', $id)->update([
            'total_paid' => 0,
            'total_tax'  => 0
        ]);

        Salary::where('payroll_id', $id)->delete();

        foreach ($employees as $employee) {
            $count = 0;
            $present = 0;

            foreach ($employee->attendence as $attendenceRecord) {
                $date = $attendenceRecord->date;
                $attendnceDate = date('Y-m', strtotime($date));
                $clockIn = $attendenceRecord->clock_in_at;
                $clockOut = $attendenceRecord->clock_out_at;

                if (($attendnceDate ===  $monthYear) && ($clockIn == !null || $clockOut == !null)) {
                    $present = $count + 1;
                    $count = $present;
                }
            }
            if ($present > $request->working_days) {
                $present = $request->working_days;
            }

            $absent = $request->working_days - $present;
            $salaryPerday =  $employee->total_salary / $request->working_days;
            $salaryDeduction = $salaryPerday * $absent;
            $salaryAmount =  $employee->total_salary - $salaryDeduction;

            if ($employee->total_salary > 50000) {
                $taxAmount = $employee->total_salary - 50000;
                $tax = 5 / 100 * $taxAmount;
                $net_total = $salaryAmount - $tax;
            } else {
                $tax = 0.00;
                $net_total =  $salaryAmount;
            }

            $payrollSalary = Payroll::where('id', $id)->first();
            $total_paid =  $payrollSalary->total_paid;
            $total_tax = $payrollSalary->total_tax;

            $payrollSalary->update(
                [
                    'reference_no' => $request->reference_no,
                    'from' =>   $request->from,
                    'to' =>   $request->to,
                    'no_of_employees' =>  count($request->Saleryemployees),
                    'working_days' =>   $request->working_days,
                    'currency' =>   $request->currency,
                    'status' =>   $request->status,
                    'total_tax' => $tax + $total_tax,
                    'total_paid' => $net_total +  $total_paid,
                ]
            );

            Salary::updateOrCreate(
                [
                    'payroll_id' => $id,
                    'employee_id' => $employee->id,
                ],
                [
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'payroll_id' => $id,
                    'employee_id' => $employee->id,
                    'currency' =>   $request->currency,
                    'gross' => $employee->total_salary,
                    'tax' => $tax,
                    'date' => $request->to,
                    'net_total' => $net_total,
                    'total_detuction' =>  $salaryDeduction + $tax,
                ]
            );
        }

        return Redirect::route('payrolls.index');
    }

    public function adjustment(Request $request, $id)
    {
        $totalAdjustmentAdditionValue = 0;
        $totalAdjustmentDeductValue = 0;

        foreach ($request['payrollitems'] as $adjustment) {
            if($adjustment['reason'] == 'other_reason'){
                Adjustment::updateOrCreate([
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'salary_id' => $request->salary_id,
                    'amount' => $adjustment['value'],
                    'reason' =>  $request->salary['other_reason']
                ]);
            }else{

            Adjustment::updateOrCreate([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'salary_id' => $request->salary_id,
                'amount' => $adjustment['value'],
                'reason' => $adjustment['reason']
            ]);
        }

            if ($adjustment['value'] > 0) {
                $totalAdjustmentAdditionValue += $adjustment['value'];
            } else {
                $totalAdjustmentDeductValue += $adjustment['value'];
            }
        }

        $salary = Salary::where('id', $request->salary_id)->where('payroll_id', $request->payroll_id)->first();
        $salary->company_id = Auth::user() ? Auth::user()->company_id : '';
        $salary->status = $request->salary['status'];
        $salary->currency = $request->salary['currency'];
        $salary->date = $request->salary['date'];
        $salary->total_addition = $salary->total_addition +  $totalAdjustmentAdditionValue;
        $salary->deduction = $salary->deduction +  $totalAdjustmentDeductValue;
        $salary->total_detuction = $salary->total_detuction - $salary->deduction;
        $salary->update();
        $nettotal = $salary->gross + $salary->total_addition;
        $net_total1 =    $nettotal  +  $salary->deduction;
        $total_salary =  $net_total1;
        $salary->net_total = $total_salary;

        $salary->update();


        $payroll = Payroll::where('id', $request->payroll_id)->first();
        $payroll->total_paid = $payroll->total_paid + $totalAdjustmentDeductValue;
        $payroll->total_paid = $payroll->total_paid + $totalAdjustmentAdditionValue;
        $payroll->update();



        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payroll = Payroll::find($id);
        $payroll->delete();

        return redirect()->back();
    }

    public function bankOrderLetter(Request $request, $id)
    {
        $employeeSalaries = Salary::where('payroll_id', $id)->with('employee.account')->get();
        $salaryMonth = Payroll::where('id', $id)->first();
        $time = strtotime($salaryMonth->from);
        $date = date('F Y',$time);
        $managerName = $request->manager;
        $bankAddress = $request->address;
        $userCompanyId = Auth::user()->company_id;
        $companyName = Company::where('id', $userCompanyId)->first(['name'])->name;
        $ceoName = Company::where('id', $userCompanyId)->first(['contact_name'])->contact_name;
        $companyAdress = Company::where('id', $userCompanyId)->with('addresses')->first();
        $address =  $companyAdress->addresses[0]['address_1']. " " .$companyAdress->addresses[0]['address_2']. ","
         .$companyAdress->addresses[0]['town']. "," .$companyAdress->addresses[0]['city']. "," .
         $companyAdress->addresses[0]['county']. "," .$companyAdress->addresses[0]['postcode']. ","
         .$companyAdress->addresses[0]['country'];


        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('f4', 'potrait');

        $pdf->loadView('bankorder', [
            'date' => $date,
            'companyName' => $companyName,
            'managerName' => $managerName,
            'bankAddress' => $bankAddress,
            'employeeSalaries' => $employeeSalaries,
            'ceoName' => $ceoName,
            'address' => $address,
        ]);

        return $pdf->download('Bank_order_letter.pdf');
    }

    public function cashOrderLetter($id)
    {

        $employeeSalaries = Salary::where('payroll_id', $id)->with('employee')->get();
        $salaryMonth = Payroll::where('id', $id)->first();
        $time = strtotime($salaryMonth->from);
        $date = date('F Y',$time);
        $userCompanyId = Auth::user()->company_id;
        $companyName = Company::where('id', $userCompanyId)->first(['name'])->name;
        $ceoName = Company::where('id', $userCompanyId)->first(['contact_name'])->contact_name;
        $companyAdress = Company::where('id', $userCompanyId)->with('addresses')->first();
        $address =  $companyAdress->addresses[0]['address_1']. " " .$companyAdress->addresses[0]['address_2']. ","
         .$companyAdress->addresses[0]['town']. "," .$companyAdress->addresses[0]['city']. "," .
         $companyAdress->addresses[0]['county']. "," .$companyAdress->addresses[0]['postcode']. ","
         .$companyAdress->addresses[0]['country'];

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('f4', 'potrait');

        $pdf->loadView('cashorder', [
            'date' => $date,
            'companyName' => $companyName,
            'employeeSalaries' => $employeeSalaries,
            'ceoName' => $ceoName,
            'address' => $address,
        ]);

        return $pdf->download('cash_order_letter.pdf');
    }

    public function deleteSalary($id)
    {
        Salary::find($id)->delete();

        return redirect()->back();
    }
}
