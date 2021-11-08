<?php

namespace Modules\VoyageLighter\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Asset\Http\Requests\VoyageLighterMainRequest;
use Illuminate\Routing\Controller;
use Modules\VoyageLighter\Repositories\VoyageLighterMainRepository;
use Modules\Asset\Entities\LighterVoyageMain;

class VoyageLighterMainController extends Controller
{

    public $voyageLighterMainRepository;
    public $responseRepository;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct(VoyageLighterMainRepository $voyageLighterMainRepository, ResponseRepository $rp)
    {
        $this->voyageLighterMainRepository = $voyageLighterMainRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighterVoyageMain",
     *      tags={"Voyage Lighter"},
     *      summary="Get Lighter Voyage Main List",
     *      description="Get Lighter Voyage Main List",
     *      operationId="getLighterVoyageMain",
     *      @OA\Parameter( name="intLighterId", description="intLighterId, eg; Lighter ID", required=true, in="query", @OA\Schema(type="string")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Lighter Voyage Main List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getLighterVoyageMain(Request $request)
    {
        try {
            $data = $this->voyageLighterMainRepository->getAll();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Lighter Main List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\PUT(
     *      path="/api/v1/voyageLighter/lighterUpdate",
     *      tags={"Voyage Lighter"},
     *      summary="Update Voyage Lighter Lighter",
     *      description="Update Voyage Lighter Lighter",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intLoadingPointId", type="integer", example=1),
     *              @OA\Property(property="strLoadingPointName", type="string", example="Kutubdia"),
     *              @OA\Property(property="intDischargePortID", type="integer", example=1),
     *              @OA\Property(property="strDischargePortName", type="string", example="Chittagong"),
     *              @OA\Property(property="intLighterId", type="integer", example=1),
     *              @OA\Property(property="strLighterName", type="string" , example="Akij Lighter"),
     *              @OA\Property(property="dteVoyageCommencedDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="dteVoyageCompletionDate", type="string", example="2020-12-10"),
     *              @OA\Property(property="monTotalExpense", type="integer" , example=5000),
     *              @OA\Property(
     *              property="voyageLighters",
     *              type="array",
     *              @OA\Items(
     *                        @OA\Property(property="intID", type="integer", example=1),
     *                        @OA\Property(property="intVoyageLighterId", type="integer", example=1),
     *                        @OA\Property(property="intItemId", type="integer", example=1),
     *                        @OA\Property(property="strItemName", type="string", example="Oxygen"),
     *                        @OA\Property(property="intQuantity", type="integer", example=1),
     *                        @OA\Property(property="intVesselId", type="integer", example=1),
     *                        @OA\Property(property="strVesselName", type="string", example="Noor"),
     *                        @OA\Property(property="dteETAVessel", type="string", example="2020-11-24"),
     *                        @OA\Property(property="intVoyageId", type="integer", example=1),
     *                        @OA\Property(property="intVoyageNo", type="integer", example=1),
     *                        @OA\Property(property="strLCNo", type="string", example="1"),
     *                        @OA\Property(property="intBoatNoteQty", type="integer", example=1),
     *                        @OA\Property(property="intSurveyNo", type="integer", example=1),
     *                        @OA\Property(property="intSurveyQty", type="integer", example=1),
     *                        @OA\Property(property="strPartyName", type="string", example="Akij Party"),
     *                        @OA\Property(property="intPartyID", type="integer", example=1),
     *                        @OA\Property(property="decFreightRate", type="float", example=1.00),
     *                          ),
     *                      ),
     *              @OA\Property(
     *              property="oilStatements",
     *              type="array",
     *              @OA\Items(
     *                        @OA\Property(property="intID", type="integer", example=1),
     *                        @OA\Property(property="intFuelLogId", type="integer", example=1),
     *                        @OA\Property(property="intFuelTypeId", type="string", example="Akij Party"),
     *                        @OA\Property(property="strFuelTypeName", type="string", example="Akij Party"),
     *                        @OA\Property(property="decFuelPrice", type="float", example=1.00),
     *                        @OA\Property(property="decFuelQty", type="float", example=1.00),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="lighterUpdate",
     *      @OA\Parameter( name="intID", description="intID, eg; 5", required=true, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Voyage Lighter"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function lighterUpdate(Request $request)
    {
        try {
            $data = $this->voyageLighterMainRepository->lighterUpdate($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Lighter Information Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
