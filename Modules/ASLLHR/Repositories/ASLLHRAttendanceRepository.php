<?php

namespace Modules\ASLLHR\Repositories;

// use App\Helpers\ImageUploadHelper;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Modules\ASLLHR\Entities\AsllEmployee;

class ASLLHRAttendanceRepository
{
    public function getHrAttendanceList($dteStartDate, $dteEndDate, $superviserId)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(7) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        $query = DB::table(config('constants.DB_HR') . ".tblEmployeeAttendance")
            ->join(config('constants.DB_HR') . ".tblEmployee", 'tblEmployeeAttendance.intEmployeeID', 'tblEmployee.intEmployeeID');
        $output = $query->select(
            [
                'tblEmployeeAttendance.intEmployeeID',
                'tblEmployeeAttendance.dteAttendanceDate',
                'tblEmployeeAttendance.intUserID',
                'tblEmployee.strEmployeeName',
                'tblEmployee.strOfficeEmail'
            ]
        )
            ->where('tblEmployee.intSuperviserId', $superviserId)
            ->whereBetween('tblEmployeeAttendance.dteAttendanceDate', [$startDate, $endDate])
            ->orderBy('tblEmployeeAttendance.dteAttendanceDate', 'DESC')
            ->get();
        return $output;
    }

    public function getSuperviserAbesenceEmployee($dteStartDate, $dteEndDate, $superviserId)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        $query = DB::table(config('constants.DB_HR') . ".tblAttendanceDailySummary")
            ->join(config('constants.DB_HR') . ".tblEmployee", 'tblAttendanceDailySummary.intEmployeeID', 'tblEmployee.intEmployeeID')
            ->join(config('constants.DB_HR') .  ".tblUserDesignation", 'tblEmployee.intDesignationID', 'tblUserDesignation.intDesignationID');

        $output = $query->select(
            [
                'tblEmployee.strEmployeeName',
                'tblUserDesignation.strDesignation',
                'tblAttendanceDailySummary.intYear',
                'tblAttendanceDailySummary.intMonthId',
                'tblAttendanceDailySummary.intDayId'
            ]
        )
            ->where('tblEmployee.intSuperviserId', $superviserId)
            // ->whereBetween('tblAttendanceDailySummary.dteAttendanceDate', [$startDate, $endDate])
            ->where('tblAttendanceDailySummary.intYear', 2020)
            ->where('tblAttendanceDailySummary.intMonthId', 10)
            ->where('tblAttendanceDailySummary.intDayId', 03)
            ->where('tblAttendanceDailySummary.ysnAbsent', 1)
            ->where('tblEmployee.ysnSalaryHold', 0)
            // ->whereBetween('tblEmployeeAttendance.dteAttendanceDate', [$startDate, $endDate])
            // ->orderBy('tblEmployeeAttendance.dteAttendanceDate', 'DESC')
            ->get();


        // $devices = [];
        // foreach ($query as $employeeAbsence) {
        //     $attendanceData = DB::table(config('constants.DB_HR') . ".tblEmployeeAttendance")
        //         // ->where('tblEmployeeAttendance.intEmployeeID', $employeeAbsence->intEmployeeID)
        //         ->where('tblEmployeeAttendance.dteAttendanceDate', date('2020-10-23'))
        //         ->where('tblEmployeeAttendance.intEmployeeID', 392407)
        //         ->first();

        //     if (is_null($attendanceData)) {
        //         array_push($devices, $employeeAbsence->strEmployeeName);
        //     }
        // }
        return $output;
    }
}
