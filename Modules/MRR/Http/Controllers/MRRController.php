<?php

namespace Modules\MRR\Http\Controllers;

use App\Repositories\ResponseRepository;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MRR\Http\Requests\POItemRequest;
use Modules\MRR\Repositories\MRRRepository;

class MRRController extends Controller
{


    public $mrrRepository;
    public $responseRepository;


    public function __construct(MRRRepository $mrrRepository, ResponseRepository $rp)
    {
        $this->mrrRepository = $mrrRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getPOType",
     *     tags={"MRR Requisition"},
     *     summary="getPOType",
     *     description="getPOType",
     *     operationId="getPOType",
    *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPOType"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPOType()
    {

        // return 1;
        try {
            $data = $this->mrrRepository->getPOType();
            return $this->responseRepository->ResponseSuccess($data, 'P.O Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/mrr/storeMRR",
     *     tags={"MRR Requisition"},
     *     summary="Create MR Requisition",
     *     description="Create MR Requisition",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intPOID", type="integer", example=1),
     *                              @OA\Property(property="intSupplierID", type="integer", example=2),
     *                              @OA\Property(property="intShipment", type="integer", example=2),
     *                              @OA\Property(property="dteChallan", type="string", example="2020-08-01"),
     *                              @OA\Property(property="monVatAmount", type="money", example=4),
     *                              @OA\Property(property="challanNo", type="string", example="Test Purpose"),
     *                              @OA\Property(property="strVatChallan", type="string", example="2322"),
     *                              @OA\Property(property="monProductCost", type="money", example=1),
     *                              @OA\Property(property="monOther", type="money", example=2),
     *                              @OA\Property(property="monDiscount", type="money", example=924261),
     *
     *                              @OA\Property(property="monBDTConversion", type="money", example="1"),
     *                              @OA\Property(property="intItemID", type="integer", example="2"),
     *                              @OA\Property(property="numPOQty", type="number", example=1),
     *                              @OA\Property(property="numPreRcvQty", type="number", example=4),
     *                              @OA\Property(property="numRcvQty", type="number", example=4),
     *                              @OA\Property(property="numRcvValue", type="number", example="21"),
     *                              @OA\Property(property="numRcvVatValue", type="number", example=5),
     *                              @OA\Property(property="locationId", type="integer", example=1),
     *                              @OA\Property(property="remarks", type="string", example="Test"),
     *                              @OA\Property(property="monRate", type="money", example=1.5),
     *
     *                              @OA\Property(property="poIssueBy", type="integer", example=1),
     *                              @OA\Property(property="batchNo", type="string", example="2"),
     *                              @OA\Property(property="expireDates", type="string", example="2020-08-18"),
     *                              @OA\Property(property="manufactureDate", type="string", example="2021-08-18"),
     *                              @OA\Property(property="ysnInventory", type="BOOLEAN", example=true),
     *                              @OA\Property(property="ysnProcess", type="BOOLEAN", example=true),
     *                              @OA\Property(property="intShipmentID", type="integer", example=6),
     *
     *
     *                         ),
     *                      ),
     *              )
     *      ),
     *      operationId="storeMRR",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create MR Requisition"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeMRR(Request $request)
    {
        try {
            $mrrRequisition = $this->mrrRepository->storeMRR($request);
            return $mrrRequisition;
            return $this->responseRepository->ResponseSuccess($mrrRequisition, 'MR Requisition Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getOthersInfo",
     *     tags={"MRR Requisition"},
     *     summary="getOthersInfo",
     *     description="getOthersInfo",
     *     operationId="getOthersInfo",
     *      @OA\Parameter( name="intPOID", description="intPOID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getOthersInfo"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getOthersInfo(Request $request)
    {


        $intPOID = $request->intPOID;
        // return 1;
        try {
            $data = $this->mrrRepository->getOthersInfo($intPOID);
            return $this->responseRepository->ResponseSuccess($data, 'unit wh supplier data');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getSupplierExistence",
     *     tags={"MRR Requisition"},
     *     summary="getSupplierExistence",
     *     description="getSupplierExistence",
     *     operationId="getSupplierExistence",
     *      @OA\Parameter( name="intSupplierID", description="intSupplierID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSupplierExistence"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupplierExistence(Request $request)
    {
        $intWHID = $request->intWHID;
        $strPoFor = $request->strPoFor;
        try {
            $data = $this->mrrRepository->getSupplierExistence($intWHID, $strPoFor);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Supplier Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Supplier Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getPOList",
     *     tags={"MRR Requisition"},
     *     summary="getPOList",
     *     description="getPOList",
     *     operationId="getPOList",
     *      @OA\Parameter( name="intWHID", description="intWHID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strPoFor", description="strPoFor, eg; Local", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPOList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPOList(Request $request)
    {
        $intWHID = $request->intWHID;
        $strPoFor = $request->strPoFor;


        try {
            $data = $this->mrrRepository->getPOList($intWHID, $strPoFor);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'PO Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'PO List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getPOVsWHNExchangrRate",
     *     tags={"MRR Requisition"},
     *     summary="getPOVsWHNExchangrRate",
     *     description="getPOVsWHNExchangrRate",
     *     operationId="getPOVsWHNExchangrRate",
     *      @OA\Parameter( name="intPOID", description="intPOID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPOVsWHNExchangrRate"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPOVsWHNExchangrRate(Request $request)
    {
        $intPOID = $request->intPOID;

        // return $intPOID;

        try {
            $data = $this->mrrRepository->getPOVsWHNExchangrRate($intPOID);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'PO Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'PO List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getPOVSItemDet",
     *     tags={"MRR Requisition"},
     *     summary="getPOVSItemDet",
     *     description="getPOVSItemDet",
     *     operationId="getPOVSItemDet",
     *      @OA\Parameter( name="intPOID", description="intPOID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="intWHId", description="intWHId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPOVSItemDet"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPOVSItemDet(POItemRequest $request)
    {
        $intPOID = $request->intPOID;
        $intWHId = $request->intWHId;

        // return $intPOID;

        try {
            $data = $this->mrrRepository->getPOVSItemDet($intPOID, $intWHId);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'PO Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'PO List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getPOVSItemDetForExport",
     *     tags={"MRR Requisition"},
     *     summary="getPOVSItemDetForExport",
     *     description="getPOVSItemDetForExport",
     *     operationId="getPOVSItemDetForExport",
     *      @OA\Parameter( name="intPOID", description="intPOID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="intWHId", description="intWHId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getPOVSItemDetForExport"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPOVSItemDetForExport(POItemRequest $request)
    {
        $intPOID = $request->intPOID;
        $intWHId = $request->intWHId;

        // return $intPOID;

        try {
            $data = $this->mrrRepository->getPOVSItemDetForExport($intPOID, $intWHId);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'PO Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'PO List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getwhStoreLocation",
     *     tags={"MRR Requisition"},
     *     summary="getwhStoreLocation",
     *     description="getwhStoreLocation",
     *     operationId="getwhStoreLocation",
     *      @OA\Parameter( name="intWHID", description="intWHID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getwhStoreLocation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */


    public function getwhStoreLocation(Request $request)
    {
        //return 1;

        $intWHID = $request->intWHID;

        // return $intWHID;

        try {
            $data = $this->mrrRepository->getwhStoreLocation($intWHID);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'PO Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'PO List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getwhItemList",
     *     tags={"MRR Requisition"},
     *     summary="getwhItemList",
     *     description="getwhItemList",
     *     operationId="getwhItemList",
     *      @OA\Parameter( name="intWHID", description="intWHID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="strItemFullName", description="strItemFullName, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getwhItemList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getwhItemList(Request $request)
    {

        $intWHID = $request->intWHID;
        $strItemFullName = $request->strItemFullName;
        // return $intWHID;
        // return $strItemFullName;
        try {
            $data = $this->mrrRepository->getwhItemList($intWHID, $strItemFullName);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Item Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Item List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getItemListByWearhouseAndBalance",
     *     tags={"MRR Requisition"},
     *     summary="getItemListByWearhouseAndBalance",
     *     description="getItemListByWearhouseAndBalance",
     *     operationId="getItemListByWearhouseAndBalance",
     *      @OA\Parameter( name="intWHID", description="intWHID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getItemListByWearhouseAndBalance"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItemListByWearhouseAndBalance(Request $request)
    {

        $intWHID = $request->intWHID;

        // return $intWHID;
        // return $strItemFullName;
        try {
            $data = $this->mrrRepository->getItemListByWearhouseAndBalance($intWHID);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Item Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Item List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/getStoreReqSupvAprvPendingTopSheet",
     *     tags={"MRR Requisition"},
     *     summary="getStoreReqSupvAprvPendingTopSheet",
     *     description="getStoreReqSupvAprvPendingTopSheet",
     *     operationId="getStoreReqSupvAprvPendingTopSheet",
     *      @OA\Parameter( name="intEnrollment", description="intEnrollment, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="dteFromdate", description="dteFromdate, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="dteTodate", description="dteTodate, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getStoreReqSupvAprvPendingTopSheet"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreReqSupvAprvPendingTopSheet(Request $request)
    {

        $intEnrollment = $request->intEnrollment;
        $dteFromdate = $request->dteFromdate;
        $dteTodate = $request->dteTodate;
        // return $intEnrollment;
        // return $dteFromdate;
        // return $dteTodate;



        try {
            $data = $this->mrrRepository->getStoreReqSupvAprvPendingTopSheet($intEnrollment,  $dteFromdate, $dteTodate);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Item Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Item List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/GetPendingDataforDeptHeadAprvdetails",
     *     tags={"MRR Requisition"},
     *     summary="GetPendingDataforDeptHeadAprvdetails",
     *     description="GetPendingDataforDeptHeadAprvdetails",
     *     operationId="GetPendingDataforDeptHeadAprvdetails",
     *      @OA\Parameter( name="intReqID", description="intReqID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetPendingDataforDeptHeadAprvdetails"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetPendingDataforDeptHeadAprvdetails(Request $request)
    {

        $intReqID = $request->intReqID;




        try {
            $data = $this->mrrRepository->GetPendingDataforDeptHeadAprvdetails($intReqID);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Item Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Item List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/mrr/Getrequisitionwhichareunapproved",
     *     tags={"MRR Requisition"},
     *     summary="Getrequisitionwhichareunapproved",
     *     description="Getrequisitionwhichareunapproved",
     *     operationId="Getrequisitionwhichareunapproved",
     *      @OA\Parameter( name="intEnrollment", description="intEnrollment, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="dteFromdate", description="dteFromdate, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="dteTodate", description="dteTodate, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Getrequisitionwhichareunapproved"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function Getrequisitionwhichareunapproved(Request $request)
    {

        $intEnrollment = $request->intEnrollment;
        // return  $intEnrollment;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;


        try {
            $data = $this->mrrRepository->Getrequisitionwhichareunapproved($intEnrollment, $dteStartDate,  $dteEndDate);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Item Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Item List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/mrr/GetrequisitionDetailswhichareunapproved",
     *     tags={"MRR Requisition"},
     *     summary="GetrequisitionDetailswhichareunapproved",
     *     description="GetrequisitionDetailswhichareunapproved",
     *     operationId="GetrequisitionDetailswhichareunapproved",
     *      @OA\Parameter( name="intReqID", description="intReqID, eg; 1218689", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetrequisitionDetailswhichareunapproved"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetrequisitionDetailswhichareunapproved(Request $request)
    {

        $intReqID = $request->intReqID;




        try {
            $data = $this->mrrRepository->GetrequisitionDetailswhichareunapproved($intReqID);
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Item Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Item List Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
