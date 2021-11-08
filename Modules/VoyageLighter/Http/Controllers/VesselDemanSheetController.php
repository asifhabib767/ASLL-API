<?php

namespace Modules\VoyageLighter\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\VoyageLighter\Repositories\VesselDemandSheetRepository;

class VesselDemanSheetController extends Controller
{
    public $vesselDemandSheetRepository;
    public $responseRepository;

    /**
     * Display a listing of the resource.
     */
    public function __construct(VesselDemandSheetRepository $vesselDemandSheetRepository, ResponseRepository $rp)
    {
        $this->vesselDemandSheetRepository = $vesselDemandSheetRepository;
        $this->responseRepository = $rp;
    }


    /**
     * @OA\POST(
     *     path="/api/v1/voyageLighter/postvesselDemandQntStore",
     *     tags={"Vessel Demand Qnt"},
     *     summary="Create Vessel Demand Qnt Activity",
     *     description="Create Vessel Demand Qnt Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="dteLayCanFromDate", type="string", example="2020-12-02"),
     *              @OA\Property(property="dteLayCanToDate", type="string", example="2020-12-02"),
     *              @OA\Property(property="intCountryID", type="integer", example=1),
     *              @OA\Property(property="strCountry", type="string", example="Bangladesh"),
     *              @OA\Property(property="dteETADateFromLoadPort",  type="string", example="2020-12-02"),
     *              @OA\Property(property="dteETADateToLoadPort",  type="string", example="2020-12-02"),
     *              @OA\Property(property="strComments", type="string", example=1),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="intPortFrom", type="integer", example=1),
     *              @OA\Property(property="strPortFrom", type="string", example=1),
     *              @OA\Property(property="intPortTo", type="integer", example=1),
     *              @OA\Property(property="strPortTo", type="string", example=1),
     *              @OA\Property(property="intCharterer", type="integer", example=1),
     *              @OA\Property(property="strCharterer", type="string", example=1),
     *              @OA\Property(property="intShipper", type="integer", example=1),
     *              @OA\Property(property="strShipper", type="string", example=1),

     *              @OA\Property(
     *                      property="demandSheetData",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intItemId", type="integer", example=1),
     *                              @OA\Property(property="strItemName", type="string", example="Test"),
     *                              @OA\Property(property="intQuantity", type="integer", example=1),
     *                              @OA\Property(property="images", type="string", example="test.png")
     *                          ),
     *                  ),
     *              ),
     *          ),
     *      operationId="postvesselDemandQntStore",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Vessel Demand Qnt Activity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postvesselDemandQntStore(Request $request)
    {
        try {
            $data = $this->vesselDemandSheetRepository->postvesselDemandQntStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Demand Qnt Activity Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

 /**
     * @OA\POST(
     *     path="/api/v1/voyageLighter/postvesselDemandQntApproveStore",
     *     tags={"Vessel Demand Qnt"},
     *     summary="Create Vessel Demand Aprv Qnt Activity",
     *     description="Create Vessel Demand Aprv Qnt Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intVesselDemandSheetID", type="integer", example=1),
     *              @OA\Property(property="dteLayCanFromDate", type="string", example="2020-12-02"),
     *              @OA\Property(property="dteLayCanToDate", type="string", example="2020-12-02"),
     *              @OA\Property(property="intCountryID", type="integer", example=1),
     *              @OA\Property(property="strCountry", type="string", example="Bangladesh"),
     *              @OA\Property(property="dteETADateFromLoadPort",  type="string", example="2020-12-02"),
     *              @OA\Property(property="dteETADateToLoadPort",  type="string", example="2020-12-02"),
     *              @OA\Property(property="strComments", type="string", example=1),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="intPortFrom", type="integer", example=1),
     *              @OA\Property(property="strPortFrom", type="string", example=1),
     *              @OA\Property(property="intPortTo", type="integer", example=1),
     *              @OA\Property(property="strPortTo", type="string", example=1),
     *
     *              @OA\Property(property="strImagePath", type="string", example=1),
     *              @OA\Property(property="intCharterer", type="integer", example=1),
     *              @OA\Property(property="strCharterer", type="string", example=1),
     *              @OA\Property(property="intShipper", type="integer", example=1),
     *              @OA\Property(property="strShipper", type="string", example=1),

     *              @OA\Property(
     *                      property="demandSheetAprvData",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intItemId", type="integer", example=1),
     *                              @OA\Property(property="strItemName", type="string", example="Test"),
     *                              @OA\Property(property="intQuantity", type="integer", example=1),
     *                          ),
     *                  ),
     *              ),
     *          ),
     *      operationId="postvesselDemandQntApproveStore",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Vessel Demand Qnt Activity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postvesselDemandQntApproveStore(Request $request)
    {
        try {
            $data = $this->vesselDemandSheetRepository->postvesselDemandQntApproveStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Demand Approve Qnt Activity Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getPendingDataForAprv",
     *      tags={"Vessel Demand Qnt"},
     *      summary="get Pending Data For Aprv",
     *      description="get Pending Data ForAprv",
     *      operationId="getPendingDataForAprv",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="get Pending Data For Aprv"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getPendingDataForAprv(Request $request)
    {
        // $intLighterId = $request->intLighterId;

        try {
            $data = $this->vesselDemandSheetRepository->getPendingDataForAprv();
            return $this->responseRepository->ResponseSuccess($data, 'Get pending Data for Aprv');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

 /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getDemandSheetDetailByID",
     *      tags={"Vessel Demand Qnt"},
     *      summary="get Detaill data by id",
     *      description="get Detaill data by id",
     *      operationId="getDemandSheetDetailByID",
     *      @OA\Parameter( name="intID", description="intID, eg; 5", required=false, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="get Detaill data by id"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getDemandSheetDetailByID(Request $request)
    {
        $intID = $request->intID;

        try {
            $data = $this->vesselDemandSheetRepository->getDemandSheetDetailByID( $intID);
            return $this->responseRepository->ResponseSuccess($data, 'Get pending Data for Aprv');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


/**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getShipperList",
     *      tags={"Vessel Demand Qnt"},
     *      summary="get Shipper List",
     *      description="get Shipper List",
     *      operationId="getShipperList",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="get Shipper List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShipperList(Request $request)
    {
        // $intLighterId = $request->intLighterId;

        try {
            $data = $this->vesselDemandSheetRepository->getShipperList();
            return $this->responseRepository->ResponseSuccess($data, 'get Shipper List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getChartererList",
     *      tags={"Vessel Demand Qnt"},
     *      summary="get Charterer List",
     *      description="get Charterer List",
     *      operationId="getChartererList",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="get Charterer List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getChartererList(Request $request)
    {
        // $intLighterId = $request->intLighterId;

        try {
            $data = $this->vesselDemandSheetRepository->getChartererList();
            return $this->responseRepository->ResponseSuccess($data, 'get Charterer List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

        /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getApproveDataDemandSheet",
     *      tags={"Vessel Demand Qnt"},
     *      summary="get Approve Data Deamand Sheet",
     *      description="get Approve Data Deamand Sheet",
     *      operationId="getApproveDataDemandSheet",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="get Approve Data Deamand Sheet"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getApproveDataDemandSheet(Request $request)
    {
        // $intLighterId = $request->intLighterId;

        try {
            $data = $this->vesselDemandSheetRepository->getApproveDataDemandSheet();
            return $this->responseRepository->ResponseSuccess($data, 'Get Approve Data');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/voyageLighter/updateApprovedInformationDataDemandSheet",
     *     tags={"Vessel Demand Qnt"},
     *     summary="Update Vessel Demand Aprv Qnt Activity",
     *     description="update Vessel Demand Aprv Qnt Activity",
     *     @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
        *              @OA\Property(property="strComments", type="string", example=1),
        *              @OA\Property(property="intUpdatedBy", type="integer", example=1),
     *              ),
     *          ),
     *      operationId="updateApprovedInformationDataDemandSheet",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Vessel Demand Qnt Activity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function updateApprovedInformationDataDemandSheet(Request $request)
    {
        try {
            $data = $this->vesselDemandSheetRepository->updateApprovedInformationDataDemandSheet($request);
            return $this->responseRepository->ResponseSuccess($data, 'Information updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getApproveDataByID",
     *      tags={"Vessel Demand Qnt"},
     *      summary="get Approve Data ByID",
     *      description="getApproveDataByID",
     *      operationId="getApproveDataByID",
     *      @OA\Parameter( name="intID", description="intID, eg; 5", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="getApproveDataByID"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getApproveDataByID(Request $request)
    {
        $intID = $request->intID;

        try {
            $data = $this->vesselDemandSheetRepository->getApproveDataByID( $intID);
            return $this->responseRepository->ResponseSuccess($data, 'Get Approve Data for Update');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




}




