<?php

namespace App\Imports;

use DateTime;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendences;
use App\Models\AttendenceFile;
use App\Services\Traits\Logger;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AttendencesImport implements WithStartRow, ToCollection, WithHeadingRow
{
    use Logger;
    use DefaultActiveLog;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 2;
    }


        public function collection(Collection $rows)
        {

        
            $startingdate = $rows[0]['date'];
            $datefrom = Carbon::createFromFormat('d/m/Y', $startingdate)->format('Y-m-d');

            $endingdate = $rows[count($rows) - 1]['date'];
            $dateto = Carbon::createFromFormat('d/m/Y', $endingdate)->format('Y-m-d');

            $username = Auth::user()->name;
            $a = AttendenceFile::Create(
                [
                    'company_id' => Auth::user()->company_id,
                    'starting_date' => $datefrom,
                    'ending_date' => $dateto,
                    'user_name' => $username,
                ]
            );

            foreach ($rows as $row) {
            
                $format = $row['date'];
                $date = DateTime::createFromFormat('d/m/Y', $format)->format('Y-m-d');

                $onDuty = $row['on_duty'];
                $ofDuty = $row['off_duty'];
                $clockInTime = $row['clock_in'];
                $clockOutTime = $row['clock_out'];

                $clockIn = $row['clock_in'];
                $clockOut = $row['clock_out'];

                if ($clockIn && $onDuty) {
                    if ($clockIn > $onDuty) {
                        $onDuty = new Carbon($onDuty);
                        $clockIn = new Carbon($clockIn);
                        $late = $onDuty->diff($clockIn)->format('%H:%I:%S');
                        $parsed = date_parse($late);
                        $late = $parsed['hour'] * 60 + $parsed['minute'];
                        $early = 0;

                    } else {
                        $onDuty = new Carbon($onDuty);
                        $clockIn = new Carbon($clockIn);
                        $early = $onDuty->diff($clockIn)->format('%H:%I:%S');
                        $parsed = date_parse($early);
                        $early = $parsed['hour'] * 60 + $parsed['minute'];
                        $late = 0;
                    }
                }
                else{
                    $late = 0;
                    $early = 0;
                }
                
                $overtimes = $row['ot_time'];
                $parsed = date_parse($overtimes);
                $overtime_minutes = $parsed['hour'] * 60 + $parsed['minute'];

                $worktimes = $row['work_time'];
                $parsed = date_parse($worktimes);
                $work_time_minutes = $parsed['hour'] * 60 + $parsed['minute'];

                $attendanceTimes = $row['att_time'];
                $parsed = date_parse($attendanceTimes);
                $attendanceMinutes = $parsed['hour'] * 60 + $parsed['minute'];

                if ($attendanceMinutes >= 480) {
                    $overtime_minutes = $attendanceMinutes - 480;
                    $short_minutes = 0;
                } else {
                    $short_minutes = 480 - $attendanceMinutes;
                    $overtime_minutes = 0;
                }

            if ($row['clock_in'] && $row['clock_out']) {
                $isAbsent = 0;
            } else {
                $isAbsent = 1;
            }

                $attendences = Attendences::updateOrCreate(
                    [
                        'name' => $row['name'],
                        'date' => $date,
                    ],
                    [
                        'company_id' => Auth::user()->company_id,
                        'employee_number' => $row['emp_no'],
                        'name' => $row['name'],
                        'timetable' => $row['timetable'],
                        'date' => $date,
                        'on_duty_at' => $onDuty,
                        'off_duty_at' => $ofDuty,
                        'clock_in_at' => $clockInTime,
                        'clock_out_at' => $clockOutTime,
                        'late_minutes' => $late,
                        'early_minutes' => $early,
                        'is_absent' => $isAbsent,
                        'overtime_minutes' => $overtime_minutes,
                        'short_minutes' => $short_minutes,
                        'work_time_minutes' => $work_time_minutes,
                        'is_check_in_required' => $row['must_cin'] == 'True' ? '1' : '0',
                        'is_check_out_required' => $row['must_cout'] == 'True' ? '1' : '0',
                        'department' => $row['department'],
                        'normal_days' => ((int)$row['ndays']) + 0.00,
                        'is_weekend' => ((int)$row['weekend']) + 0.00,
                        'is_holiday' => ((int)$row['holiday']) + 0.00,
                        'attendance_minutes' => $attendanceMinutes,
                        'normal_days_over_time' => ((int)$row['ndays_ot']),
                        'weekend_over_time' => ((int)$row['weekend_ot']) + 0.00,
                        'holiday_over_time' => ((int)$row['holiday_ot']) + 0.00,
                    ]
                );

                $attendences->save();

                Employee::updateOrCreate(
                    [
                        'company_id' => Auth::user()->company_id,
                        'name' => $row['name'],
                    ],
                    [
                        'employee_id' => $row['emp_no'],
                        'name' => $row['name'],
                    ]
                );
            }
        }

    public function headingRow(): int
    {
        return 1;
    }
}
