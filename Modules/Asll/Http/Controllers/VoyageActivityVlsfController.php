<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VoyageActivity\VoyageActivityVlsfCreateRequest;
use Modules\Asll\Http\Requests\Voyage\VoyageActivityVlsfUpdateRequest;
use Modules\Asll\Repositories\VoyageActivityVlsfRepository;

class VoyageActivityVlsfController extends Controller
{
    public $voyageActivityVlsfRepository;
    public $responseRepository;


    public function __construct(VoyageActivityVlsfRepository $voyageActivityVlsfRepository, ResponseRepository $rp)
    {
        $this->voyageActivityVlsfRepository = $voyageActivityVlsfRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivityVlsf",
     *     tags={"Voyage Activity"},
     *     summary="Get Voyage Activity VLSFO List",
     *     description="Get Voyage Activity VLSFO List",
     *      operationId="vlsfoIndex",
     *      @OA\Response(response=200,description="Get Voyage Activity VLSFO List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function vlsfoIndex()
    {
        try {
            $data = $this->voyageActivityVlsfRepository->getVoyageActivityVlsf();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity VLSFO List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyageActivity/vlsfoStore",
     *     tags={"Voyage Activity"},
     *     summary="Create Voyage VLSFO  Activity",
     *     description="Create Voyage VLSFO  Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=2),
     *              @OA\Property(property="intVoyageID", type="integer", example=2),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-11-01 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),
     *              @OA\Property(property="decBunkerVlsfoCon", type="integer", example=2),
     *              @OA\Property(property="decBunkerVlsfoAdj", type="integer", example=2),
     *              @OA\Property(property="decBunkerVlsfoRob", type="integer", example=1),
     *              @OA\Property(property="decBunkerLsmgoCon", type="integer", example=2),
     *              @OA\Property(property="decBunkerLsmgoAdj", type="string", example="Adj"),
     *              @OA\Property(property="decBunkerLsmgoRob", type="integer", example=10.30),
     *              @OA\Property(property="decLubMeccCon", type="integer", example=33.33),
     *              @OA\Property(property="decLubMeccAdj", type="integer", example=1),
     *              @OA\Property(property="decLubMeccRob", type="string", example="Rob"),
     *              @OA\Property(property="decLubMecylCon", type="string", example="Icon"),
     *              @OA\Property(property="decLubMecylAdj", type="integer", example=1.33),
     *              @OA\Property(property="decLubMecylRob", type="integer", example=33.33),
     *              @OA\Property(property="decLubAeccCon", type="integer", example=33.33),
     *              @OA\Property(property="decLubAeccAdj", type="string"),
     *              @OA\Property(property="decLubAeccRob", type="string"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *           )
     *      ),
     *      operationId="storeVlsfo",
     *      @OA\Response(response=200,description="Create Voyage Activity Vlsf"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeVlsfo(Request $request)
    {
        try {
            $data = $this->voyageActivityVlsfRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity VLSFO Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyageActivity/vlsfoUpdate",
     *     tags={"Voyage Activity"},
     *     summary="Update Voyage Activity VLSFO",
     *     description="Update Voyage Activity VLSFO",
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
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),
     
     *              @OA\Property(property="decBunkerVlsfoCon", type="integer", example=2),
     *              @OA\Property(property="decBunkerVlsfoAdj", type="integer", example=2),
     *              @OA\Property(property="decBunkerVlsfoRob", type="integer", example=1),
     *              @OA\Property(property="decBunkerLsmgoCon", type="integer", example=2),
     *              @OA\Property(property="decBunkerLsmgoAdj", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="decBunkerLsmgoRob", type="integer", example=10.30),
     *              @OA\Property(property="decLubMeccCon", type="integer", example=33.33),
     *              @OA\Property(property="decLubMeccAdj", type="integer", example=1),
     *              @OA\Property(property="decLubMeccRob", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="decLubMecylCon", type="string", example="2008-11-11 13:23:44"),
     *              @OA\Property(property="decLubMecylAdj", type="integer", example=1.33),
     *              @OA\Property(property="decLubMecylRob", type="integer", example=33.33),
     *              @OA\Property(property="decLubAeccCon", type="integer", example=33.33),
     *              @OA\Property(property="decLubAeccAdj", type="string"),
     *              @OA\Property(property="decLubAeccRob", type="string"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1)
     *           )
     *      ),
     *      operationId="vlsfoUpdate",
     *      @OA\Response(response=200,description="Update Voyage Activity VLSFO"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function vlsfoUpdate(VoyageActivityVlsfUpdateRequest $request)
    {
        try {
            $data = $this->voyageActivityVlsfRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Activity Vlsfo Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}