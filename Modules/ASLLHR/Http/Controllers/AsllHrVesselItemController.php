<?php

namespace Modules\ASLLHR\Http\Controllers;

use Modules\ASLLHR\Http\Requests\VesselItemRequest;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\AsllHrVesselItemRepository;

class AsllHrVesselItemController extends Controller
{
    public $vesselItemRepository;
    public $responseRepository;

    public function __construct(AsllHrVesselItemRepository $vesselItemRepository, ResponseRepository $rp)
    {
        // $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->vesselItemRepository = $vesselItemRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/vesselItem",
     *     tags={"ASLLHR"},
     *     summary="Get Vessel Item List",
     *     description="Get Vessel Item List as Array",
     *     operationId="index",
     *     @OA\Parameter(name="intVesselId", description="intVesselId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="Get Vessel Item List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        try {
            $data = $this->vesselItemRepository->getAll();
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Item List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/vesselItem",
     *     tags={"ASLLHR"},
     *     summary="Create New Vessel Item",
     *     description="Create New Vessel Item",
     *     operationId="store",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intVesselId", type="integer", example=1),
     *              @OA\Property(property="strVesselItemName", type="string", example="Chocolate"),
     *              @OA\Property(property="strVesselName", type="string", example="Akij Noor"),
     *              @OA\Property(property="decQtyAvailable", type="integer", example=20),
     *              @OA\Property(property="decDefaultPurchasePrice", type="integer", example=25),
     *              @OA\Property(property="decDefaultSalePrice", type="integer", example=30),
     *              @OA\Property(property="intItemTypeId", type="integer", example=1),
     *              @OA\Property(property="strItemTypeName", type="string", example="General"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1272),
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Create New Vessel Item" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(VesselItemRequest $request)
    {
        try {
            $data = $request->all();
            $unit = $this->vesselItemRepository->create($data);
            return $this->responseRepository->ResponseSuccess($unit, 'New Vessel Item Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseRepository->ResponseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/vesselItem/{intID}",
     *     tags={"ASLLHR"},
     *     summary="Show Vessel Item Details",
     *     description="Show Vessel Item Details",
     *     operationId="show",
     *     @OA\Parameter(name="intID", description="intID, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Show Vessel Item Details" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($intID)
    {
        try {
            $data = $this->vesselItemRepository->getByID($intID);
            if(is_null($data))
                return $this->responseRepository->ResponseError(null, 'Vessel Item Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseRepository->ResponseSuccess($data, 'Vessel Item Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/vesselItem/{intID}",
     *     tags={"ASLLHR"},
     *     summary="Update Vessel Item",
     *     description="Update Vessel Item",
     *     @OA\Parameter(name="intID", description="intID, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intVesselId", type="integer", example=1),
     *              @OA\Property(property="strVesselName", type="string", example="Akij Noor"),
     *              @OA\Property(property="decQtyAvailable", type="integer", example=20),
     *              @OA\Property(property="decDefaultPurchasePrice", type="integer", example=25),
     *              @OA\Property(property="decDefaultSalePrice", type="integer", example=30),
     *              @OA\Property(property="intItemTypeId", type="integer", example=1),
     *              @OA\Property(property="strItemTypeName", type="string", example="General"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1272),
     *          ),
     *      ),
     *     operationId="update",
     *     @OA\Response( response=200, description="Update Vessel Item" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(VesselItemRequest $request, $intID)
    {
        try {
            $data = $this->vesselItemRepository->update($intID, $request->all());
            if(is_null($data))
                return $this->responseRepository->ResponseError(null, 'Vessel Item Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseRepository->ResponseSuccess($data, 'Vessel Item Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/asllhr/vesselItem/{intID}",
     *     tags={"ASLLHR"},
     *     summary="Delete Vessel Item",
     *     description="Delete Vessel Item",
     *     operationId="destroy",
     *     @OA\Parameter(name="intID", description="intID, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response( response=200, description="Delete Vessel Item" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($intID)
    {
        try {
            $data =  $this->vesselItemRepository->getByID($intID);
            $deleted = $this->vesselItemRepository->delete($intID);
            if(!$deleted)
                return $this->responseRepository->ResponseError(null, 'Vessel Item Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseRepository->ResponseSuccess($data, 'Vessel Item Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
