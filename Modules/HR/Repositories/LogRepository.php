<?php

namespace Modules\HR\Repositories;

use App\Helpers\DistanceCalculator;
use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use stdClass;

class LogRepository
{
    public function  logInsert($inEmployeeId, $intApplicationId, $tableName, $description, $actionType)
    {

        if (!$inEmployeeId) {
            throw new \Exception('Enroll Not Found !');
        }

        $LeaveApplicationData =  DB::table(config('constants.DB_HR') . ".tblLeaveApplication")
            ->where('intApplicationId',  $intApplicationId)
            ->where('ysnApproved', 1)
            ->orwhere('ysnRejected', 1)
            ->first();




        if (is_null($LeaveApplicationData)) {
            DB::table(config('constants.DB_HR') . ".tblLeaveApplication")->insertGetId(
                [

                    'strAction' => $actionType,
                    'strDescription' => $description,
                    'strTblName' => $tableName,
                    'dteDate' => Carbon::now(),
                    'intUserID' => $inEmployeeId



                ]
            );
        }
    }
}
