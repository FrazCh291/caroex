<?php

namespace App\Exports;

use App\Models\Attendence;
use App\Models\Attendences;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeAttendence implements  WithHeadings, WithMapping ,FromCollection
{
    protected $filter;

    public function __construct($filter , $filter1)
    {
        $this->filter = $filter;
        $this->filter1 = $filter1;
    }

    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $employee = Employee::findOrfail($this->filter1);
        $month = date("m", strtotime($this->filter));
        $year = date("Y", strtotime($this->filter));
        $employeeAttendence = Attendences::where('employee_number' , $employee->employee_id)->whereYear('date', $year)->whereMonth('date', '=', $month)->with('employee')->get();
        return $employeeAttendence;
    }

    public function map($employeeAttendence): array
    {
            return [
                [
                    $employeeAttendence->employee->name,
                    $employeeAttendence->date,
                    $employeeAttendence->clock_in_at,
                    $employeeAttendence->clock_in_at,
                    $employeeAttendence->late_minutes,
                    $employeeAttendence->overtime_minutes,
                    $employeeAttendence->short_minutes,
                    $employeeAttendence->work_time_minutes,
                    $employeeAttendence->is_absent,
                ]

            ];
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'NAME',
            'DATE',
            'CHECK IN',
            'CHECK OUT',
            'LATE MINUTES ',
            'OVER TIME MINUTES',
            'SHORT TIME MINUTES',
            'WORKING MINUTES',
            'STATUS',
        ];
    }
}
