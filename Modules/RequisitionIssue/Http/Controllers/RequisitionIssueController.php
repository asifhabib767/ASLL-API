<?php

namespace Modules\RequisitionIssue\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\RequisitionIssue\Repositories\RequisitionIssueRepository;

class RequisitionIssueController extends Controller
{
    public $requisitionIssueRepository;
    public $responseRepository;

    public function __construct(RequisitionIssueRepository $requisitionIssueRepository, ResponseRepository $rp)
    {
        $this->requisitionIssueRepository = $requisitionIssueRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/requisitionIssue/storeIssue",
     *     tags={"Requisition Issue"},
     *     summary="Create New Requisition Issue",
     *     description="Create New Requisition Issue",
     *         @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intSRID", type="integer", example=434586),
     *                              @OA\Property(property="strSrNo", type="string", example="REQ-Aug20-596"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=439590),
     *                              @OA\Property(property="strRecieveEmployeeName", type="string", example="Md. Maniruzzaman Akash"),
     *                              @OA\Property(property="strUseFor", type="string", example="Md. Maniruzzaman Akash"),
     *                              @OA\Property(property="intUnitID", type="integer", example=4),
     *                              @OA\Property(property="intWHID", type="integer", example=4),
     *                              @OA\Property(property="dteSrDate", type="string", example="2020-08-17"),
     *                              @OA\Property(property="intCostCenter", type="string", example=2322),
     *                              @OA\Property(property="intDept", type="integer", example=1),
     *                              @OA\Property(property="numQty", type="integer", example=2),
     *                              @OA\Property(property="intItemID", type="integer", example=924261),
     *                              @OA\Property(property="intSection", type="integer", example=17316),
     *                              @OA\Property(property="intLocation", type="integer", example=1),
     *                              @OA\Property(property="strSection", type="string", example="IT"),
     *                              @OA\Property(property="strReceivedBy", type="string", example="akash"),
     *                              @OA\Property(property="monValue", type="interger", example=10),
     *                              @OA\Property(property="strRemarks", type="string", example="Test Requisition Issue"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *     operationId="storeIssue",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create New Requisition Issue" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeIssue(Request $request)
    {
        $requisitionIssue = $this->requisitionIssueRepository->storeRequisitionIssue($request);

        try {
            $data = $requisitionIssue;
            return $this->responseRepository->ResponseSuccess($data, 'Store Issue Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/requisitionIssue/postFuelRequisitionEntry",
     *     tags={"Store Requisition"},
     *     summary="Create Fuel store Requisition",
     *     description="Create Fuel store Requisition",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitID", type="integer", example=4),
     *              @OA\Property(property="intSupplierID", type="integer", example=1),
     *              @OA\Property(property="strSupplierName", type="string", example="akash"),
     *              @OA\Property(property="dteRequisitionDate", type="string", example="2015-10-12"),
     *              @OA\Property(property="intEnrol", type="integer", example=392407),
     *              @OA\Property(property="strIssueRemarks", type="integer", example="just test"),
     *              @OA\Property(property="intUseFor", type="integer", example=1),
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intReqID", type="integer", example=1),
     *                              @OA\Property(property="intItemID", type="integer", example=1),
     *                              @OA\Property(property="strItemName", type="string", example="Disel"),
     *                              @OA\Property(property="numReqQty", type="float", example=1),
     *                              @OA\Property(property="numIssueQty", type="float", example=1),
     *                              @OA\Property(property="strIssueRemarks", type="string", example="just test"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="postFuelRequisitionEntry",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Fuel Log"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function postFuelRequisitionEntry(Request $request)
    {
        try {
            $storeRequisition = $this->requisitionIssueRepository->fuelRequisitionEntry($request);
            if (!is_null($storeRequisition)) {
                return $this->responseRepository->ResponseSuccess($storeRequisition, 'Store Requisition Created');
            }
            return $this->responseRepository->ResponseError(null, 'Store Requisition Create Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getStoreIssueListByUnitId",
     *     tags={"Requisition Issue"},
     *     summary="Store Issue List By Unit Id",
     *     description="Store Issue List By Unit Id",
     *     operationId="getStore Issue List By Unit Id",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intItemID", description="dteStartDate, eg; 2020-07-01", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-07-30", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Store Issue List By Unit Id"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreIssueListByUnitId(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $startDate = $request->dteStartDate;
        $endDate = $request->dteEndDate;

        try {
            $data = $this->requisitionIssueRepository->getStoreIssueList($intUnitId, $startDate, $endDate);
            return $this->responseRepository->ResponseSuccess($data, 'Store Issue List By Unit Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getStoreIssueListByWareHouseId",
     *     tags={"Requisition Issue"},
     *     summary="Store Issue List By wh id",
     *     description="Store Issue List By wh id",
     *     operationId="getStore Issue List By wh id",
     *     @OA\Parameter( name="intWHID", description="intWHID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-07-01", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-07-30", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Store Issue List By wh id"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreIssueListByWareHouseId(Request $request)
    {
        $intWHID = $request->intWHID;
        $startDate = $request->dteStartDate;
        $endDate = $request->dteEndDate;
        // return  $intWHID;
        try {
            $data = $this->requisitionIssueRepository->getStoreIssueListByWareHouseId($intWHID, $startDate, $endDate);
            return $this->responseRepository->ResponseSuccess($data, 'Store Issue List By Unit Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getStoreIssueRequisitionDetaills",
     *     tags={"Requisition Issue"},
     *     summary="Store Issue List By Requisition ID",
     *     description="Store Issue List By Requisition ID",
     *     operationId="getStore Issue List By Requisition ID",
     *     @OA\Parameter( name="intReqID", description="intReqID, eg; 1201359", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Store Issue List By Requisition ID"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getStoreIssueRequisitionDetaills(Request $request)
    {
        $intReqID = $request->intReqID;

        try {
            $data = $this->requisitionIssueRepository->getStoreIssueRequisitionDetaills($intReqID);
            return $this->responseRepository->ResponseSuccess($data, 'Store Issue List By Unit Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getDataExistOrNotExistInInventory",
     *     tags={"Requisition Issue"},
     *     summary="Store Issue Data Exist Or Not Exist",
     *     description="Store Issue Data Exist Or Not Exist",
     *     operationId="getStore Issue Data Exist Or Not Exist",
     *     @OA\Parameter( name="intInOutReffID", description="intInOutReffID, eg; 25870", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intItemID", description="intItemID, eg; 69829", required=false, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numTransactionQty", description="numTransactionQty, eg; -4", required=false, in="query", @OA\Schema(type="Float")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Store Issue Data Exist Or Not Exist"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataExistOrNotExistInInventory(Request $request)
    {
        $intInOutReffID = $request->intInOutReffID;
        $intItemID = $request->intItemID;
        $numTransactionQty = $request->numTransactionQty;

        try {
            $data = $this->requisitionIssueRepository->getDataExistOrNotExistInInventory($intInOutReffID, $intItemID, $numTransactionQty);
            return $this->responseRepository->ResponseSuccess($data, 'Store Issue List By Unit Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getDataExistencyInInventoryRunningBalance",
     *     tags={"Requisition Issue"},
     *     summary="Store Issue Data Exist Or Not Exist Invent Running Balance",
     *     description="Store Issue Data Exist Or Not Exist Invent Running Balance",
     *     operationId="getStore Issue Data Exist Or Not Exist Invent Running Balance",
     *     @OA\Parameter( name="intItemID", description="intItemID, eg; 25870", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intWHID", description="intWHID, eg; 69829", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Store Issue Data Exist Or Not Exist Invent Running Balance"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataExistencyInInventoryRunningBalance(Request $request)
    {
        $intItemID = $request->intItemID;
        $intWHID = $request->intWHID;


        try {
            $data = $this->requisitionIssueRepository->getDataExistencyInInventoryRunningBalance($intItemID, $intWHID);
            return $this->responseRepository->ResponseSuccess($data, 'Store Issue List By Unit Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/requisitionIssue/storeIssueTblInventoryRunningBalance",
     *     tags={"Running Balance Item insertion"},
     *     summary="Create New Running Balance Item insertion",
     *     description="Create New Running Balance Item insertion",
     *         @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="runningBalance",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intItemID", type="integer", example=69829),
     *                              @OA\Property(property="intWHID", type="integer", example=33),
     *                              @OA\Property(property="strName", type="string", example="Lace Paper Round"),
     *                              @OA\Property(property="strUOM", type="string", example="PKT"),
     *                              @OA\Property(property="numQuantity", type="decimal", example=1),
     *                              @OA\Property(property="monValue", type="decimal", example=4),

     *                          ),
     *                      ),
     *              )
     *      ),
     *     operationId="storeIssueTblInventoryRunningBalance",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create New Running Balance Item insertion" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeIssueTblInventoryRunningBalance(Request $request)
    {
        $requisitionIssue = $this->requisitionIssueRepository->storeIssueTblInventoryRunningBalance($request);

        try {
            $data = $requisitionIssue;
            return $this->responseRepository->ResponseSuccess($data, 'Store Issue Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getCustomerLoadingProfile",
     *     tags={"Customer"},
     *     summary="Customer profile By Id",
     *     description="Customer profile By Id",
     *     operationId="getCustomerLoadingProfile",
     *     @OA\Parameter( name="intCusID", description="intCusID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Customer profile By Id"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerLoadingProfile(Request $request)
    {
        $intCusID = $request->intCusID;

        // return  $intCusID;
        try {
            $data = $this->requisitionIssueRepository->getCustomerLoadingProfile($intCusID);
            return $this->responseRepository->ResponseSuccess($data, 'Customer Profile Details By Customer ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getItemVsDamage",
     *     tags={"SalesOrder"},
     *     summary="getItemVsDamage",
     *     description="getItemVsDamage",
     *     operationId="getItemVsDamage",
     *     @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getItemVsDamage"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItemVsDamage(Request $request)
    {
        $intID = $request->intID;
        $intUnitID = $request->intUnitID;
        // return  $intCusID;
        try {
            $data = $this->requisitionIssueRepository->getItemVsDamage($intID, $intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Item Damage Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/requisitionIssue/getSalesOfficeVsDiscount",
     *     tags={"SalesOrder"},
     *     summary="getSalesOfficeVsDiscount",
     *     description="getSalesOfficeVsDiscount",
     *     operationId="getSalesOfficeVsDiscount",
     *     @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalesOfficeVsDiscount"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalesOfficeVsDiscount(Request $request)
    {
        $intId = $request->intId;
        $intUnitId = $request->intUnitId;
        // return  $intCusID;
        try {
            $data = $this->requisitionIssueRepository->getSalesOfficeVsDiscount($intId, $intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Sales office Discount Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/requisitionIssue/DeliveryRequisition",
     *     tags={"DeliveryRequisition"},
     *     summary="Create New DeliveryRequisition",
     *     description="Create New DeliveryRequisition",
     *          @OA\Parameter( name="strRequestNo", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="dteRequestDateTime", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="intInsertBy", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="strVehicleProviderType", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="strVehicleType", description="strVehicleType, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="intUnitId", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="strLastDestination", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="strVehicleCapacity", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="ysnScheduleId", description="strRequestNo, eg; 1", required=false, in="query", @OA\Schema(type="boolean")),
     *          @OA\Parameter( name="decTotalQty", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="strDeliveryMode", description="strDeliveryMode, eg; Day", required=true, in="query", @OA\Schema(type="string")),
     *         @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intSalesOrderId", type="integer", example=439590),
     *                              @OA\Property(property="strSalesOrderCode", type="string", example="903203923"),
     *                              @OA\Property(property="intCustomerId", type="integer", example=439590),
     *                              @OA\Property(property="intDistPointId", type="integer", example=22),
     *                              @OA\Property(property="intBagType", type="integer", example=1),
     *                              @OA\Property(property="strBagType", type="string", example="Sewing"),
     *                              @OA\Property(property="strDestinationAddress", type="string", example="Address"),
     *                              @OA\Property(property="decQty", type="integer", example=4),
     *                          ),
     *                      ),
     *              )
     *      ),
     *     operationId="storeDeliveryRequisition ",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create New DeliveryRequisition" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeDeliveryRequisition(Request $request)
    {
        $requisitionIssue = $this->requisitionIssueRepository->DeliveryRequisition($request);

        try {
            $data = $requisitionIssue;
            return $this->responseRepository->ResponseSuccess($data, 'Delivery Requisition Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/requisitionIssue/ShipmentPlanning",
     *     tags={"ShipmentPlanning"},
     *     summary="Create New ShipmentPlanning",
     *     description="Create New ShipmentPlanning",
     *          @OA\Parameter( name="strRequestNo", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="dteRequestDateTime", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="intInsertBy", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="strVehicleProviderType", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="strVehicleType", description="strVehicleType, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="intUnitId", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="strLastDestination", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="strVehicleCapacity", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *          @OA\Parameter( name="ysnScheduleId", description="strRequestNo, eg; 1", required=false, in="query", @OA\Schema(type="boolean")),
     *          @OA\Parameter( name="decTotalQty", description="strRequestNo, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *          @OA\Parameter( name="strDeliveryMode", description="strDeliveryMode, eg; Day", required=true, in="query", @OA\Schema(type="string")),
     *         @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intSalesOrderId", type="integer", example=439590),
     *                              @OA\Property(property="strSalesOrderCode", type="string", example="903203923"),
     *                              @OA\Property(property="intCustomerId", type="integer", example=439590),
     *                              @OA\Property(property="intDistPointId", type="integer", example=22),
     *                              @OA\Property(property="intBagType", type="integer", example=1),
     *                              @OA\Property(property="strBagType", type="string", example="Sewing"),
     *                              @OA\Property(property="strDestinationAddress", type="string", example="Address"),
     *                              @OA\Property(property="decQty", type="integer", example=4),
     *                          ),
     *                      ),
     *              )
     *      ),
     *     operationId="storeShipmentPlanningSubmit ",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create New ShipmentPlanning" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeShipmentPlanningSubmit(Request $request)
    {
        $shipmentPlanning = $this->requisitionIssueRepository->ShipmentPlanning($request);

        try {
            $data = $shipmentPlanning;
            return $this->responseRepository->ResponseSuccess($data, 'Delivery ShipmentPlanning Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
