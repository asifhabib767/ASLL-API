<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\ASLLHR\Repositories\ASLLHRAttendanceRepository;

class ASLLHRAttendanceController extends Controller
{


    public $asllhrAttendanceRepository;
    public $responseRepository;


    public function __construct(ASLLHRAttendanceRepository $asllhrAttendanceRepository, ResponseRepository $rp)
    {
        $this->asllhrAttendanceRepository = $asllhrAttendanceRepository;
        $this->responseRepository = $rp;
    }


    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getHrAttendanceList",
     *     tags={"ASLLHR"},
     *     summary="Get Attendance List",
     *     description="Get Attendance List",
     *      operationId="getHrAttendanceList",
     *       @OA\Parameter( name="superviserId", description="Superviser ID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *       @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-07-01", required=false, in="query", @OA\Schema(type="string")),
     *       @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-07-30", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Response(response=200,description="Get Employee List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getHrAttendanceList(Request $request)
    {
        $intSuperviserId = $request->superviserId;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        try {
            $data = $this->asllhrAttendanceRepository->getHrAttendanceList($dteStartDate, $dteEndDate, $intSuperviserId);
            return $this->responseRepository->ResponseSuccess($data, 'Attendance List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getSuperviserAbesenceEmployee",
     *     tags={"ASLLHR"},
     *     summary="Get Absence List",
     *     description="Get Absence List",
     *      operationId="getSuperviserAbesenceEmployee",
     *       @OA\Parameter( name="superviserId", description="Superviser ID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *       @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-07-01", required=false, in="query", @OA\Schema(type="string")),
     *       @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-07-30", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Response(response=200,description="Get Employee List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSuperviserAbesenceEmployee(Request $request)
    {
        $intSuperviserId = $request->superviserId;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        try {
            $data = $this->asllhrAttendanceRepository->getSuperviserAbesenceEmployee($dteStartDate, $dteEndDate, $intSuperviserId);
            return $this->responseRepository->ResponseSuccess($data, 'Absence  List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
