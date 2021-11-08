<?php

namespace Modules\VoyageLighter\Http\Controllers;


use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\VoyageLighter\Repositories\LighterVoyageActivityRepository;

class LighterVoyageActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct(LighterVoyageActivityRepository $lighterVoyageActivityRepository, ResponseRepository $rp)
    {
        $this->lighterVoyageActivityRepository = $lighterVoyageActivityRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighterVoyageActivity",
     *      tags={"Voyage Lighter"},
     *      summary="Get Lighter Voyage Activity List",
     *      description="Get Lighter Voyage Activity List",
     *      operationId="getLighterVoyageActivity",
     *      @OA\Response(response=200,description="Get LighterVoyageActivity List"),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighterVoyageActivity()
    {
        try {
            $data = $this->lighterVoyageActivityRepository->getLighterVoyageActivity();
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Voyage Activity List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/voyageLighter/lighterVoyageActivityStore",
     *     tags={"Voyage Lighter"},
     *     summary="Create Voyage Lighter Activity",
     *     description="Create Voyage Lighter Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intLighterVoyageId", type="integer", example=1),
     *              @OA\Property(property="intLighterPositionStatusId", type="integer", example=1),
     *              @OA\Property(property="dteCompletionDate", type="string", example="2020-12-02"),
     *              @OA\Property(property="strCompletionTime", type="string", example="2020-12-02"),
     *              @OA\Property(property="strAdditionalStatus", type="string", example="no"),
     *              @OA\Property(property="ysnStatus", type="boolean", example=1),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              )
     *      ),
     *      operationId="lighterVoyageActivityStore",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Lighter Voyage Activity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function lighterVoyageActivityStore(Request $request)
    {
        try {
            $data = $this->lighterVoyageActivityRepository->lighterVoyageActivityStore($request);
            if($data == 0){
                return $this->responseRepository->ResponseError(null, 'You have not completed previous status', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Voyage Activity Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


 /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighterVoyageTopsheet",
     *      tags={"Voyage Lighter"},
     *      summary="Get Lighter Voyage Topsheet List",
     *      description="Get Lighter Voyage Topsheet List",
     *      operationId="getLighterVoyageTopsheet",
     *      @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get LighterVoyageActivity List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighterVoyageTopsheet(Request $request)
    {
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;


        // return  $dteStartDate;
        try {
            $data = $this->lighterVoyageActivityRepository->getLighterVoyageTopsheet ($dteStartDate, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Voyage Activity List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighterVoyageDetaillsByID",
     *      tags={"Voyage Lighter"},
     *      summary="Get Lighter Voyage Det by id",
     *      description="Get Lighter Voyage Det by id",
     *      operationId="getLighterVoyageDetaillsByID",
     *      @OA\Parameter( name="intID", description="intID, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get LighterVoyageActivity List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighterVoyageDetaillsByID(Request $request)
    {
        $intID = $request->intID;


        // return  $intID;
        try {
            $data = $this->lighterVoyageActivityRepository->getLighterVoyageDetaillsByID ($intID);
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Voyage Activity List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


/**
     * @OA\PUT(
     *      path="/api/v1/voyageLighter/voyageActivityupdate",
     *     tags={"Vessel Demand Qnt"},
     *     summary="Update Voyage Activity",
     *     description="update Voyage Activity",
     *     @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="decTripCost", description="decTripCost, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="decPilotCoupon", description="decPilotCoupon, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="decFreightRate", description="decFreightRate, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intSurveyNumber", description="intSurveyNumber, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="strPartyName", description="strPartyName, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="strPartyCode", description="strPartyCode, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
        *              @OA\Property(property="intSurveyNo", type="int", example=1),
        *              @OA\Property(property="intSurveyQty", type="integer", example=1),
        *              @OA\Property(property="intItemId", type="integer", example=1),
        *              @OA\Property(property="strItemName", type="string", example=1),
        *              @OA\Property(property="intID", type="int", example=1),
        *              @OA\Property(property="intVoyageLighterId", type="int", example=1),
     *              ),
     *          ),
     *      operationId="voyageActivityupdate",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Vessel Demand Qnt Activity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function voyageActivityupdate(Request $request)
    {
        try {
            $data = $this->lighterVoyageActivityRepository->voyageActivityupdate($request);
            return $this->responseRepository->ResponseSuccess($data, 'Information updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getCreditorList",
     *      tags={"Voyage Lighter"},
     *      summary="Get Creditor List",
     *      description="Get Creditor List",
     *      operationId="getCreditorList",

     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Creditor List "),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCreditorList()
    {



        // return  $intID;
        try {
            $data = $this->lighterVoyageActivityRepository->getCreditorList ();
            return $this->responseRepository->ResponseSuccess($data, 'Creditor List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getMotherVesselList",
     *      tags={"Voyage Lighter"},
     *      summary="Get Mother Vessel List",
     *      description="Get Mother Vessel List",
     *      operationId="getMotherVesselList",
     *     security={{"bearer": {}}},

     *      @OA\Response(response=200,description="Get Mother Vessel List "),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMotherVesselList()
    {



        // return  $intID;
        try {
            $data = $this->lighterVoyageActivityRepository->getMotherVesselList ();
            return $this->responseRepository->ResponseSuccess($data, 'Mother Vessel List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
