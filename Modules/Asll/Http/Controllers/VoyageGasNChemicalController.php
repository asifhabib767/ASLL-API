<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VoyageActivity\VoyageGasNChemicalCreateRequest;
use Modules\Asll\Http\Requests\Voyage\VoyageGasNChemicalUpdateRequest;
use Modules\Asll\Repositories\VoyageGasNChemicalRepository;



class VoyageGasNChemicalController extends Controller
{
    public $voyageGasNChemicalRepository;
    public $responseRepository;


    public function __construct(VoyageGasNChemicalRepository $voyageGasNChemicalRepository, ResponseRepository $rp)
    {
        $this->voyageGasNChemicalRepository = $voyageGasNChemicalRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyageActivity/indexVoyageGasNChemical",
     *     tags={"Voyage Activity"},
     *     summary="Get Voyage Gas N Chemical List",
     *     description="Get Voyage Gas N Chemical List",
     *      operationId="indexVoyageGasNChemical",
     *      @OA\Response(response=200,description="Get Voyage Gas N Chemical List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexVoyageGasNChemical()
    {
        try {
            $data = $this->voyageGasNChemicalRepository->getVoyageGasNChemical();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Gas N Chemical List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyageActivity/voyageGasNChemicalStore",
     *     tags={"Voyage Activity"},
     *     summary="Create Voyage Gas N Chemical  Activity",
     *     description="Create Voyage Gas N Chemical  Activity",
     * 
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUnitId", type="integer", example=17),
     *              @OA\Property(property="intVoyageID", type="integer", example=17),
     *              @OA\Property(property="intShipPositionID", type="integer", example=1),
     *              @OA\Property(property="intShipConditionTypeID", type="integer", example=2),
     *              @OA\Property(property="dteCreatedAt", type="string", example="2020-09-26 13:23:44"),
     *              @OA\Property(property="strRPM", type="string"),
     *              @OA\Property(property="decEngineSpeed", type="integer"),
     *              @OA\Property(property="decSlip", type="integer"),
     *              @OA\Property(property="strRemarks", type="string", example="Remarks"),
     *              @OA\Property(
     *                      property="voyageGasNChemical",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intGasNChemicalId", type="integer", example=1),
     *                              @OA\Property(property="intVoyageActivityGasNChemicalMainID", type="integer", example=1),
     *                              @OA\Property(property="strGasNChemicalName", type="string", example="Oxygen"),
     *                              @OA\Property(property="decBFWD", type="integer", example=1),
     *                              @OA\Property(property="decRecv", type="integer", example=2),
     *                              @OA\Property(property="dectotal", type="integer", example=1),
     *                              @OA\Property(property="decCons", type="integer", example=1),
     *                              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="voyageGasNChemicalStore",
     *      @OA\Response(response=200,description="Create Voyage Gas N Chemical"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function voyageGasNChemicalStore(Request $request)
    {
        $isNull = false;
        foreach($request->voyageGasNChemical as $checkItem){

            if($checkItem["decBFWD"] =! 0 || $checkItem["decRecv"] =! 0 || $checkItem["dectotal"] =! 0 || $checkItem["decCons"] =! 0){
                $isNull = false;
            }
        }
        if ($isNull===true){
            return "You have given No item";
        }

        try {
            $data = $this->voyageGasNChemicalRepository->voyageGasNChemicalStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Gas N Chemical Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyageActivity/voyageGasNChemicalUpdate",
     *     tags={"Voyage Activity"},
     *     summary="Update Voyage Gas N Chemical  Activity",
     *     description="Update Voyage Gas N Chemical  Activity",
     *     @OA\Property(property="intVoyageID", type="integer", example=2),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *                @OA\Property(property="intGasNChemicalId", type="integer", example=2),
     *                @OA\Property(property="intVoyageActivityGasNChemicalMainID", type="integer", example=1),
     *                @OA\Property(property="decBFWD", type="integer", example=1),
     *                @OA\Property(property="decRecv", type="integer", example=2),
     *                @OA\Property(property="dectotal", type="integer", example=1),
     *                @OA\Property(property="decCons", type="integer", example=1),
     *                @OA\Property(property="intCreatedBy", type="integer", example=1),
     *                @OA\Property(property="intUpdatedBy", type="integer", example=1),
     *                @OA\Property(property="intDeletedBy", type="integer", example=1),
     *                @OA\Property(property="strGasNChemicalName", type="string", example=1),
     *                @OA\Property(property="strRemarks", type="string", example="Remarks")
     *              )
     *      ),
     *      operationId="voyageGasNChemicalUpdate",
     *      @OA\Response(response=200,description="Update voyageGasNChemical"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function voyageGasNChemicalUpdate(VoyageGasNChemicalUpdateRequest $request)
    {
        try {
            $data = $this->voyageGasNChemicalRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Gas N Chemical Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}