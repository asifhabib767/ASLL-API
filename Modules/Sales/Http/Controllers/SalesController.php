<?php

namespace Modules\Sales\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Sales\Repositories\SalesRepository;

class SalesController extends Controller
{

    public $salesRepository;
    public $responseRepository;

    public function __construct(SalesRepository $salesRepository, ResponseRepository $rp)
    {
        $this->salesRepository = $salesRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/sales/storeSalesOrderEntry",
     *     tags={"SalesOrder"},
     *     summary="Create Sales Order",
     *     description="Create Sales Order",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="salesorders",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intProductId", type="integer", example=761),
     *                              @OA\Property(property="qnt", type="integer", example=1),
     *                              @OA\Property(property="pr", type="integer", example=10),
     *                              @OA\Property(property="intCOAAccId", type="integer", example=38144),
     *                              @OA\Property(property="strCOAAccName", type="string", example="Portland Composit Cement L"),
     *                              @OA\Property(property="monConversionRate", type="integer", example=1),
     *                              @OA\Property(property="intCurrencyID", type="integer", example=1),
     *                              @OA\Property(property="intExtraId", type="integer", example=4),
     *                              @OA\Property(property="monExtraPrice", type="integer", example=0),
     *                              @OA\Property(property="intUom", type="integer", example=12),
     *                              @OA\Property(property="strNarration", type="string", example="test"),
     *                              @OA\Property(property="intSalesType", type="integer", example=12),
     *                              @OA\Property(property="intVehicleVarId", type="integer", example=14841),
     *                              @OA\Property(property="numPromotion", type="integer", example=0),
     *                              @OA\Property(property="monCommission", type="integer", example=0),
     *                              @OA\Property(property="intIncentiveId", type="integer", example=4),
     *                              @OA\Property(property="numIncentive", type="integer", example=0),
     *                              @OA\Property(property="monSuppTax", type="integer", example=0),
     *                              @OA\Property(property="monVAT", type="integer", example=0),
     *                              @OA\Property(property="monVatPrice", type="integer", example=0),
     *                              @OA\Property(property="intPromItemId", type="integer", example=761),
     *                              @OA\Property(property="strPromItemName", type="string", example="Portland Composit Cement L"),
     *                              @OA\Property(property="intPromUOM", type="integer", example=12),
     *                              @OA\Property(property="monPromPrice", type="integer", example=0),
     *                               @OA\Property(property="intPromItemCOAId", type="integer", example=38144),
     *                              @OA\Property(property="intInsertedBy", type="integer", example=1272),
     *                              @OA\Property(property="numWeight", type="integer", example=0),
     *                              @OA\Property(property="numVolume", type="integer", example=0),
     *                              @OA\Property(property="numPromWeight", type="integer", example=0),
     *                              @OA\Property(property="numPromVolume", type="integer", example=0),
     *                              @OA\Property(property="decDiscountAmount", type="integer", example=0),
     *                              @OA\Property(property="decDiscountRate", type="integer", example=0),
     *                              @OA\Property(property="numRestQuantity", type="integer", example=0),
     *                         ),
     *                      ),
     *              )
     *      ),
     *      operationId="storeSalesOrderEntry",
     *     @OA\Parameter( name="intUserID", description="intUserID, eg; 1", required=true, in="query", example= 1272, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 1", required=true, in="query", example= 4, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteDate", description="dteDate, eg; 2020-08-30", required=true, in="query", example= "2020-08-30", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteDODate", description="dteDODate, eg; 2020-08-30", required=true, in="query", example= "2020-08-30", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intCustomerType", description="intCustomerType, eg; 5", required=true, in="query", example=5, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 302667", required=true, in="query", example= 302667, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intDisPointId", description="intDisPointId, eg; 14651", required=true, in="query", example= 14651, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strNarration", description="strNarration, eg; test", required=true, in="query", example= "test nar", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strAddress", description="strAddress, eg; test adr", required=true, in="query", example= "test adr", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intPriceVarId", description="intPriceVarId, eg; 30", required=true, in="query", example=30, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intVehicleVarId", description="intVehicleVarId, eg; 14841", required=true, in="query", example= 14841, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnLogistic", description="ysnLogistic, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="intChargeId", description="intChargeId, eg; 4", required=true, in="query", example= 4, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numCharge", description="numCharge, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intIncentiveId", description="intIncentiveId, eg; 4", required=true, in="query", example= 4, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numIncentive", description="numIncentive, eg; 0", required=true, in="query", example= 4, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intCurrencyId", description="intCurrencyId, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numConvRate", description="numConvRate, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intSalesTypeId", description="intSalesTypeId, eg; 12", required=true, in="query", example= 12, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="monExtraAmount", description="monExtraAmount, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strExtraCause", description="strExtraCause, eg; no cause", required=true, in="query", example= "no cause", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strOther", description="strOther, eg; na", required=true, in="query", example= "na", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strContactAt", description="strContactAt, eg; na", required=true, in="query", example= "Monirul", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strPhone", description="strPhone, eg; 01732328504", required=true, in="query", example= "01732328504", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intSalesOffId", description="intSalesOffId, eg; 22", required=true, in="query", example= 22, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intShipPointId", description="intShipPointId, eg; 15", required=true, in="query", example= 15, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnDelivaryOrder", description="ysnDelivaryOrder, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="ysnSiteDelivery", description="ysnSiteDelivery, eg; false", required=true, in="query", example= false, @OA\Schema(type="boolean")),
     *     security={{"bearer": {}}},

     *     @OA\Response(response=200,description="Create Sales Order"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeSalesOrderEntry(Request $request)
    {
        try {
            $salesOrder = $this->salesRepository->storeSalesOrderEntry($request);
            return $this->responseRepository->ResponseSuccess($salesOrder, 'Sales Order Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataVehicleTypeVsVehicleList",
     *     tags={"Vehicle"},
     *     summary="getDataVehicleTypeVsVehicleList",
     *     description="getDataVehicleTypeVsVehicleList",
     *     operationId="getDataVehicleTypeVsVehicleList",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intTypeId", description="intTypeId, eg; 8", required=true, in="query", @OA\Schema(type="integer")),

     *     @OA\Response(response=200,description="getDataVehicleTypeVsVehicleList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataVehicleTypeVsVehicleList(Request $request)
    {
        $intUnitID = $request->intUnitID;
        $intTypeId = $request->intTypeId;

        try {
            $data = $this->salesRepository->getDataVehicleTypeVsVehicleList($intUnitID, $intTypeId);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Type vs Vehicle');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getTerritoryList",
     *     tags={"SetUp"},
     *     summary="getTerritoryList",
     *     description="getTerritoryList",
     *     operationId="getTerritoryList",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 8", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getTerritoryList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getTerritoryList(Request $request)
    {
        $intUnitID = $request->intUnitID;

        // return $intUnitID;
        try {
            $data = $this->salesRepository->getTerritoryList($intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Operational Setup');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataVehicleInformation",
     *     tags={"Vehicle"},
     *     summary="getDataVehicleInformation",
     *     description="getDataVehicleInformation",
     *     operationId="getDataVehicleInformation",
     *     @OA\Parameter( name="intID", description="intID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataVehicleInformation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataVehicleInformation(Request $request)
    {
        $intID = $request->intID;
        $intUnitID = $request->intUnitID;
        $intProviderType = $request->intProviderType;
        // return $intID;
        try {
            $data = $this->salesRepository->getDataVehicleInformation($intID, $intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Type vs Vehicle');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForCompanyVehicleLabourStatus",
     *     tags={"Vehicle"},
     *     summary="getDataForCompanyVehicleLabourStatus",
     *     description="getDataForCompanyVehicleLabourStatus",
     *     operationId="getDataForCompanyVehicleLabourStatus",
     *     @OA\Parameter( name="intID", description="intID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForCompanyVehicleLabourStatus"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForCompanyVehicleLabourStatus(Request $request)
    {

        $intUnitID = $request->intUnitID;
        $intID = $request->intID;
        // return $intID;
        try {
            $data = $this->salesRepository->getDataForCompanyVehicleLabourStatus($intUnitID, $intID);
            return $this->responseRepository->ResponseSuccess($data, 'Labour Provide or Not Provide');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForBagType",
     *     tags={"Vehicle"},
     *     summary="getDataForBagType",
     *     description="getDataForBagType",
     *     operationId="getDataForBagType",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForBagType"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForBagType(Request $request)
    {

        $intUnitID = $request->intUnitID;

        try {
            $data = $this->salesRepository->getDataForBagType($intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Bag Type');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForItemList",
     *     tags={"ItemFG"},
     *     summary="getDataForItemList",
     *     description="getDataForItemList",
     *     operationId="getDataForItemList",
     *     @OA\Parameter( name="intSalesOffice", description="intSalesOffice, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForItemList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForItemList(Request $request)
    {

        $intSalesOffice = $request->intSalesOffice;

        try {
            $data = $this->salesRepository->getDataForItemList($intSalesOffice);
            return $this->responseRepository->ResponseSuccess($data, 'Item Not Provide');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForShippingPointByTerritory",
     *     tags={"ItemFG"},
     *     summary="getDataForShippingPointByTerritory",
     *     description="getDataForShippingPointByTerritory",
     *     operationId="getDataForShippingPointByTerritory",
     *     @OA\Parameter( name="intID", description="intID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForShippingPointByTerritory"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForShippingPointByTerritory(Request $request)
    {

        $intID = $request->intID;

        try {
            $data = $this->salesRepository->getDataForShippingPointByTerritory($intID);
            return $this->responseRepository->ResponseSuccess($data, 'Shipping point not provide');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForCustomerType",
     *     tags={"ItemFG"},
     *     summary="getDataForCustomerType",
     *     description="getDataForCustomerType",
     *     operationId="getDataForCustomerType",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForCustomerType"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForCustomerType(Request $request)
    {

        $intUnitId = $request->intUnitId;

        try {
            $data = $this->salesRepository->getDataForCustomerType($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForSalesType",
     *     tags={"ItemFG"},
     *     summary="getDataForSalesType",
     *     description="getDataForSalesType",
     *     operationId="getDataForSalesType",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForSalesType"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForSalesType(Request $request)
    {

        $intUnitId = $request->intUnitId;

        try {
            $data = $this->salesRepository->getDataForSalesType($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForECommerceItemPrice",
     *     tags={"ItemFG"},
     *     summary="getDataForECommerceItemPrice",
     *     description="getDataForECommerceItemPrice",
     *     operationId="getDataForECommerceItemPrice",
     *     @OA\Parameter( name="intProductId", description="intProductId, eg; 761", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intThanaID", description="intThanaID, eg; 14472", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForECommerceItemPrice"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForECommerceItemPrice(Request $request)
    {

        $intProductId = $request->intProductId;
        $intThanaID = $request->intThanaID;
        try {
            $data = $this->salesRepository->getDataForECommerceItemPrice($intProductId, $intThanaID);
            return $this->responseRepository->ResponseSuccess($data, 'Item price based on thana');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForThanaName",
     *     tags={"ItemFG"},
     *     summary="getDataForThanaName",
     *     description="getDataForThanaName",
     *     operationId="getDataForThanaName",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 761", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForThanaName"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForThanaName(Request $request)
    {

        $intUnitID = $request->intUnitID;
        $intID = $request->intID;
        try {
            $data = $this->salesRepository->getDataForThanaName($intUnitID, $intID);
            return $this->responseRepository->ResponseSuccess($data, 'Item price based on thana');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDataForShippingPointConfiguredForTerritory",
     *     tags={"ShippingPointNTerritoryBridge"},
     *     summary="getDataForShippingPointConfiguredForTerritory",
     *     description="getDataForShippingPointConfiguredForTerritory",
     *     operationId="getDataForShippingPointConfiguredForTerritory",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 761", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intShippingPoint", description="intShippingPoint, eg; 761", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDataForShippingPointConfiguredForTerritory"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDataForShippingPointConfiguredForTerritory(Request $request)
    {

        $intUnitID = $request->intUnitID;
        $intShippingPoint = $request->intShippingPoint;
        try {
            $data = $this->salesRepository->getDataForShippingPointConfiguredForTerritory($intUnitID, $intShippingPoint);
            return $this->responseRepository->ResponseSuccess($data, 'Item price based on thana');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/sales/getShippingPointListByUnit",
     *     tags={"ItemFG"},
     *     summary="getShippingPointListByUnit",
     *     description="getShippingPointListByUnit",
     *     operationId="getShippingPointListByUnit",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getShippingPointListByUnit"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShippingPointListByUnit(Request $request)
    {
        $intUnitId = $request->intUnitId;

        try {
            $data = $this->salesRepository->getShippingPointListByUnit($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Shipping point list not found');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/sales/addMultipleTerritory",
     *     tags={"ItemFG"},
     *     summary="Assign Multiple Territory By Shipping Point",
     *     description="Assign Multiple Territory By Shipping Point",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intShippingPoint", type="integer", example=1),
     *              @OA\Property(property="intUnitID", type="integer", example=1),
     *              @OA\Property(property="ysnEnable", type="integer", example=1),
     *              @OA\Property(property="intInsertBy", type="integer", example=1),
     *              @OA\Property(
     *              property="territories",
     *              type="array",
     *              @OA\Items(
     *                        @OA\Property(property="intTerritoryId", type="integer", example=1),
     *                        @OA\Property(property="strTerritoryName", type="string", example="Rajshahi-1"),
     *                        @OA\Property(property="strRemarks", type="text", example="Remarks"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="addMultipleTerritory",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Assign Multiple Territory"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function addMultipleTerritory(Request $request)
    {
        try {
            $data = $this->salesRepository->addMultipleTerritory($request);
            return $this->responseRepository->ResponseSuccess($data, 'Multiple territory assigned successfully.');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


     /**
     * @OA\GET(
     *     path="/api/v1/sales/getSalesOffices",
     *     tags={"ItemFG"},
     *     summary="getSalesOffices",
     *     description="getSalesOffices",
     *     operationId="getSalesOffices",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalesOffices"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalesOffices(Request $request)
    {
        $intUnitId = $request->intUnitId;

        // return  $intUnitId;

        try {
            $data = $this->salesRepository->getSalesOffices($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Sales office list not found');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

  /**
     * @OA\GET(
     *     path="/api/v1/sales/getChartOfAccountData",
     *     tags={"ItemFG"},
     *     summary="getChartOfAccountData",
     *     description="getChartOfAccountData",
     *     operationId="getChartOfAccountData",
     *     @OA\Parameter( name="itmid", description="itmid, eg; 761", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="salestype", description="salestype, eg; 12", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intunitid", description="intunitid, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getChartOfAccountData"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getChartOfAccountData(Request $request)
    {
        $itmid = $request->itmid;
        $salestype = $request->salestype;
        $intunitid = $request->intunitid;

        try {
            $data = $this->salesRepository->getChartOfAccountData($itmid ,$salestype,$intunitid);
            return $this->responseRepository->ResponseSuccess($data, 'Shipping point list not found');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

 /**
     * @OA\GET(
     *     path="/api/v1/sales/getSalesOrderProducts",
     *     tags={"ItemFG"},
     *     summary="getSalesOrderProducts",
     *     description="getSalesOrderProducts",
     *     operationId="getSalesOrderProducts",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalesOrderProducts"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalesOrderProducts(Request $request)
    {
        $intUnitID = $request->intUnitID;
        // return $intUnitID;
        try {
            $data = $this->salesRepository->getSalesOrderProducts( $intUnitID );
            return $this->responseRepository->ResponseSuccess($data, 'SalesOrderProducts list not found');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\GET(
     *     path="/api/v1/sales/getCustomerBalanceNUndeliver",
     *     tags={"ItemFG"},
     *     summary="getCustomerBalanceNUndeliver",
     *     description="getCustomerBalanceNUndeliver",
     *     operationId="getCustomerBalanceNUndeliver",
     *     @OA\Parameter( name="intcustomerid", description="intcustomerid, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2021-01-23", required=true, in="query", @OA\Schema(type="string")),

     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomerBalanceNUndeliver"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerBalanceNUndeliver(Request $request)
    {
        $intcustomerid = $request->intcustomerid;
        $intUnitID = $request->intUnitID;
        $dteEndDate = $request->dteEndDate;

        try {
            $data = $this->salesRepository->getCustomerBalanceNUndeliver($intcustomerid, $intUnitID, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Shipping point list not found');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

 /**
     * @OA\GET(
     *     path="/api/v1/sales/getItemWeight",
     *     tags={"ItemFG"},
     *     summary="getItemWeight",
     *     description="getItemWeight",
     *     operationId="getItemWeight",
     *     @OA\Parameter( name="intUOM", description="intUOM, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUOMTr", description="intUOMTr, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numQnt", description="numQnt, eg; 2021-01-23", required=true, in="query", @OA\Schema(type="string")),

     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getItemWeight"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItemWeight(Request $request)
    {
        $intUOM = $request->intUOM;
        $intUOMTr = $request->intUOMTr;
        $numQnt = $request->numQnt;

        try {
            $data = $this->salesRepository->getItemWeight($intUOM, $intUOMTr, $numQnt);
            return $this->responseRepository->ResponseSuccess($data, 'Shipping point list not found');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\GET(
     *     path="/api/v1/sales/getSalesOrderVsEmployee",
     *     tags={"ItemFG"},
     *     summary="getSalesOrderVsEmployee",
     *     description="getSalesOrderVsEmployee",
     *     operationId="getSalesOrderVsEmployee",
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 4", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalesOrderVsEmployee"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalesOrderVsEmployee(Request $request)
    {

        $strEmailAddress = $request->strEmailAddress;
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->salesRepository->getSalesOrderVsEmployee($strEmailAddress,$intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Item Not Provide');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * @OA\GET(
     *     path="/api/v1/sales/getSalesOrderVsEmployeeforAEL",
     *     tags={"ItemFG"},
     *     summary="getSalesOrderVsEmployeeforAEL",
     *     description="getSalesOrderVsEmployeeforAEL",
     *     operationId="getSalesOrderVsEmployeeforAEL",
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 4", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalesOrderVsEmployeeforAEL"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalesOrderVsEmployeeforAEL(Request $request)
    {

        $strEmailAddress = $request->strEmailAddress;
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->salesRepository->getSalesOrderVsEmployeeforAEL($strEmailAddress,$intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Item Not Provide');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }






 /**
     * @OA\GET(
     *     path="/api/v1/sales/getCustomersByTSO",
     *     tags={"ItemFG"},
     *     summary="getCustomersByTSO",
     *     description="getCustomersByTSO",
     *     operationId="getCustomersByTSO",
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 4", required=true, in="query", @OA\Schema(type="string")),

     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCustomersByTSO"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomersByTSO(Request $request)
    {

        $strEmailAddress = $request->strEmailAddress;
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->salesRepository->getCustomersByTSO($strEmailAddress,$intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Item Not Provide');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\GET(
     *     path="/api/v1/sales/getDistributorListByQuery",
     *     tags={"ItemFG"},
     *     summary="getDistributorListByQuery",
     *     description="getDistributorListByQuery",
     *     operationId="getDistributorListByQuery",
     *     @OA\Parameter( name="strEmailAddress", description="strEmailAddress, eg; 4", required=true, in="query", @OA\Schema(type="string")),

     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDistributorListByQuery"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDistributorListByQuery(Request $request)
    {

        $strEmailAddress = $request->strEmailAddress;

        try {
            $data = $this->salesRepository->getDistributorListByQuery($strEmailAddress);
            return $this->responseRepository->ResponseSuccess($data, 'Item Not Provide');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * @OA\POST(
     *     path="/api/v1/sales/storeSalesOrderEntryByCustomer",
     *     tags={"SalesOrder"},
     *     summary="Create Sales Order",
     *     description="Create Sales Order",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="salesorders",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intProductId", type="integer", example=761),
     *                              @OA\Property(property="qnt", type="integer", example=1),
     *                              @OA\Property(property="pr", type="integer", example=10),
     *                              @OA\Property(property="intCOAAccId", type="integer", example=38144),
     *                              @OA\Property(property="strCOAAccName", type="string", example="Portland Composit Cement L"),
     *                              @OA\Property(property="monConversionRate", type="integer", example=1),
     *                              @OA\Property(property="intCurrencyID", type="integer", example=1),
     *                              @OA\Property(property="intExtraId", type="integer", example=4),
     *                              @OA\Property(property="monExtraPrice", type="integer", example=0),
     *                              @OA\Property(property="intUom", type="integer", example=12),
     *                              @OA\Property(property="strNarration", type="string", example="test"),
     *                              @OA\Property(property="intSalesType", type="integer", example=12),
     *                              @OA\Property(property="intVehicleVarId", type="integer", example=14841),
     *                              @OA\Property(property="numPromotion", type="integer", example=0),
     *                              @OA\Property(property="monCommission", type="integer", example=0),
     *                              @OA\Property(property="intIncentiveId", type="integer", example=4),
     *                              @OA\Property(property="numIncentive", type="integer", example=0),
     *                              @OA\Property(property="monSuppTax", type="integer", example=0),
     *                              @OA\Property(property="monVAT", type="integer", example=0),
     *                              @OA\Property(property="monVatPrice", type="integer", example=0),
     *                              @OA\Property(property="intPromItemId", type="integer", example=761),
     *                              @OA\Property(property="strPromItemName", type="string", example="Portland Composit Cement L"),
     *                              @OA\Property(property="intPromUOM", type="integer", example=12),
     *                              @OA\Property(property="monPromPrice", type="integer", example=0),
     *                               @OA\Property(property="intPromItemCOAId", type="integer", example=38144),
     *                              @OA\Property(property="intInsertedBy", type="integer", example=1272),
     *                              @OA\Property(property="numWeight", type="integer", example=0),
     *                              @OA\Property(property="numVolume", type="integer", example=0),
     *                              @OA\Property(property="numPromWeight", type="integer", example=0),
     *                              @OA\Property(property="numPromVolume", type="integer", example=0),
     *                              @OA\Property(property="decDiscountAmount", type="integer", example=0),
     *                              @OA\Property(property="decDiscountRate", type="integer", example=0),
     *                              @OA\Property(property="numRestQuantity", type="integer", example=0),
     *                         ),
     *                      ),
     *              )
     *      ),
     *      operationId="storeSalesOrderEntryByCustomer",
     *     @OA\Parameter( name="intUserID", description="intUserID, eg; 1", required=true, in="query", example= 1272, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 1", required=true, in="query", example= 4, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteDate", description="dteDate, eg; 2020-08-30", required=true, in="query", example= "2020-08-30", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteDODate", description="dteDODate, eg; 2020-08-30", required=true, in="query", example= "2020-08-30", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intCustomerType", description="intCustomerType, eg; 5", required=true, in="query", example=5, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 302667", required=true, in="query", example= 302667, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intDisPointId", description="intDisPointId, eg; 14651", required=true, in="query", example= 14651, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strNarration", description="strNarration, eg; test", required=true, in="query", example= "test nar", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strAddress", description="strAddress, eg; test adr", required=true, in="query", example= "test adr", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intPriceVarId", description="intPriceVarId, eg; 30", required=true, in="query", example=30, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intVehicleVarId", description="intVehicleVarId, eg; 14841", required=true, in="query", example= 14841, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnLogistic", description="ysnLogistic, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="intChargeId", description="intChargeId, eg; 4", required=true, in="query", example= 4, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numCharge", description="numCharge, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intIncentiveId", description="intIncentiveId, eg; 4", required=true, in="query", example= 4, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numIncentive", description="numIncentive, eg; 0", required=true, in="query", example= 4, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intCurrencyId", description="intCurrencyId, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numConvRate", description="numConvRate, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intSalesTypeId", description="intSalesTypeId, eg; 12", required=true, in="query", example= 12, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="monExtraAmount", description="monExtraAmount, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strExtraCause", description="strExtraCause, eg; no cause", required=true, in="query", example= "no cause", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strOther", description="strOther, eg; na", required=true, in="query", example= "na", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strContactAt", description="strContactAt, eg; na", required=true, in="query", example= "Monirul", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strPhone", description="strPhone, eg; 01732328504", required=true, in="query", example= "01732328504", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intSalesOffId", description="intSalesOffId, eg; 22", required=true, in="query", example= 22, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intShipPointId", description="intShipPointId, eg; 15", required=true, in="query", example= 15, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnDelivaryOrder", description="ysnDelivaryOrder, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="ysnSiteDelivery", description="ysnSiteDelivery, eg; false", required=true, in="query", example= false, @OA\Schema(type="boolean")),
     *     security={{"bearer": {}}},

     *     @OA\Response(response=200,description="Create Sales Order"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeSalesOrderEntryByCustomer(Request $request)
    {
        try {
            $salesOrder = $this->salesRepository->storeSalesOrderEntryByCustomer($request);
            return $this->responseRepository->ResponseSuccess($salesOrder, 'Sales Order Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

 /**
     * @OA\GET(
     *     path="/api/v1/sales/GetDONChallanQntUpdate",
     *     tags={"ItemFG"},
     *     summary="GetDONChallanQntUpdate",
     *     description="GetDONChallanQntUpdate",
     *     operationId="GetDONChallanQntUpdate",
     *     @OA\Parameter( name="strCode", description="strCode, eg; 1102218799", required=true, in="query", example= "2020-08-30", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", example= "2020-08-30", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetDONChallanQntUpdate"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetDONChallanQntUpdate(Request $request)
    {

        $strCode = $request->strCode;
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->salesRepository->GetDONChallanQntUpdate($strCode,$intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'DO N Challan Qnt Update');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/sales/getDeliveryRequstDo",
     *     tags={"ItemFG"},
     *     summary="getDeliveryRequstDo",
     *     description="getDeliveryRequstDo",
     *     operationId="getDeliveryRequstDo",
     *     @OA\Parameter( name="intPart", description="intPart, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intEmployeeID", description="intEmployeeID, eg; 4", required=true, in="query", example= 366402, @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getDeliveryRequstDo"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDeliveryRequstDo(Request $request)
    {

        $intPart = 1;
        $intEmployeeID = $request->intEmployeeID;
        try {
            $data = $this->salesRepository->getDeliveryRequstDo($intPart,$intEmployeeID);
            return $this->responseRepository->ResponseSuccess($data, 'DO N Challan Qnt Update');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/sales/storeSalesOrderEntryByMultipleItem",
     *     tags={"SalesOrder"},
     *     summary="Create Sales Order",
     *     description="Create Sales Order",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="salesorders",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intProductId", type="integer", example=213744),
     *                              @OA\Property(property="qnt", type="integer", example=1),
     *                              @OA\Property(property="pr", type="integer", example=10),
     *                              @OA\Property(property="intCOAAccId", type="integer", example=238092),
     *                              @OA\Property(property="strCOAAccName", type="string", example="Magnum Supreme 500 L"),
     *                              @OA\Property(property="monConversionRate", type="integer", example=1),
     *                              @OA\Property(property="intCurrencyID", type="integer", example=1),
     *                              @OA\Property(property="intExtraId", type="integer", example=35),
     *                              @OA\Property(property="monExtraPrice", type="integer", example=0),
     *                              @OA\Property(property="intUom", type="integer", example=1173),
     *                              @OA\Property(property="strNarration", type="string", example="test"),
     *                              @OA\Property(property="intSalesType", type="integer", example=148),
     *                              @OA\Property(property="intVehicleVarId", type="integer", example=21768),
     *                              @OA\Property(property="numPromotion", type="integer", example=0),
     *                              @OA\Property(property="monCommission", type="integer", example=0),
     *                              @OA\Property(property="intIncentiveId", type="integer", example=31),
     *                              @OA\Property(property="numIncentive", type="integer", example=0),
     *                              @OA\Property(property="monSuppTax", type="integer", example=0),
     *                              @OA\Property(property="monVAT", type="integer", example=0),
     *                              @OA\Property(property="monVatPrice", type="integer", example=0),
     *                              @OA\Property(property="intPromItemId", type="integer", example=238092),
     *                              @OA\Property(property="strPromItemName", type="string", example="Magnum Supreme 500 L"),
     *                              @OA\Property(property="intPromUOM", type="integer", example=1173),
     *                              @OA\Property(property="monPromPrice", type="integer", example=0),
     *                               @OA\Property(property="intPromItemCOAId", type="integer", example=238092),
     *                              @OA\Property(property="intInsertedBy", type="integer", example=1272),
     *                              @OA\Property(property="numWeight", type="integer", example=0),
     *                              @OA\Property(property="numVolume", type="integer", example=0),
     *                              @OA\Property(property="numPromWeight", type="integer", example=0),
     *                              @OA\Property(property="numPromVolume", type="integer", example=0),
     *                              @OA\Property(property="decDiscountAmount", type="integer", example=0),
     *                              @OA\Property(property="decDiscountRate", type="integer", example=0),
     *                              @OA\Property(property="numRestQuantity", type="integer", example=0),
     *                         ),
     *                      ),
     *              )
     *      ),
     *      operationId="storeSalesOrderEntryByMultipleItem",
     *     @OA\Parameter( name="intUserID", description="intUserID, eg; 1", required=true, in="query", example= 1272, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 147", required=true, in="query", example= 147, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteDate", description="dteDate, eg; 2021-03-10", required=true, in="query", example= "2021-03-10", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteDODate", description="dteDODate, eg; 2021-03-10", required=true, in="query", example= "2021-03-10", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intCustomerType", description="intCustomerType, eg; 255", required=true, in="query", example=255, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 396805", required=true, in="query", example= 396805, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intDisPointId", description="intDisPointId, eg; 76647", required=true, in="query", example= 76647, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strNarration", description="strNarration, eg; test", required=true, in="query", example= "test nar", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strAddress", description="strAddress, eg; test adr", required=true, in="query", example= "test adr", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intPriceVarId", description="intPriceVarId, eg; 1463", required=true, in="query", example=1463, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intVehicleVarId", description="intVehicleVarId, eg; 21768", required=true, in="query", example= 21768, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnLogistic", description="ysnLogistic, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="intChargeId", description="intChargeId, eg; 35", required=true, in="query", example= 35, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numCharge", description="numCharge, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intIncentiveId", description="intIncentiveId, eg; 31", required=true, in="query", example= 31, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numIncentive", description="numIncentive, eg; 0", required=true, in="query", example= 4, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intCurrencyId", description="intCurrencyId, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numConvRate", description="numConvRate, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intSalesTypeId", description="intSalesTypeId, eg; 148", required=true, in="query", example= 148, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="monExtraAmount", description="monExtraAmount, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strExtraCause", description="strExtraCause, eg; no cause", required=true, in="query", example= "no cause", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strOther", description="strOther, eg; na", required=true, in="query", example= "na", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strContactAt", description="strContactAt, eg; na", required=true, in="query", example= "Monirul", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strPhone", description="strPhone, eg; 01732328504", required=true, in="query", example= "01732328504", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intSalesOffId", description="intSalesOffId, eg; 1527", required=true, in="query", example= 1527, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intShipPointId", description="intShipPointId, eg; 1245", required=true, in="query", example= 1245, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnDelivaryOrder", description="ysnDelivaryOrder, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="ysnSiteDelivery", description="ysnSiteDelivery, eg; false", required=true, in="query", example= false, @OA\Schema(type="boolean")),
     *     security={{"bearer": {}}},

     *     @OA\Response(response=200,description="Create Sales Order"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeSalesOrderEntryByMultipleItem(Request $request)
    {



        try {
            $salesOrder = $this->salesRepository->storeSalesOrderEntryByMultipleItem($request);
            return $this->responseRepository->ResponseSuccess($salesOrder, 'Sales Order Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

  /**
     * @OA\POST(
     *     path="/api/v1/sales/storeSalesOrderEntryByMultipleItemForUseColumn",
     *     tags={"SalesOrder"},
     *     summary="Create Sales Order",
     *     description="Create Sales Order",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="salesorders",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="productId", type="integer", example=213239),
     *                              @OA\Property(property="quantity", type="integer", example=1),
     *                              @OA\Property(property="price", type="integer", example=10),
     *                              @OA\Property(property="product_accId", type="integer", example=235546),
     *                              @OA\Property(property="product_accName", type="string", example="Miniket Rice 25 KG L"),
     *                              @OA\Property(property="intUom", type="integer", example=1163),
     *                              @OA\Property(property="strNarration", type="string", example="test"),
     *                              @OA\Property(property="intSalesType", type="integer", example=142),
     *                              @OA\Property(property="intVehicleVarId", type="integer", example=21418),
     *                              @OA\Property(property="intIncentiveId", type="integer", example=4),
     *                              @OA\Property(property="numIncentive", type="integer", example=0),
     *                              @OA\Property(property="monSuppTax", type="integer", example=0),
     *                              @OA\Property(property="monVAT", type="integer", example=0),
     *                              @OA\Property(property="monVatPrice", type="integer", example=0),
     *                              @OA\Property(property="numRestQuantity", type="integer", example=1),
     *                         ),
     *                      ),
     *              )
     *      ),
     *      operationId="storeSalesOrderEntryByMultipleItemForUseColumn",
     *     @OA\Parameter( name="intUserID", description="intUserID, eg; 1", required=true, in="query", example= 1272, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 143", required=true, in="query", example= 143, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteDate", description="dteDate, eg; 2021-09-01", required=true, in="query", example= "2021-09-01", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteDODate", description="dteDODate, eg; 2021-09-01", required=true, in="query", example= "2021-09-01", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intCustomerType", description="intCustomerType, eg; 241", required=true, in="query", example=241, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 399722", required=true, in="query", example= 399722, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intDisPointId", description="intDisPointId, eg; 78871", required=true, in="query", example= 78871, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strNarration", description="strNarration, eg; test", required=true, in="query", example= "test nar", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strAddress", description="strAddress, eg; test adr", required=true, in="query", example= "test adr", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intPriceVarId", description="intPriceVarId, eg; 2085", required=true, in="query", example=2085, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intVehicleVarId", description="intVehicleVarId, eg; 21418", required=true, in="query", example= 21418, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnLogistic", description="ysnLogistic, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="intChargeId", description="intChargeId, eg; 4", required=true, in="query", example= 4, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numCharge", description="numCharge, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intIncentiveId", description="intIncentiveId, eg; 31", required=true, in="query", example= 31, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numIncentive", description="numIncentive, eg; 29", required=true, in="query", example= 29, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intCurrencyId", description="intCurrencyId, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="numConvRate", description="numConvRate, eg; 1", required=true, in="query", example= 1, @OA\Schema(type="number")),
     *     @OA\Parameter( name="intSalesTypeId", description="intSalesTypeId, eg; 142", required=true, in="query", example= 142, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="monExtraAmount", description="monExtraAmount, eg; 0", required=true, in="query", example= 0, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strExtraCause", description="strExtraCause, eg; no cause", required=true, in="query", example= "no cause", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strOther", description="strOther, eg; na", required=true, in="query", example= "na", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strContactAt", description="strContactAt, eg; na", required=true, in="query", example= "Monirul", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strPhone", description="strPhone, eg; 01732328504", required=true, in="query", example= "01732328504", @OA\Schema(type="string")),
     *     @OA\Parameter( name="intSalesOffId", description="intSalesOffId, eg; 1511", required=true, in="query", example= 1511, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intShipPointId", description="intShipPointId, eg; 1266", required=true, in="query", example= 1266, @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnDelivaryOrder", description="ysnDelivaryOrder, eg; true", required=true, in="query", example= true, @OA\Schema(type="boolean")),
     *     @OA\Parameter( name="ysnSiteDelivery", description="ysnSiteDelivery, eg; false", required=true, in="query", example= false, @OA\Schema(type="boolean")),
     *     security={{"bearer": {}}},

     *     @OA\Response(response=200,description="Create Sales Order"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeSalesOrderEntryByMultipleItemForUseColumn(Request $request)
    {

    //    return 1;

        try {
            $salesOrder = $this->salesRepository->storeSalesOrderEntryByMultipleItemForUseColumn($request);
            return $this->responseRepository->ResponseSuccess($salesOrder, 'Sales Order Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }



/**
     * @OA\GET(
     *     path="/api/v1/sales/getSalesOrderVsItemDetails",
     *     tags={"SalesOrder"},
     *     summary="getSalesOrderVsItemDetails",
     *     description="getSalesOrderVsItemDetails",
     *     operationId="getSalesOrderVsItemDetails",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 302447", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intId", description="intId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),


     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalesOrderVsItemDetails"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalesOrderVsItemDetails(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $intId = $request->intId;


        try {
            $data = $this->salesRepository->getSalesOrderVsItemDetails($intUnitId, $intId);
            return $this->responseRepository->ResponseSuccess($data, 'Item Detaills not found');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



}
