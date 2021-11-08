<?php

namespace Modules\StoreRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\StoreRequisition\Repositories\StoreRequisitionRepository;

class StoreRequisitionController extends Controller
{
    public $storeRequisitionRepository;
    public $responseRepository;

    public function __construct(StoreRequisitionRepository $storeRequisitionRepository, ResponseRepository $rp)
    {
        $this->storeRequisitionRepository = $storeRequisitionRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/storeRequisition/getStoreListByUnitId",
     *     tags={"Store Requisition"},
     *     summary="getStoreListByUnitId",
     *     description="getStoreListByUnitId",
     *     operationId="getStoreListByUnitId",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getStoreListByUnitId"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreListByUnitId(Request $request)
    {
        $intUnitId = $request->intUnitId;

        try {
            $data = $this->storeRequisitionRepository->getRequisitionListByUnitId($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Requisition List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/storeRequisition/getStoreRequisitionListForIssue",
     *     tags={"Store Requisition"},
     *     summary="get Store Requisition List For  Issue",
     *     description="get Store Requisition List For  Issue",
     *     operationId="getStoreRequisitionListForIssue",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intWarehouseId", description="intWarehouseId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="get Store Requisition List For  Issue"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreRequisitionListForIssue(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        $intWarehouseId = $request->intWarehouseId;

        try {
            $data = $this->storeRequisitionRepository->getRequisitionListByUnitId($intUnitId, $dteStartDate, $dteEndDate, $intWarehouseId);
            return $this->responseRepository->ResponseSuccess($data, 'Requisition List For Issue');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/storeRequisition/getStoreRequisitionByEmployee",
     *     tags={"Store Requisition"},
     *     summary="get Store Requisition List Inserted By Employee",
     *     description="get Store Requisition List Inserted By Employee",
     *     operationId="getStoreRequisitionByEmployee",
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="get Store Requisition List Inserted By Employee"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreRequisitionByEmployee(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;

        try {
            $data = $this->storeRequisitionRepository->getRequisitionListByEmployeeId($intEmployeeId, $dteStartDate, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Requisition List By Employee');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/storeRequisition/getStoreRequisitionDetailsByRequisitionId",
     *     tags={"Store Requisition"},
     *     summary="getStoreRequisitionDetailsByRequisitionId",
     *     description="getStoreRequisitionDetailsByRequisitionId",
     *     operationId="getStoreRequisitionDetailsByRequisitionId",
     *     @OA\Parameter( name="intReqID", description="intReqID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getStoreRequisitionDetailsByRequisitionId"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreRequisitionDetailsByRequisitionId(Request $request)
    {
        $intReqID = $request->intReqID;

        try {
            // $data = $this->storeRequisitionRepository->getRequisitionDetailsByRequisitionId($intUnitId);
            $data = [
                'requisitionOriginDetails' => $this->storeRequisitionRepository->getRequisitionOriginDetailsByRequisitionId($intReqID),
                'requisitionItemDetails' => $this->storeRequisitionRepository->getRequisitionDetailsByRequisitionId($intReqID)
            ];
            return $this->responseRepository->ResponseSuccess($data, 'Requisition Details');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/storeRequisition/postStoreRequisitionEntry",
     *     tags={"Store Requisition"},
     *     summary="Create Store Requisition",
     *     description="Create Store Requisition",
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
     *      operationId="postStoreRequisitionEntry",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Store Requisition"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function postStoreRequisitionEntry(Request $request)
    {
        try {
            $storeRequisition = $this->storeRequisitionRepository->storeStoreRequisition($request);
            if (!is_null($storeRequisition)) {
                return $this->responseRepository->ResponseSuccess($storeRequisition, 'Store Requisition Created');
            }
            return $this->responseRepository->ResponseError(null, 'Store Requisition Create Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/storeRequisition/updateAndApproveRequisitionEntry",
     *     tags={"Store Requisition"},
     *     summary="Update and Approve Requisition",
     *     description="Update and Approve Requisition",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intReqID", type="integer", example=1),
     *              @OA\Property(property="intItemID", type="integer", example=1),
     *              @OA\Property(property="intApproveBy", type="integer", example=1),
     *              @OA\Property(property="numReqQty", type="integer", example=1),
     *              @OA\Property(property="quantity", type="integer", example=1),
     *          )
     *      ),
     *      operationId="updateAndApproveRequisitionEntry",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update and Approve Requisition"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateAndApproveRequisitionEntry(Request $request)
    {
        try {
            $storeRequisition = $this->storeRequisitionRepository->updateAndApproveStoreRequisition($request);
            return $this->responseRepository->ResponseSuccess($storeRequisition, 'Store Requisition Updated');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
