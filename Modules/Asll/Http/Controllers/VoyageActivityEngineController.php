<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VoyageActivity\VoyageActivityEngineCreateRequest;
use Modules\Asll\Http\Requests\Voyage\VoyageActivityEngineUpdateRequest;
use Modules\Asll\Repositories\VoyageActivityEngineRepository;

class VoyageActivityEngineController extends Controller
{
    public $voyageActivityEngineRepository;
    public $responseRepository;


    public function __construct(VoyageActivityEngineRepository $voyageActivityEngineRepository, ResponseRepository $rp)
    {
        $this->voyageActivityEngineRepository = $voyageActivityEngineRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/engine",
     *     tags={"Voyage Activity"},
     *     summary="Get Voyage Activity Engine List",
     *     description="Get Voyage Activity Engine List",
     *      operationId="indexEngine",
     *      @OA\Response(response=200,description="Get Voyage Activity Engine List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexEngine()
    {
        try {
            $data = $this->voyageActivityEngineRepository->getVoyageActivityEngine();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Engine List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyageActivity/engineStore",
     *     tags={"Voyage Activity"},
     *     summary="Create Voyage Activity Engine  Activity",
     *     description="Create Voyage Activity Engine  Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="intVoyageID", type="integer", example=2),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="intShipEngineID", type="integer"),
     *              @OA\Property(property="strShipEngineName", type="string"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),
     *              @OA\Property(property="dceJacketTemp1", type="integer", example=2.33),
     *              @OA\Property(property="dceJacketTemp2", type="integer", example=2.33),
     *              @OA\Property(property="dcePistonTemp1", type="integer", example=1.33),
     *              @OA\Property(property="dcePistonTemp2", type="integer", example=2.33),
     *              @OA\Property(property="dceExhtTemp1", type="integer", example=2.33),
     *              @OA\Property(property="dceExhtTemp2", type="integer", example=10.30),
     *              @OA\Property(property="dceScavTemp1", type="integer", example=33.33),
     *              @OA\Property(property="dceScavTemp2", type="integer", example=1),
     *              @OA\Property(property="dceTurboCharger1Temp1", type="integer", example=2.3),
     *              @OA\Property(property="dceTurboCharger1Temp2", type="integer", example=2.3),
     *              @OA\Property(property="dceEngineLoad", type="integer", example=1.33),
     *              @OA\Property(property="dceJacketCoolingTemp1", type="integer", example=33.33),
     *              @OA\Property(property="dcePistonCoolingTemp1", type="integer", example=33.33),
     *              @OA\Property(property="dceLubOilCoolingTemp1", type="integer"),
     *              @OA\Property(property="dceFuelCoolingTemp1", type="integer"),
     *              @OA\Property(property="dceScavCoolingTemp1", type="integer"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *           )
     *      ),
     *      operationId="engineStore",
     *      @OA\Response(response=200,description="Create Voyage Activity Engine"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function engineStore(Request $request)
    {
        try {
            $data = $this->voyageActivityEngineRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Engine Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyageActivity/engineUpdate",
     *     tags={"Voyage Activity"},
     *     summary="Update Voyage Activity Engine",
     *     description="Update Voyage Activity Engine",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="intVoyageID", type="integer", example=2),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="intShipEngineID", type="integer"),
     *              @OA\Property(property="strShipEngineName", type="string"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),

     *              @OA\Property(property="dceJacketTemp1", type="integer", example=2.33),
     *              @OA\Property(property="dceJacketTemp2", type="integer", example=2.33),
     *              @OA\Property(property="dcePistonTemp1", type="integer", example=1.33),
     *              @OA\Property(property="dcePistonTemp2", type="integer", example=2.33),
     *              @OA\Property(property="dceExhtTemp1", type="integer", example=2.33),
     *              @OA\Property(property="dceExhtTemp2", type="integer", example=10.30),
     *              @OA\Property(property="dceScavTemp1", type="integer", example=33.33),
     *              @OA\Property(property="dceScavTemp2", type="integer", example=1),
     *              @OA\Property(property="dceTurboCharger1Temp1", type="integer", example=2.3),
     *              @OA\Property(property="dceTurboCharger1Temp2", type="integer", example=2.3),
     *              @OA\Property(property="dceEngineLoad", type="integer", example=1.33),
     *              @OA\Property(property="dceJacketCoolingTemp1", type="integer", example=33.33),
     *              @OA\Property(property="dcePistonCoolingTemp1", type="integer", example=33.33),
     *              @OA\Property(property="dceLubOilCoolingTemp1", type="integer"),
     *              @OA\Property(property="dceFuelCoolingTemp1", type="integer"),
     *              @OA\Property(property="dceScavCoolingTemp1", type="integer"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     * )
     *      ),
     *      operationId="engineUpdate",
     *      @OA\Response(response=200,description="Update Voyage Activity Engine"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function engineUpdate(VoyageActivityEngineUpdateRequest $request)
    {
        try {
            $data = $this->voyageActivityEngineRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Engine Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}