<?php

namespace Modules\HR\Repositories;

use App\Helpers\DistanceCalculator;
use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\HR\Entities\EmployDuty;
use Modules\HR\Entities\EmployeeTracking;
use Modules\HR\Entities\Task;
use stdClass;

class TaskRepository
{
    public function getTaskAssignedToEmployee($intEmployeeId, $taskStatus = 'pending')
    {
        $query = Task::where('intAssignedTo', $intEmployeeId);
        if ($taskStatus != 'all') {
            $query->where('status', $taskStatus);
        }

        $query->orderBy('dteTaskStartDateTime', 'desc');

        $tasks = $query->get();
        return $tasks;
    }

    public function getTaskAssignedByEmployee($intEmployeeId, $taskStatus = 'pending')
    {
        $query = Task::where('intAssignedBy', $intEmployeeId);
        if ($taskStatus != 'all') {
            $query->where('status', $taskStatus);
        }

        $query->orderBy('dteTaskStartDateTime', 'desc');

        $tasks = $query->get();
        return $tasks;
    }


    public function storeNewTask(Request $request)
    {
        try {

            if ($request->intAssignedBy == $request->intAssignedTo) {
                $ysnOwnAssigned = true;
            } else {
                $ysnOwnAssigned = false;
            }

            $task = Task::create([
                'intUnitId' => $request->intUnitId,
                'strTaskTitle' => $request->strTaskTitle,
                'strTaskDetails' => $request->strTaskDetails,
                'intAssignedTo' => $request->intAssignedTo,
                'intAssignedBy' => $request->intAssignedBy,
                'dteTaskStartDateTime' => $request->dteTaskStartDateTime,
                'dteTaskEndDateTime' => $request->dteTaskEndDateTime,
                'ysnOwnAssigned' => $ysnOwnAssigned,
                'dteCreatedAt' => substr($request->dteTaskStartDateTime, 0, 9),
            ]);
            return $task;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateTask(Request $request, $intTaskId)
    {
        try {
            $task = Task::find($intTaskId);

            if (!is_null($task)) {
                $task = Task::where('intTaskId', $intTaskId)
                    ->update([
                        'strTaskTitle' => $request->strTaskTitle ? $request->strTaskTitle : $task->strTaskTitle,
                        'strTaskDetails' => $request->strTaskDetails ? $request->strTaskDetails : $task->strTaskDetails,
                        'strTaskUpdateDetails' => $request->strTaskUpdateDetails ? $request->strTaskUpdateDetails : $task->strTaskUpdateDetails,
                        'dteTaskStartDateTime' => $request->dteTaskStartDateTime ? $request->dteTaskStartDateTime : $task->dteTaskStartDateTime,
                        'dteTaskEndDateTime' => $request->dteTaskEndDateTime ? $request->dteTaskEndDateTime : $task->dteTaskEndDateTime,
                        'intUpdatedBy' => $request->intUpdatedBy,
                        'ysnSeenByAssignedTo' => $request->intUpdatedBy == $task->intAssignedTo ? true : false,
                        'ysnUpdateSeenByAssignedBy' => $request->intUpdatedBy == $task->intAssignedBy ? true : false,
                        'status' => $request->status ? $request->status : $task->status,
                    ]);
            }
            $task = Task::find($intTaskId);
            return $task;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeEmployeeTrack(Request $request)
    {
        try {
            $intEmployeeDutyID = $request->intDutyAutoID;
            $task = EmployeeTracking::create([
                'intUnitId' => $request->intUnitId,
                'intEmployeeID' => $request->intEmployeeID,
                'intEmployeeTypeID' => $request->intEmployeeTypeID,
                'dteDate' => $request->dteDate,
                'dtePunchInTime' => $request->dtePunchInTime,
                'dtePunchOutTime' => $request->dtePunchOutTime,
                'decLatitude' => $request->decLatitude,
                'decLongitude' => $request->decLongitude,
                'strLocation' => $request->strLocation,
                'ysnEnable' => true,
                'created_at' => carbon::now(),
            ]);

            $duty = EmployDuty::find($intEmployeeDutyID);
            if (!is_null($duty)) {
                $duty->intContactID = $request->intContactID;
                $duty->strContacName = $request->strContacName;
                $duty->ysnVisited = true;
                $duty->save();
            }
            return $task;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Get Duty info
     *

     * @param string $intCustomerId

     * @return void
     */
    public function getEmployeeDutyInfo($intEmployeeID)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployeeDuty");
        $query->select([
            'intDutyAutoID',
            'intTrackingID',
            'intEmployeeID',
            'intEmployeeTypeID',
            'strLocation',
            'decLatitude',
            'decLongitude',
            'ysnVisited',
            'intAssignedBy',
            'strRemarks',
            'intContactID',
            'strContacName'
        ])
            ->where('intEmployeeID', $intEmployeeID)
            ->where('ysnEnable', true)
            ->orderBy('intDutyAutoID', 'desc');

            if(request()->ysnVisited == "0"){
                $query->where('ysnVisited', false);
            }
            if(request()->ysnVisited == "1"){
                $query->where('ysnVisited', true);
            }

            $output = $query->get();
        return $output;
    }


    public function getEmployeePuchInfo($intEmployeeID)
    {
        $trackingHistory =EmployeeTracking::Join('tblEmployee', 'tblEmployeeTracking.intEmployeeID', '=', 'tblEmployee.intEmployeeID')
        ->orderBy('intAutoID', 'desc')
        ->where('tblEmployee.intEmployeeID', $intEmployeeID)
        ->select('tblEmployee.intUnitId','tblEmployee.intEmployeeID','intEmployeeTypeID','dteDate' ,'dtePunchInTime','dtePunchOutTime','decLatitude' ,'decLongitude' ,'strLocation','strEmployeeName')
        ->get();
        return $trackingHistory;
    }

    public function storeEmployee(Request $request)
    {
        try {
            $taskStore = EmployDuty::create([
            'intEmployeeID'=>$request->intEmployeeID, 
            'intEmployeeTypeID'=>$request->intEmployeeTypeID,
            'strLocation'=>$request->strLocation,
            'decLatitude'=>$request->decLatitude,
            'decLongitude'=>$request->decLongitude,
            'ysnVisited'=>$request->ysnVisited,
            'intAssignedBy'=>$request->intAssignedBy,
            'strRemarks'=>$request->strRemarks,
            'intContactID'=>$request->intContactID,
            'strContacName'=>$request->strContacName,
            'ysnEnable'=>$request->ysnEnable,
            'created_at'=>$request->created_at
            ]);
            return $taskStore;
        } catch (\Exception $e) {
            return false;
        }
    }
}
