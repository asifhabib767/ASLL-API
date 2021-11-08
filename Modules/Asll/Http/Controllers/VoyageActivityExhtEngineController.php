<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VoyageActivity\VoyageActivityVlsfCreateRequest;
use Modules\Asll\Http\Requests\Voyage\VoyageActivityExhtEngineUpdateRequest;
use Modules\Asll\Repositories\VoyageActivityExhtEngineRepository;

class VoyageActivityExhtEngineController extends Controller
{
    public $voyageActivityExhtEngineRepository;
    public $responseRepository;


    public function __construct(VoyageActivityExhtEngineRepository $voyageActivityExhtEngineRepository, ResponseRepository $rp)
    {
        $this->voyageActivityExhtEngineRepository = $voyageActivityExhtEngineRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/exhtIndex",
     *     tags={"Voyage Activity"},
     *     summary="Get Voyage Activity Exht Engine List",
     *     description="Get Voyage Activity Exht Engine List",
     *      operationId="exhtIndex",
     *      @OA\Response(response=200,description="Get Voyage Activity Exht Engine List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exhtIndex()
    {
        try {
            $data = $this->voyageActivityExhtEngineRepository->getVoyageActivityExhtEngine();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Exht Engine List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyageActivity/exhtStore",
     *     tags={"Voyage Activity"},
     *     summary="Create Voyage Exht Engine  Activity",
     *     description="Create Voyage Exht Engine  Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=31),
     *              @OA\Property(property="intVoyageID", type="integer", example=31),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-11-01 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="intShipEngineID", type="integer"),
     *              @OA\Property(property="strShipEngineName", type="string"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),
     *              @OA\Property(property="dceMainEngineFuelRPM", type="integer", example=2),
     *              @OA\Property(property="dceRH", type="integer", example=2),
     *              @OA\Property(property="dceLoad", type="integer", example=1),
     *              @OA\Property(property="dceExhtTemp1", type="integer", example=2),
     *              @OA\Property(property="dceExhtTemp2", type="string", example="Temp2"),
     *              @OA\Property(property="dceJacketTemp", type="integer", example=10.30),
     *              @OA\Property(property="dceScavTemp", type="integer", example=33.33),
     *              @OA\Property(property="dceLubOilTemp", type="integer", example=1),
     *              @OA\Property(property="dceTCRPM", type="string", example="RPM"),
     *              @OA\Property(property="dceJacketPressure", type="string", example="Pressure"),
     *              @OA\Property(property="dceScavPressure", type="integer", example=1.33),
     *              @OA\Property(property="dceLubOilPressure", type="integer", example=33.33),
     *              @OA\Property(property="intCreatedBy", type="integer", example=33.33),
     *           )
     *      ),
     *      operationId="storeExht",
     *      @OA\Response(response=200,description="Create VoyageActivityExhtEngine"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeExht(Request $request)
    {
        try {
            $data = $this->voyageActivityExhtEngineRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Exht Engine Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyageActivity/updateExht",
     *     tags={"Voyage Activity"},
     *     summary="Update Voyage Activity EXHT",
     *     description="Update Voyage Activity EXHT",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=31),
     *              @OA\Property(property="intVoyageID", type="integer", example=31),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="intShipEngineID", type="integer"),
     *              @OA\Property(property="strShipEngineName", type="string"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),
     *              @OA\Property(property="dceMainEngineFuelRPM", type="integer", example=2),
     *              @OA\Property(property="dceRH", type="integer", example=2),
     *              @OA\Property(property="dceLoad", type="integer", example=1),
     *              @OA\Property(property="dceExhtTemp1", type="integer", example=2),
     *              @OA\Property(property="dceExhtTemp2", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="dceJacketTemp", type="integer", example=10.30),
     *              @OA\Property(property="dceScavTemp", type="integer", example=33.33),
     *              @OA\Property(property="dceLubOilTemp", type="integer", example=1),
     *              @OA\Property(property="dceTCRPM", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="dceJacketPressure", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="dceScavPressure", type="integer", example=1.33),
     *              @OA\Property(property="dceLubOilPressure", type="integer", example=33.33),
     *              @OA\Property(property="intCreatedBy", type="integer", example=33.33),
     *           )
     *      ),
     *      operationId="updateExht",
     *      @OA\Response(response=200,description="Update Voyage Activity exht"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateExht(VoyageActivityExhtEngineUpdateRequest $request)
    {
        try {
            $data = $this->voyageActivityExhtEngineRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity exht Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}