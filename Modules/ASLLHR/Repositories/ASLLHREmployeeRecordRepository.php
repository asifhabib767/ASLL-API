<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\Base64Encoder;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use stdClass;

class ASLLHREmployeeRecordRepository
{


    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeRecord($request)
    {
        // return $request;
        if (count($request) == 0) {
            return null;
        }

        try {
            DB::beginTransaction();

            foreach ($request as $record) {
                // return $record;
                $data = null;
                $data =  DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeRecord")->insert(
                    [
                        // Required Fields
                        "strRank" => $record['strRank'],
                        "strShipManager" => $record['strShipManager'],
                        "strVesselName" => $record['strVesselName'],
                        "strFlag" => $record['strFlag'],
                        "strVesselType" => $record['strVesselType'],
                        "strDWT" => $record['strDWT'],
                        "strEngineName" => $record['strEngineName'],
                        "strFromDate" => $record['strFromDate'],
                        "strToDate" => $record['strToDate'],
                        "strDuration" => $record['strDuration'],
                        "strReason" => $record['strReason'],
                        "intEmployeeId" => $record['intEmployeeId'],
                        "intUnitId" => $record['intUnitId'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }

            DB::commit();
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function updateEmployeeRecord($request)
    {
        if (!$request->intID) {
            throw new \Exception('Id Not Found !');
        }

        try {
            DB::beginTransaction();

            $data = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeRecord")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strRank' => $request->strRank,
                        'strShipManager' => $request->strShipManager,
                        'strVesselName' => $request->strVesselName,
                        'strFlag' => $request->strFlag,
                        'strVesselType' => $request->strVesselType,
                        'strDWT' => $request->strDWT,
                        'strEngineName' => $request->strEngineName,
                        'strFromDate' => $request->strFromDate,
                        'strToDate' => $request->strToDate,
                        'strDuration' => $request->strDuration,
                        'strReason' => $request->strReason,
                        'intEmployeeId' => $request->intEmployeeId,
                        'intUnitId' => $request->intUnitId,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]
                );


            DB::commit();
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }
}
