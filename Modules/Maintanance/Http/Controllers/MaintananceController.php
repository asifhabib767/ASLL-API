<?php

namespace Modules\Maintanance\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Maintanance\Repositories\MaintananceRepository;

class MaintananceController extends Controller
{
    public $maintananceRepository;
    public $responseRepository;


    public function __construct(MaintananceRepository $maintananceRepository, ResponseRepository $rp)
    {
        $this->maintananceRepository = $maintananceRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getAssetListByJobstation",
     *     tags={"Maintanance"},
     *     summary="getAssetListByJobstation",
     *     description="getAssetListByJobstation",
     *     operationId="getAssetListByJobstation",
     *     @OA\Parameter( name="intJobStationID", description="intJobStationID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getAssetListByJobstation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getAssetListByJobstation(Request $request)
    {
        $intJobStationID = $request->intJobStationID;
        // $intJobStationID = 4;

        try {
            $data = $this->maintananceRepository->getAssetListByJobstation($intJobStationID);
            return $this->responseRepository->ResponseSuccess($data, 'Asset List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getPlannedAssetListByJobstation",
     *     tags={"Maintanance"},
     *     summary="getPlannedAssetListByJobstation",
     *     description="getPlannedAssetListByJobstation",
     *     operationId="getPlannedAssetListByJobstation",
     *     @OA\Parameter( name="intJobstationID", description="intJobstationID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPlannedAssetListByJobstation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPlannedAssetListByJobstation(Request $request)
    {
        $intJobstationID = $request->intJobstationID;
        // return $intJobstationID = 10;

        try {
            $data = $this->maintananceRepository->getPlannedAssetListByJobstation($intJobstationID);
            return $this->responseRepository->ResponseSuccess($data, 'Asset List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getBreakDownAssetListByJobstation",
     *     tags={"Maintanance"},
     *     summary="getBreakDownAssetListByJobstation",
     *     description="getBreakDownAssetListByJobstation",
     *     operationId="getBreakDownAssetListByJobstation",
     *     @OA\Parameter( name="intJobStationID", description="intJobStationID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getBreakDownAssetListByJobstation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getBreakDownAssetListByJobstation(Request $request)
    {
        $intJobStationID = $request->intJobStationID;
        // $intJobStationID = 4;

        try {
            $data = $this->maintananceRepository->getBreakDownAssetListByJobstation($intJobStationID);
            return $this->responseRepository->ResponseSuccess($data, 'Asset List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getServiceNameListByWareHouse",
     *     tags={"Maintanance"},
     *     summary="getServiceNameListByWareHouse",
     *     description="getServiceNameListByWareHouse",
     *     operationId="getServiceNameListByWareHouse",
     *     @OA\Parameter( name="intWHID", description="intWHID, eg; 16", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getServiceNameListByWareHouse"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getServiceNameListByWareHouse(Request $request)
    {
        $intWHID = $request->intWHID;
        // return  $intWHID;
        try {
            $data = $this->maintananceRepository->getServiceNameListByWareHouse($intWHID);
            return $this->responseRepository->ResponseSuccess($data, 'Asset List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/maintanance/postMaintenanceEntry",
     *     tags={"Maintenance"},
     *     summary="Create Maintenance",
     *     description="Create Maintenance",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intWHID", type="integer", example=456),
     *                              @OA\Property(property="intItemTypeID", type="integer", example=19380),
     *                              @OA\Property(property="intItemID", type="integer", example=19380),
     *                              @OA\Property(property="numReqQty", type="integer", example=12),
     *                              @OA\Property(property="intDeptID", type="integer", example=14),
     *                              @OA\Property(property="dteReqDate", type="string", example="2015-10-12"),
     *                              @OA\Property(property="strRemarks", type="string", example="Test Purpose"),
     *                              @OA\Property(property="intInsertBy", type="integer", example=422905),
     *                              @OA\Property(property="intUnitID", type="integer", example=4),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="postMaintenanceEntry",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Maintenance"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function postMaintenanceEntry(Request $request)
    {
        try {
            $storeRequisition = $this->storeRequisitionRepository->storeStoreRequisition($request);
            if (!is_null($storeRequisition)) {
                return $this->responseRepository->ResponseSuccess($storeRequisition, 'Maintenance Created');
            }
            return $this->responseRepository->ResponseError(null, 'Maintenance Create Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getMaintenanceReportByReqID",
     *     tags={"Maintanance"},
     *     summary="getMaintenanceReportByReqID",
     *     description="getMaintenanceReportByReqID",
     *     operationId="getMaintenanceReportByReqID",
     *     @OA\Parameter( name="intReqID", description="intReqID, eg; 16", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getMaintenanceReportByReqID"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMaintenanceReportByReqID(Request $request)
    {
        $intReqID = $request->intReqID;
        // return  $intWHID;
        try {
            $data = $this->maintananceRepository->getMaintenanceReportByReqID($intReqID);
            return $this->responseRepository->ResponseSuccess($data, 'Req det List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getMaintenanceReportByUnit",
     *     tags={"Maintanance"},
     *     summary="getMaintenanceReportByUnit",
     *     description="getMaintenanceReportByUnit",
     *     operationId="getMaintenanceReportByUnit",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 16", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getMaintenanceReportByUnit"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMaintenanceReportByUnit(Request $request)
    {
        $intUnitID = $request->intUnitID;
        // return  $intUnitID;
        try {
            $data = $this->maintananceRepository->getMaintenanceReportByUnit($intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Asset List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getMaintenanceJobCard",
     *     tags={"Maintanance"},
     *     summary="getMaintenanceJobCard",
     *     description="getMaintenanceJobCard",
     *     operationId="getMaintenanceJobCard",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 16", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getMaintenanceJobCard"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMaintenanceJobCard(Request $request)
    {
        $intUnitID = $request->intUnitID;
        // return  $intUnitID;
        try {
            $data = $this->maintananceRepository->getMaintenanceJobCard($intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Job Card');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/maintanance/getMaintenanceWHList",
     *     tags={"Maintanance"},
     *     summary="getMaintenanceWHList",
     *     description="getMaintenanceWHList",
     *     operationId="getMaintenanceWHList",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 16", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getMaintenanceWHList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMaintenanceWHList(Request $request)
    {

        // return  $intUnitID;
        try {
            $data = $this->maintananceRepository->getMaintenanceWHList();
            return $this->responseRepository->ResponseSuccess($data, 'Job Card');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
