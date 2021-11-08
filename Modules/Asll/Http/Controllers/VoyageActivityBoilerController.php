<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VoyageActivity\VoyageActivityBoilerCreateRequest;
use Modules\Asll\Http\Requests\Voyage\VoyageActivityBoilerUpdateRequest;
use Modules\Asll\Repositories\VoyageActivityBoilerRepository;



class VoyageActivityBoilerController extends Controller
{
    public $voyageActivityBoilerRepository;
    public $responseRepository;


    public function __construct(VoyageActivityBoilerRepository $voyageActivityBoilerRepository, ResponseRepository $rp)
    {
        $this->voyageActivityBoilerRepository = $voyageActivityBoilerRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/indexBoiler",
     *     tags={"Voyage Activity"},
     *     summary="Get Voyage Activity Boiler List",
     *     description="Get Voyage Activity Boiler List",
     *      operationId="indexBoiler",
     *      @OA\Response(response=200,description="Get Voyage Activity Boiler List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexBoiler()
    {
        try {
            $data = $this->voyageActivityBoilerRepository->getVoyageActivityBoiler();
            return $this->responseRepository->ResponseSuccess($data, "Voyage Activity Boiler List");
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyageActivity/boilerStore",
     *     tags={"Voyage Activity"},
     *     summary="Create Voyage Activity Boiler  Activity",
     *     description="Create Voyage Activity Boiler  Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=17),
     *              @OA\Property(property="intVoyageID", type="integer", example=17),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-11-01 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="intShipEngineID", type="integer"),
     *              @OA\Property(property="strShipEngineName", type="string"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),
     *              @OA\Property(
     *                      property="boilerlists",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="decWorkingPressure", type="integer", example=2),
     *                              @OA\Property(property="decPhValue", type="integer", example=1),
     *                              @OA\Property(property="decChloride", type="integer", example=2),
     *                              @OA\Property(property="decAlkalinity", type="integer", example=1),
     *                              @OA\Property(property="dteCreatedAt", type="string", example="2020-10-01"),
     *                              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="boilerStore",
     *      @OA\Response(response=200,description="Create Voyage Activity Boiler"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function boilerStore(Request $request)
    {
        try {
            $data = $this->voyageActivityBoilerRepository->storeBoilerLists($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Boiler Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyageActivity/boilerUpdate",
     *     tags={"Voyage Activity"},
     *     summary="Update Voyage Activity Boiler  Activity",
     *     description="Update Voyage Activity Boiler  Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=17),
     *              @OA\Property(property="intVoyageID", type="integer", example=17),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-11-01 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="intShipEngineID", type="integer"),
     *              @OA\Property(property="strShipEngineName", type="string"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),

     *              @OA\Property(property="decWorkingPressure", type="integer", example=2),
     *              @OA\Property(property="decPhValue", type="integer", example=1),
     *              @OA\Property(property="decChloride", type="integer", example=2),
     *              @OA\Property(property="decAlkalinity", type="string", example="Alka"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *           )
     *      ),
     *      operationId="boilerUpdate",
     *      @OA\Response(response=200,description="Update Vessel"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function boilerUpdate(VoyageActivityBoilerUpdateRequest $request)
    {
        try {
            $data = $this->voyageActivityBoilerRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Boiler Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}