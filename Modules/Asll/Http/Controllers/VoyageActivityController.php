<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VoyageActivity\VoyageActivityCreateRequest;
use Modules\Asll\Http\Requests\VoyageActivity\VoyageActivityUpdateRequest;
use Modules\Asll\Repositories\VoyageActivityRepository;

class VoyageActivityController extends Controller
{
    public $voyageActivityRepository;
    public $responseRepository;


    public function __construct(VoyageActivityRepository $voyageActivityRepository, ResponseRepository $rp)
    {
        $this->voyageActivityRepository = $voyageActivityRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity",
     *     tags={"Voyage Activity"},
     *     summary="Get Voyage Activity List",
     *     description="Get Voyage Activity List",
     *      operationId="index",
     *      @OA\Parameter(name="search", description="search, eg; 1", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter(name="voyage", description="voyage, eg; 1", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter(name="vessel", description="vessel ID, eg; 1", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Response(response=200,description="Get Voyage List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function index()
    {
        try {
            $data = $this->voyageActivityRepository->getVoyageActivity();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/getWindDirection",
     *     tags={"Voyage Activity"},
     *     summary="Get Voyage Activity List",
     *     description="Get Voyage Activity List",
     *      operationId="getWindDirection",
     *      @OA\Response(response=200,description="Get Voyage List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getWindDirection()
    {
        try {
            $data = $this->voyageActivityRepository->getWindDirection();
            return $this->responseRepository->ResponseSuccess($data, 'Direction List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/show/{id}",
     *     tags={"Voyage Activity"},
     *     summary="Show Voyage Activity",
     *     description="Show Voyage Activity",
     *      operationId="destroy",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Show Voyage Activity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id)
    {
        try {
            $data = $this->voyageActivityRepository->show($id);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Details !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/showByDate",
     *     tags={"Voyage Activity"},
     *     summary="Show Voyage Activity By Date",
     *     description="Show Voyage Activity By Date",
     *      operationId="showByDate",
     *      @OA\Parameter( name="date", description="date, eg; 1", required=true, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="intVoyageID", description="intVoyageID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Show Voyage Activity By Date"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function showByDate(Request $request)
    {
        try {
            $data = $this->voyageActivityRepository->showByDate($request->date, $request->intVoyageID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Details !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyageActivity/store",
     *     tags={"Voyage Activity"},
     *     summary="Create Voyage Activity",
     *     description="Create Voyage Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="intVoyageID", type="integer", example=2),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-01"),
     *              @OA\Property(property="decLatitude", type="integer", example=10.30),
     *              @OA\Property(property="decLongitude", type="integer", example=33.33),
     *              @OA\Property(property="intCourse", type="integer", example=1),
     *              @OA\Property(property="timeSeaStreaming", type="string", example="2020-10-01 10:10:10"),
     *              @OA\Property(property="timeSeaStoppage", type="string", example="2020-10-01 10:10:10"),
     *              @OA\Property(property="decSeaDistance", type="integer", example=1.33),
     *              @OA\Property(property="decSeaDailyAvgSpeed", type="integer", example=33.33),
     *              @OA\Property(property="decSeaGenAvgSpeed", type="integer", example=33.33),
     *              @OA\Property(property="strSeaDirection", type="string"),
     *              @OA\Property(property="strSeaState", type="string"),
     *              @OA\Property(property="strWindDirection", type="string", example="Shengjjin"),
     *              @OA\Property(property="decWindBF", type="integer", example=3),
     *              @OA\Property(property="intETAPortToID", type="integer"),
     *              @OA\Property(property="strETAPortToName", type="string"),
     *              @OA\Property(property="intETDPortToID", type="integer", example=96),
     *              @OA\Property(property="strETDPortToName", type="string"),
     *              @OA\Property(property="strETADateTime", type="string", example="2020-10-01"),
     *              @OA\Property(property="strRemarks", type="string", example="88"),
     *              @OA\Property(property="intVoyagePortID", type="integer"),
     *              @OA\Property(property="decTimePortWorking", type="integer", example=1.22),
     *              @OA\Property(property="strPortDirection", type="string"),
     *              @OA\Property(property="strPortDSS", type="string"),
     *              @OA\Property(property="strETDDateTime", type="string", example="2020-10-01"),
     *              @OA\Property(property="decCargoTobeLD", type="integer"),
     *              @OA\Property(property="decCargoPrevLD", type="integer"),
     *              @OA\Property(property="decCargoDailyLD", type="integer"),
     *              @OA\Property(property="decCargoTTLLD", type="integer"),
     *              @OA\Property(property="decCargoBalanceCGO", type="integer"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *
     *              @OA\Property(property="decProduction", type="integer"),
     *              @OA\Property(property="decConsumption", type="integer"),
     *              @OA\Property(property="decSeaTemp", type="integer"),
     *              @OA\Property(property="decAirTemp", type="integer"),
     *              @OA\Property(property="decBaroPressure", type="integer"),
     *              @OA\Property(property="decTotalDistance", type="integer"),
     *              @OA\Property(property="decDistanceToGo", type="integer"),
     *           )
     *      ),
     *      operationId="store",
     *      @OA\Response(response=200,description="Create VoyageActivity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $this->voyageActivityRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyageActivity/update",
     *     tags={"Voyage Activity"},
     *     summary="Update Voyage Activity",
     *     description="Update Voyage Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=1),
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="intVoyageID", type="integer", example=2),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="decLatitude", type="integer", example=10.30),
     *              @OA\Property(property="decLongitude", type="integer", example=33.33),
     *              @OA\Property(property="intCourse", type="integer", example=1),
     *              @OA\Property(property="timeSeaStreaming", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="timeSeaStoppage", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="decSeaDistance", type="integer", example=1.33),
     *              @OA\Property(property="decSeaDailyAvgSpeed", type="integer", example=33.33),
     *              @OA\Property(property="decSeaGenAvgSpeed", type="integer", example=33.33),
     *              @OA\Property(property="strSeaDirection", type="string", example="Shengjjin"),
     *              @OA\Property(property="strSeaState", type="string", example="Shengjjin"),
     *              @OA\Property(property="strWindDirection", type="string", example="Shengjjin"),
     *              @OA\Property(property="decWindBF", type="integer", example=3),
     *              @OA\Property(property="intETAPortToID", type="integer", example=33),
     *              @OA\Property(property="strETAPortToName", type="string", example="Shengjjin"),
     *              @OA\Property(property="intETDPortToID", type="integer", example=96),
     *              @OA\Property(property="strETDPortToName", type="string", example="71"),
     *              @OA\Property(property="strETADateTime", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="strRemarks", type="string", example="88"),
     *              @OA\Property(property="intVoyagePortID", type="integer", example=8),
     *              @OA\Property(property="decTimePortWorking", type="integer", example=88.22),
     *              @OA\Property(property="strPortDirection", type="string", example="88"),
     *              @OA\Property(property="strPortDSS", type="string", example="88"),
     *              @OA\Property(property="strETDDateTime", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="decCargoTobeLD", type="integer", example=88.33),
     *              @OA\Property(property="decCargoPrevLD", type="integer", example=88.33),
     *              @OA\Property(property="decCargoDailyLD", type="integer", example=88.33),
     *              @OA\Property(property="decCargoTTLLD", type="integer", example=88.33),
     *              @OA\Property(property="decCargoBalanceCGO", type="integer", example=88.33),
     *           )
     *      ),
     *      operationId="update",
     *      @OA\Response(response=200,description="Update VoyageActivity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $data = $this->voyageActivityRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/voyageActivitySeaDistenceCalculation",
     *     tags={"Voyage Activity"},
     *     summary="Show Voyage Activity By Date",
     *     description="Show Voyage Activity By Date",
     *      operationId="voyageActivitySeaDistenceCalculation",
     *      @OA\Parameter( name="intVoyageID", description="intVoyageID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Show Voyage Activity By VoyageId"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function voyageActivitySeaDistenceCalculation(Request $request)
    {

        try {
            $data = $this->voyageActivityRepository->voyageActivitySeaDistenceCalculation($request->intVoyageID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
