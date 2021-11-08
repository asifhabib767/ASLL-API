<?php

namespace Modules\PurchaseRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PurchaseRequisition\Repositories\PurchaseRequisitionRepository;

class PurchaseRequisitionFileUploadController extends Controller
{

    public $purchaseRequisitionRepository;
    public $responseRepository;

    public function __construct(PurchaseRequisitionRepository $purchaseRequisitionRepository, ResponseRepository $rp)
    {
        $this->purchaseRequisitionRepository = $purchaseRequisitionRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/purchaseRequisition/fileInput",
     *     tags={"Purchase Requisition"},
     *     summary="Create Purchase Requisition File Input",
     *     description="Create Purchase Requisition File Input",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *                             @OA\Property(property="dteDueDate", type="string", example="2020-08-17"),
     *                              @OA\Property(property="intDepartmentId", type="integer", example=2),
     *                              @OA\Property(property="strDepartmentName", type="string", example="Maintenance"),
     *                              @OA\Property(property="intwarehouseId", type="integer", example=527),
     *                              @OA\Property(property="strWarehouseName", type="string", example="APL Central (Chhatak)"),
     *                              @OA\Property(property="uploadFile", type="string", example="Something"),
     *              )
     *      ),
     *      operationId="fileInput",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Purchase Requisition"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function fileInput(Request $request)
    {
        try {
            $purchaseRequisition = $this->purchaseRequisitionRepository->fileInput($request);

            if (!is_null($purchaseRequisition)) {
                return $this->responseRepository->ResponseSuccess($purchaseRequisition, 'Purchase Requisition Created');
            }
            return $this->responseRepository->ResponseError(null, 'Purchase Requisition Create Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
