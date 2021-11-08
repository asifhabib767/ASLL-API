<?php

namespace Modules\VoyageLighter\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\VoyageLighter\Repositories\LighterUnloadRepository;

class LighterUnloadController extends Controller
{
    public $lighterUnloadRepository;
    public $responseRepository;

    /**
     * Display a listing of the resource.
     */
    public function __construct(LighterUnloadRepository $lighterUnloadRepository, ResponseRepository $rp)
    {
        $this->lighterUnloadRepository = $lighterUnloadRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighterLoadingPointOrVesselType",
     *      tags={"Lighter Unload & StandBy"},
     *      summary="getVesselTypeOrPointType",
     *      description="getVesselTypeOrPointType",
     *      operationId="getLighterLoadingPointOrVesselType",
     *      @OA\Parameter( name="intVesselTypeOrPointTypeID", description="intVesselTypeOrPointTypeID, eg; 1", in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="getVesselTypeOrPointType"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighterLoadingPointOrVesselType(Request $request)
    {
        $intVesselTypeOrPointTypeID = $request->intVesselTypeOrPointTypeID;

        try {
            $data = $this->lighterUnloadRepository->getVesselTypeOrPointType($intVesselTypeOrPointTypeID);
            return $this->responseRepository->ResponseSuccess($data, 'Loading Point List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/voyageLighter/postlighterVoyageUnloadNStockQntStore",
     *     tags={"Lighter Unload & StandBy"},
     *     summary="Create UnloadNStockQnt Activity",
     *     description="Create UnloadNStockQnt Activity",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="dteDate", type="string", example="2020-12-02"),
     *              @OA\Property(property="intTypeID", type="integer", example=1),
     *              @OA\Property(property="strTypeName", type="string", example="Akij"),
     *              @OA\Property(property="intCategoryId", type="integer", example=1),
     *              @OA\Property(property="strCategoryName", type="string", example="Akij"),
     *              @OA\Property(property="intInsertBy", type="integer", example=1),
     *              @OA\Property(
     *                      property="unloadData",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="intItemID", type="integer", example=1),
     *                              @OA\Property(property="strItemName", type="string", example="Test"),
     *                              @OA\Property(property="decQnt", type="integer", example=1),
     *                              @OA\Property(property="intTypeId", type="integer", example=1)
     *                          ),
     *                  ),
     *              ),
     *          ),
     *      operationId="postlighterVoyageUnloadNStockQntStore",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create UnloadNStockQnt Activity"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postlighterVoyageUnloadNStockQntStore(Request $request)
    {
        try {
            $data = $this->lighterUnloadRepository->postlighterVoyageUnloadNStockQntStore($request);
            return $this->responseRepository->ResponseSuccess($data, 'Lighter UnloadNStockQnt Activity Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 /**
     * @OA\GET(
     *      path="/api/v1/voyageLighter/getLighterUnloadCategory",
     *      tags={"Lighter Unload & StandBy"},
     *      summary="getVesselTypeOrPointType",
     *      description="getVesselTypeOrPointType",
     *      operationId="getLighterUnloadCategory",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="getVesselTypeOrPointType"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighterUnloadCategory(Request $request)
    {
        $intVesselTypeOrPointTypeID = $request->intVesselTypeOrPointTypeID;

        try {
            $data = $this->lighterUnloadRepository->getLighterUnloadCategory();
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Unload Catg');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/lighterUnload/getLighterUnload",
     *     tags={"Lighter Unload"},
     *     summary="Get Lighter Unload List",
     *     description="Get Lighter Unload List",
     *     operationId="getLighterUnload",
     *     @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-12-17", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-12-30", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Get Lighter Unload List"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLighterUnload(Request $request)
    {
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        try {
            $data = $this->lighterUnloadRepository->getLighterUnload($dteStartDate, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Lighter Unload List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
