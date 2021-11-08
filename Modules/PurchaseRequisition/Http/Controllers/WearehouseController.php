<?php

namespace Modules\PurchaseRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PurchaseRequisition\Repositories\WearehouseRepository;

class WearehouseController extends Controller
{
    public $wearehouseRepository;
    public $responseRepository;

    public function __construct(WearehouseRepository $wearehouseRepository, ResponseRepository $rp)
    {
        $this->wearehouseRepository = $wearehouseRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getWearehouseList",
     *     tags={"Warehouse"},
     *     summary="getWearehouseList",
     *     description="Wearehouse List By Unit",
     *     operationId="getWearehouseList",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getWearehouseList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getWearehouseList(Request $request)
    {
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->wearehouseRepository->getWearehouseListByUnitId($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Wearehouse List By Unit');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getWareHouseInformation",
     *     tags={"Warehouse"},
     *     summary="getWareHouseInformation",
     *     description="Wearehouse List By Unit",
     *     operationId="getWareHouseInformation",
     *     @OA\Parameter( name="intWHID", description="intWHID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getWareHouseInformation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getWareHouseInformation(Request $request)
    {
        $intWHID = $request->intWHID;
        try {
            $data = $this->wearehouseRepository->getWareHouseInformation($intWHID);
            return $this->responseRepository->ResponseSuccess($data, 'Wearehouse List By Unit');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getWearehouseListByEmployeePermissionForStore",
     *     tags={"Permission Wise Data"},
     *     summary="Get Wearehouse List By Employee Permission For Store",
     *     description="Get Wearehouse List By Employee Permission For Store",
     *     operationId="getWearehouseListByEmployeePermissionForStore",
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getWearehouseListByEmployeePermissionForStore"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getWearehouseListByEmployeePermissionForStore(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->wearehouseRepository->getWearehouseListByEmployeePermissionForStore($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Wearehouse List By Employee Permission For Store');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getWearehouseListByEmployeePermissionForRequisition",
     *     tags={"Permission Wise Data"},
     *     summary="Get Wearehouse List By Employee Permission For Requisition",
     *     description="Get Wearehouse List By Employee Permission For Requisition",
     *     operationId="getWearehouseListByEmployeePermissionForRequisition",
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getWearehouseListByEmployeePermissionForRequisition"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getWearehouseListByEmployeePermissionForRequisition(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->wearehouseRepository->getWearehouseListByEmployeePermissionForRequisition($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Wearehouse List By Employee Permission');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getWearehouseListByEmployeePermissionForIndent",
     *     tags={"Permission Wise Data"},
     *     summary="Get Wearehouse List By Employee Permission For Indent",
     *     description="Get Wearehouse List By Employee Permission For Indent",
     *     operationId="getWearehouseListByEmployeePermissionForIndent",
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getWearehouseListByEmployeePermissionForIndent"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getWearehouseListByEmployeePermissionForIndent(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->wearehouseRepository->getWearehouseListByEmployeePermissionForIndent($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Wearehouse List By Employee Permission');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getWearehouseListByEmployeePermissionForIndentApproval",
     *     tags={"Permission Wise Data"},
     *     summary="Get Wearehouse List By Employee Permission For Indent Approval",
     *     description="Get Wearehouse List By Employee Permission For Indent Approval",
     *     operationId="getWearehouseListByEmployeePermissionForIndentApproval",
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getWearehouseListByEmployeePermissionForIndentApproval"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getWearehouseListByEmployeePermissionForIndentApproval(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->wearehouseRepository->getWearehouseListByEmployeePermissionForIndentApproval($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Wearehouse List By Employee Permission');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getWearehouseListByEmployeePermissionForPO",
     *     tags={"Permission Wise Data"},
     *     summary="Get Wearehouse List By Employee Permission For PO",
     *     description="Get Wearehouse List By Employee Permission  For PO",
     *     operationId="getWearehouseListByEmployeePermissionForPO",
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getWearehouseListByEmployeePermissionForPO"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getWearehouseListByEmployeePermissionForPO(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->wearehouseRepository->getWearehouseListByEmployeePermissionForPO($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Wearehouse List By Employee Permission');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
