<?php

namespace Modules\PurchaseRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PurchaseRequisition\Repositories\PurchaseRequisitionRepository;

class PurchaseRequisitionController extends Controller
{
    public $purchaseRequisitionRepository;
    public $responseRepository;

    public function __construct(PurchaseRequisitionRepository $purchaseRequisitionRepository, ResponseRepository $rp)
    {
        $this->purchaseRequisitionRepository = $purchaseRequisitionRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getPurchaseListByUnitId",
     *     tags={"Purchase Requisition"},
     *     summary="getPurchaseListByUnitId",
     *     description="getPurchaseListByUnitId",
     *     operationId="getPurchaseListByUnitId",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-07-01", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-07-30", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPurchaseListByUnitId"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPurchaseListByUnitId(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;

        try {
            $data = $this->purchaseRequisitionRepository->getPurchaseListByUnitId($intUnitId, $dteStartDate, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Purchase Requisition List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getPurchaseListDetailsByPurchaseId",
     *     tags={"Purchase Requisition"},
     *     summary="getPurchaseListDetailsByPurchaseId",
     *     description="getPurchaseListDetailsByPurchaseId",
     *     operationId="getPurchaseListDetailsByPurchaseId",
     *     @OA\Parameter( name="intIndentID", description="intIndentID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPurchaseListDetailsByPurchaseId"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPurchaseListDetailsByPurchaseId(Request $request)
    {
        $intIndentID = $request->intIndentID;

        try {
            // $data = $this->purchaseRequisitionRepository->getPurchaseListDetailsByPurchaseId($intIndentID);
            $data = [
                'purchaseIndentOriginDetails' => $this->purchaseRequisitionRepository->getPurchaseOriginDetailsByRequisitionId($intIndentID),
                'purchaseIndentDetails' => $this->purchaseRequisitionRepository->getPurchaseListDetailsByPurchaseId($intIndentID)
            ];
            return $this->responseRepository->ResponseSuccess($data, 'Purchase Requisition Details');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/purchaseRequisition/storePurchaseRequisition",
     *     tags={"Purchase Requisition"},
     *     summary="Create Purchase Requisition",
     *     description="Create Purchase Requisition",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="dteDueDate", type="string", example="2020-08-17"),
     *                              @OA\Property(property="strIndentType", type="string", example="local"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=439590),
     *                              @OA\Property(property="intUnitID", type="integer", example=4),
     *                              @OA\Property(property="intWHID", type="integer", example=4),
     *                              @OA\Property(property="strAccountRemarks", type="string", example="Test Purpose"),
     *                              @OA\Property(property="intCostCenter", type="string", example=2322),
     *                              @OA\Property(property="intDepartmentID", type="integer", example=1),
     *                              @OA\Property(property="numQty", type="integer", example=2),
     *                              @OA\Property(property="intItemID", type="integer", example=924261),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="storePurchaseRequisition",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Purchase Requisition"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storePurchaseRequisition(Request $request)
    {
        try {
            $purchaseRequisition = $this->purchaseRequisitionRepository->storePurchaseRequisition($request);
            if (!is_null($purchaseRequisition)) {
                return $this->responseRepository->ResponseSuccess($purchaseRequisition, 'Purchase Requisition Created');
            }
            return $this->responseRepository->ResponseError(null, 'Purchase Requisition Create Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
