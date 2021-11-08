<?php

namespace Modules\Expense\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Expense\Repositories\VehicleLogRepository;

class VehicleLogController extends Controller
{

    public $vehicleLogRepository;
    public $responseRepository;


    public function __construct(VehicleLogRepository $vehicleLogRepository, ResponseRepository $rp)
    {
        $this->vehicleLogRepository = $vehicleLogRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/vehicle/getVehicleLogList",
     *     tags={"VehicleLog"},
     *     summary="getVehicleLogList",
     *     description="getVehicleLogList",
     *     operationId="getVehicleLogList",
     *     @OA\Parameter(name="intActionBy", description="intActionBy, eg; 422905", example=422905, required=true, in="query", @OA\Schema(type="integer")),
      *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getVehicleLogList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVehicleLogList(Request $request)
    {
        $intActionBy = $request->intActionBy;
        try {
            $data = $this->vehicleLogRepository->getVehicleLogList($intActionBy);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Log List By Employeer ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/vehicle/getVehicleLogDetailsById",
     *     tags={"VehicleLog"},
     *     summary="getVehicleLogDetailsById",
     *     description="getVehicleLogDetailsById",
     *     operationId="getVehicleLogDetailsById",
     *     @OA\Parameter(name="intVehicleLogHeaderId", description="intVehicleLogHeaderId, eg; 5", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getVehicleLogDetailsById"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVehicleLogDetailsById(Request $request)
    {
        $intVehicleLogHeaderId = $request->intVehicleLogHeaderId;
        try {
            $data = $this->vehicleLogRepository->getVehicleLogDetailsById($intVehicleLogHeaderId);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Log Details By Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/vehicle/createVehicleLog",
     *     tags={"VehicleLog"},
     *     summary="Create New createVehicleLog",
     *     description="Create New createVehicleLog",
     *         @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="vehicleMultipleList",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intVehicleLogHeaderId", type="integer", example=1),
     *                              @OA\Property(property="strTravelCode", type="string", example="123456"),
     *                              @OA\Property(property="dteTravelDate", type="string", example="2020-10-19 00:00:00.000"),
     *                              @OA\Property(property="intAccountId", type="integer", example=1),
     *                              @OA\Property(property="intBusinessUnitId", type="integer", example=1),
     *                              @OA\Property(property="strBusinessUnitName", type="string", example=1),
     *                              @OA\Property(property="dteStartTime", type="string", example="08:10:10:000"),
     *                              @OA\Property(property="dteEndTime", type="string", example="10:10:10:000"),
     *                              @OA\Property(property="strFromAddress", type="string", example="Dhaka"),
     *                              @OA\Property(property="strToAddress", type="string", example="Faridpur"),
     *                              @OA\Property(property="intVehicleId", type="integer", example=1),
     *                              @OA\Property(property="strVehicleNumber", type="string", example="V-23213"),
     *                              @OA\Property(property="numVehicleStartMileage", type="float", example=1.1),
     *                              @OA\Property(property="numVehicleEndMileage", type="float", example=1),
     *                              @OA\Property(property="numVehicleConsumedMileage", type="float", example=1),
     *                              @OA\Property(property="intDriverId", type="integer", example=1),
     *                              @OA\Property(property="strDriverName", type="string", example="Abir"),
     *                              @OA\Property(property="intSBUId", type="integer", example=1),
     *                              @OA\Property(property="strSBUName", type="string", example="something"),
     *                              @OA\Property(property="numRate", type="float", example=1.3),
     *                              @OA\Property(property="numAmount", type="float", example=1),
     *                              @OA\Property(property="strExpenseLocation", type="string", example="Dhaka"),
     *                              @OA\Property(property="strVisitedPlaces", type="string", example="dhaka"),
     *                              @OA\Property(property="strAttachmentLink", type="string", example="/images"),
     *                              @OA\Property(property="isFuelPurchased", type="boolean", example=true),
     *                              @OA\Property(property="strPersonalUsage", type="string", example="23"),
     *                              @OA\Property(property="ysnActive", type="boolean", example="true"),
     *                              @OA\Property(property="intActionBy", type="integer", example=422905),
     *                          ),
     *                      ),
     *              )
     *      ),
     *     operationId="createVehicleLog ",
      *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create New createVehicleLog" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createVehicleLog(Request $request)
    {
        $requisitionIssue = $this->vehicleLogRepository->createVehicleLog($request->vehicleMultipleList);

        try {
            $data = $requisitionIssue;
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Log Submitted Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('expense::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('expense::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @OA\PUT(
     *      path="/api/v1/vehicle/vehicleMeterApprove",
     *      tags={"VehicleLog"},
     *      summary="Vehicle Meter Approve",
     *      description="Vehicle Meter Approve",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intVehicleLogHeaderId", type="integer", example=5),
     *              @OA\Property(property="ysnComplete", type="boolean", example=1),
     *              )
     *      ),
     *      operationId="vehicleMeterApprove",
      *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Vehicle Meter Approve"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function vehicleMeterApprove(Request $request)
    {
        try {
            $data = $this->vehicleLogRepository->vehicleMeterApprove($request, $request->intVehicleLogHeaderId);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Meter Approved Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
