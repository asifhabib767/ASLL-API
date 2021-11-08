<?php

namespace Modules\VoyageLighter\Http\Controllers;


use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\VoyageLighter\Repositories\FuelLogRepository;

class FuelLogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct(FuelLogRepository $fuelLogRepository, ResponseRepository $rp)
    {
        $this->fuelLogRepository = $fuelLogRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getFuelLog",
     *      tags={"Voyage Lighter"},
     *      summary="Get Fuel Log List",
     *      description="Get Fuel Log List",
     *      operationId="getFuelLog",
     *      @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-08-01", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Fuel Log List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getFuelLog(Request $request)
    {
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        try {
            $data = $this->fuelLogRepository->getFuelLog($dteStartDate, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Fuel Log List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/voyageLighter/fuelLogStore",
     *     tags={"Voyage Lighter"},
     *     summary="Create Fuel Log Lighter",
     *     description="Create Fuel Log Lighter",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intLighterId", type="integer", example=1),
     *              @OA\Property(property="strLighterName", type="string", example="Pearl"),
     *              @OA\Property(property="dteDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="strDetails", type="string", example="Details"),
     *              @OA\Property(property="intVoyageId", type="integer", example=1),
     *              @OA\Property(property="intVoyageNo", type="integer", example=1),
     *              @OA\Property(property="ysnActive", type="integer", example=1),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(
     *                      property="logLists",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intLighterId", type="integer", example=1),
     *                              @OA\Property(property="intFuelLogId", type="integer", example=1),
     *                              @OA\Property(property="intFuelTypeId", type="integer", example=1),
     *                              @OA\Property(property="strFuelTypeName", type="string", example="Oxygen"),
     *                              @OA\Property(property="decFuelPrice", type="integer", example=1),
     *                              @OA\Property(property="decFuelQty", type="float", example=1.1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="fuelLogStore",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create Fuel Log"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function fuelLogStore(Request $request)
    {
        try {
            $data = $this->fuelLogRepository->fuelLogStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Fuel Log Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *      path="/api/v1/voyageLighter/fuelLogUpdate",
     *     tags={"Voyage Lighter"},
     *     summary="update Fuel Log Lighter",
     *     description="update Fuel Log Lighter",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intLighterId", type="integer", example=1),
     *              @OA\Property(property="strLighterName", type="string", example="Pearl"),
     *              @OA\Property(property="dteDate", type="string", example="2020-11-24"),
     *              @OA\Property(property="strDetails", type="string", example="Details"),
     *              @OA\Property(property="intVoyageId", type="integer", example=1),
     *              @OA\Property(property="intVoyageNo", type="integer", example=1),
     *              @OA\Property(property="ysnActive", type="integer", example=1),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(
     *                      property="logLists",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intLighterId", type="integer", example=1),
     *                              @OA\Property(property="intFuelLogId", type="integer", example=1),
     *                              @OA\Property(property="intFuelTypeId", type="integer", example=1),
     *                              @OA\Property(property="strFuelTypeName", type="string", example="Oxygen"),
     *                              @OA\Property(property="decFuelPrice", type="integer", example=1),
     *                              @OA\Property(property="decFuelQty", type="float", example=1.1),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="fuelLogUpdate",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update fuel Log"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function fuelLogUpdate(Request $request)
    {
        try {
            $data = $this->fuelLogRepository->fuelLogUpdate($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'fuel Log Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
