<?php

namespace Modules\Distribution\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Distribution\Repositories\ShipmentPlanningRepository;

class ShipmentPlanningController extends Controller
{

    public $shipmentPlanningRepository;
    public $responseRepository;

    public function __construct(ShipmentPlanningRepository $shipmentPlanningRepository, ResponseRepository $rp)
    {
        $this->shipmentPlanningRepository = $shipmentPlanningRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/distribution/getShipmentPlanningList",
     *     tags={"Shipment Planning"},
     *     summary="getShipmentPlanningList",
     *     description="getShipmentPlanningList",
     *     operationId="getShipmentPlanningList",
     *     @OA\Parameter(name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="intCreatedBy", description="intCreatedBy, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getShipmentPlanningList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShipmentPlanningList(Request $request)
    {
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->shipmentPlanningRepository->getShipmentPlanningList($intUnitId, $request->intCreatedBy);
            return $this->responseRepository->ResponseSuccess($data, 'Shipment Planning List By Unit ID and Employeer ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


     /**
     * @OA\PUT(
     *     path="/api/v1/distribution/editShipmentPlanning",
     *     tags={"Shipment Planning"},
     *     summary="Update Shipment Planning Information",
     *     description="Update Shipment Planning Information",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intShipmentId", type="integer", example=23299),
     *              @OA\Property(property="intUnitId", type="integer", example=4),
     *              @OA\Property(property="dteScheduledTime", type="string", example="2020-10-19 00:00:00.000"),
     *              @OA\Property(property="strVechicleProviderType", type="string", example=3),
     *              @OA\Property(property="strVehicleCapacity", type="string", example=1),
     *              @OA\Property(property="strLastDestination", type="string", example="Suagazi, Konestola bazaar, Sadar south cumilla."),
     *              @OA\Property(property="intProviderId", type="integer", example=1182),
     *              @OA\Property(property="intVehicleId", type="integer", example=292601),
     *              @OA\Property(property="intDriverId", type="integer", example=0),
     *              @OA\Property(property="dteSheduledDate", type="string", example="2020-10-20 13:23:44"),
     *              @OA\Property(property="intUpdateBy", type="integer", example=1272),
     *              @OA\Property(property="intAssignSupplierID", type="integer", example=NULL),
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intRequestId", type="integer", example=72436),
     *                              @OA\Property(property="intReqDetailsId", type="integer", example=72700),
     *                              @OA\Property(property="intSalesOrderId", type="integer", example=3174989),
     *                              @OA\Property(property="strSalesOrderCode", type="string", example="1110201226"),
     *                              @OA\Property(property="intCustomerId", type="integer", example=326533),
     *                              @OA\Property(property="intDistPointId", type="integer", example=70691),
     *                              @OA\Property(property="strDestinationAddress", type="string", example="[7 Ton][1110201226]M/s. Amir Traders, Jatrabari [ Plot No-B-18;Road No: Avenue -01 Green Model Town,Manda,Thana: Mugda;Dhaka-1214]"),
     *                              @OA\Property(property="decQty", type="integer", example=150.00),
     *                              @OA\Property(property="dteDroppingDateTime", type="string", example="NULL"),
     *                              @OA\Property(property="monLogisticRate", type="integer", example=19),
     *                              @OA\Property(property="monTotalLogistic", type="integer", example=2850),
     *                              @OA\Property(property="intTerritoryID", type="integer", example=63),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="editShipmentPlanning",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Shipment Planning Information"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function editShipmentPlanning(Request $request)
    {
        try {
            $data = $this->shipmentPlanningRepository->editShipmentPlanning($request);
            return $this->responseRepository->ResponseSuccess($data, 'Shipment Planning Information Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\POST(
     *     path="/api/v1/distribution/addShipmentPlanning",
     *     tags={"Shipment Planning"},
     *     summary="Add Shipment Planning Information",
     *     description="Add Shipment Planning Information",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=4),
     *              @OA\Property(property="dteScheduledTime", type="string", example="2020-10-19 00:00:00.000"),
     *              @OA\Property(property="strVechicleProviderType", type="string", example=3),
     *              @OA\Property(property="strVehicleCapacity", type="string", example=1),
     *              @OA\Property(property="strLastDestination", type="string", example="Suagazi, Konestola bazaar, Sadar south cumilla."),
     *              @OA\Property(property="intProviderId", type="integer", example=1182),
     *              @OA\Property(property="intVehicleId", type="integer", example=292601),
     *              @OA\Property(property="intDriverId", type="integer", example=0),
     *              @OA\Property(property="intTerritoryID", type="integer", example=1234),
     *              @OA\Property(property="dteSheduledDate", type="string", example="2020-10-20 13:23:44"),
     *              @OA\Property(property="intInsertBy", type="integer", example=1272),
     *              @OA\Property(property="intAssignSupplierID", type="integer", example=NULL),
     *              @OA\Property(
     *                      property="requisitions",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intRequestId", type="integer", example=72436),
     *                              @OA\Property(property="intReqDetailsId", type="integer", example=72700),
     *                              @OA\Property(property="intSalesOrderId", type="integer", example=3174989),
     *                              @OA\Property(property="strSalesOrderCode", type="string", example="1110201226"),
     *                              @OA\Property(property="decQty", type="integer", example=150.00),
     *                              @OA\Property(property="intBagType", type="integer", example=NULL),
     *                              @OA\Property(property="intProductId", type="integer", example=1),
     *                              @OA\Property(property="strBagType", type="string", example=NULL),
     *                              @OA\Property(property="strProductName", type="string", example="test"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="addShipmentPlanning",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Added Shipment Planning Information"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function addShipmentPlanning(Request $request)
    {
        try {
            $data = $this->shipmentPlanningRepository->addShipmentPlanning($request);
            return $this->responseRepository->ResponseSuccess($data, 'Shipment Planning Information Added Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/distribution/getSupplierList",
     *     tags={"Shipment Planning"},
     *     summary="getSupplierList",
     *     description="getSupplierList",
     *     operationId="getSupplierList",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSupplierList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupplierList()
    {
        try {
            $data = $this->shipmentPlanningRepository->getSupplierList();
            return $this->responseRepository->ResponseSuccess($data, 'Supplier List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
