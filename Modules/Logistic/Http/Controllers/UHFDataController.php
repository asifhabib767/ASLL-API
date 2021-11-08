<?php

namespace Modules\Logistic\Http\Controllers;

use App\Repositories\ResponseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use stdClass;

class UHFDataController extends Controller
{
    /**
     * @OA\POST(
     *     path="/api/v1/accl-vehicle/uhf-reader",
     *     tags={"ACCL Vehicle"},
     *     summary="Vehicle UHF Reader",
     *     description="Vehicle UHF Reader",
     *      operationId="storeUHFData",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Vehicle UHF Reader"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeUHFData(Request $request)
    {
        try {
            $id = DB::table("IOT.dbo.tblUHFReader")
            ->insertGetId(
                [
                    'deviceId' => $request->deviceId,
                    'timeStamp' => $request->timeStamp,
                    'totalLogs' => $request->totalLogs
                ]);

            if($request->logs && count($request->logs) > 0){
                foreach ($request->logs as $log) {
                    DB::table("IOT.dbo.tblUHFReaderLogDetail")
                    ->insertGetId(
                    [
                        'timeStamp' => $log['timeStamp'],
                        'type' => $log['type'],
                        'length' => $log['length'],
                        'data' => $log['data'],
                        'intlogID' => $id
                    ]);
                }

                $response = [];
                $item = [];
                $item['access'] = 1;
                $item['access_duration'] = 1;
                array_push($response, $item);
                return $response[0];
            }

            $response = [];
            $item = [];
            $item['status'] = 1;
            $item['id'] = $id;
            array_push($response, $item);
            return $response[0];

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/accl-vehicle/rotation-measure",
     *     tags={"ACCL Vehicle"},
     *     summary="Vehicle Rotation Meter",
     *     description="Vehicle Rotation Meter",
     *      @OA\Parameter( name="intTruckId", description="intTruckId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="intRotateCount", description="intRotateCount, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      operationId="rotationMeasure",
      *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Vehicle Rotation Meter"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function rotationMeasure(Request $request)
    {
        try {
            $id = DB::table("IOT.dbo.tblRotationTrack")
            ->insertGetId(
                [
                    'intTruckId' => $request->intTruckId,
                    'intRotateCount' => $request->intRotateCount,
                    'dteActionTime' => Carbon::now(),
                    'intUnitId' => $request->intUnitId
                ]);
            return ResponseRepository::ResponseSuccess($id, 'Successfully Added Vehicle Rotation Count');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
