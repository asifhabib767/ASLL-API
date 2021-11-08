<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VoyageActivity\GasNChemicalCreateRequest;
use Modules\Asll\Http\Requests\Voyage\GasNChemicalUpdateRequest;
use Modules\Asll\Repositories\GasNChemicalRepository;



class GasNChemicalController extends Controller
{
    public $gasNChemicalRepository;
    public $responseRepository;


    public function __construct(GasNChemicalRepository $gasNChemicalRepository, ResponseRepository $rp)
    {
        $this->gasNChemicalRepository = $gasNChemicalRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/indexGasNChemical",
     *     tags={"Voyage Activity"},
     *     summary="Get Gas N Chemical List",
     *     description="Get Gas N Chemical List",
     *      operationId="indexGasNChemical",
     *      @OA\Response(response=200,description="Get Gas N Chemical List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexGasNChemical()
    {
        try {
            $data = $this->gasNChemicalRepository->getGasNChemical();
            return $this->responseRepository->ResponseSuccess($data, 'Gas N Chemical List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyageActivity/gasNChemicalStore",
     *     tags={"Voyage Activity"},
     *     summary="Create Gas N Chemical  Activity",
     *     description="Create Gas N Chemical  Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",          
     *                              @OA\Property(property="intId", type="integer", example=2),
     *                              @OA\Property(property="strName", type="string", example="Oxygen"),
     *                              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              )
     *      ),
     *      operationId="gasNChemicalStore",
     *      @OA\Response(response=200,description="Create Gas N Chemical"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function gasNChemicalStore(Request $request)
    {
        try {
            $data = $this->gasNChemicalRepository->storeGasNChemicalLists($request);
            return $this->responseRepository->ResponseSuccess($data, 'Gas N Chemical Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyageActivity/gasNChemicalUpdate",
     *     tags={"Voyage Activity"},
     *     summary="Update Gas N Chemical Activity",
     *     description="Update Gas N Chemical Activity",
     *     @OA\Property(property="intVoyageActivityID", type="integer", example=2),
     *     @OA\Parameter( name="intVoyageActivityID", description="intVoyageActivityID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
    
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="gasNChemical",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intId", type="integer", example=2),
     *                              @OA\Property(property="strName", type="string", example="Oxygen"),
     *                              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="gasNChemicalUpdate",
     *      @OA\Response(response=200,description="Update Vessel"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function gasNChemicalUpdate(GasNChemicalUpdateRequest $request)
    {
        try {
            $data = $this->gasNChemicalRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Gas N Chemical Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}