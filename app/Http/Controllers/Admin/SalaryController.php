<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Models\Employee;
use App\Models\Adjustment;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SalaryController extends Controller
{
    use Sort;
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $employees = Employee::query();
        $employees = $this->search($employees, [
            'name',
            'employee_id',
        ]);
        
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $employees = $this->sort($employees, $columns, $request->get('direction'));
        }

        $employees = $employees->withSum('salaries','net_total')->with('salaries.employee','adjustments')->get();
        $params = $request->all();

        return Inertia::render('Salary/Index', [
            'employees' => $employees,
            'params' => $params
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];

        foreach ([
            'name',
            'employee_id',
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
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Adjustment::updateOrCreate([        
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'employee_id' => $request->id,
            'amount' => $request->amount,
            'reason' => $request->reason,
        ]);

        return Redirect::route('salaries.index');
      

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
    
    //   Adjustment::where('salary_id ', $id)->update([        
    //         'company_id' => Auth::user() ? Auth::user()->company_id : '',
    //         'salary_id' => $id,
    //         'amount' => $request->amount,
    //         'reason' => $request->reason,
    //     ]);

    //     return Redirect::route('salaries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
