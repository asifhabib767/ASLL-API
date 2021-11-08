<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\Voyage\VoyageCreateRequest;
use Modules\Asll\Http\Requests\Voyage\VoyageUpdateRequest;
use Modules\Asll\Repositories\VoyageRepository;

class VoyagesController extends Controller
{
    public $voyageRepository;
    public $responseRepository;


    public function __construct(VoyageRepository $voyageRepository, ResponseRepository $rp)
    {
        $this->voyageRepository = $voyageRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyage",
     *     tags={"Voyage"},
     *     summary="Get Voyage List",
     *     description="Get Voyage List",
     *      operationId="index",
     *      @OA\Parameter(name="search", description="search, eg; 1", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter(name="cargoType", description="cargoType, eg; 1", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Parameter(name="vessel", description="vessel, eg; 1", required=false, in="query", @OA\Schema(type="string")),
     *      @OA\Response(response=200,description="Get Voyage List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        try {
            $data = $this->voyageRepository->getVoyages();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyage/getVoyageByLastVesselId",
     *     tags={"Voyage"},
     *     summary="Get Voyage List By Last Vessel Id",
     *     description="Get Voyage List By Last Vessel Id",
     *      operationId="getVoyageByLastVesselId",
     *      @OA\Parameter( name="intVesselId", description="intVesselId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Get Voyage List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVoyageByLastVesselId(Request $request)
    {
        try {
            $data = $this->voyageRepository->getVoyageByLastVesselId($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage List By Last Vessel id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyage/show/{id}",
     *     tags={"Voyage"},
     *     summary="Show Voyage",
     *     description="Show Voyage",
     *      operationId="showById",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Show Voyage"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id)
    {
        try {
            $data = $this->voyageRepository->show($id);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Details !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyage/store",
     *     tags={"Voyage"},
     *     summary="Create Voyage",
     *     description="Create Voyage",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strVesselName", type="string", example="Vessel Name"),
     *              @OA\Property(property="intVesselID", type="integer", example=2),
     *              @OA\Property(property="intVoyageNo", type="integer", example=1),
     *              @OA\Property(property="intCargoTypeID", type="integer", example=2),
     *              @OA\Property(property="strCargoTypeName", type="string", example="Container Cargo"),
     *              @OA\Property(property="intCargoQty", type="integer", example=10),
     *              @OA\Property(property="dteVoyageDate", type="string", example="2020-09-19"),
     *              @OA\Property(property="strPlaceOfVoyageCommencement", type="string", example="Commencement"),
     *              @OA\Property(property="decBunkerQty", type="decimal", example=10),
     *              @OA\Property(property="decDistance", type="decimal", example=10.2),
     *              @OA\Property(property="intFromPortID", type="integer", example=1),
     *              @OA\Property(property="strFromPortName", type="string", example="Durres (Durazzo)"),
     *              @OA\Property(property="intToPortID", type="integer", example=3),
     *              @OA\Property(property="strToPortName", type="string", example="Shengjjin"),
     *              @OA\Property(property="intVlsfoRob", type="integer", example=0),
     *              @OA\Property(property="intLsmgRob", type="integer", example=0),
     *              @OA\Property(property="intLubOilRob", type="integer", example=0),
     *              @OA\Property(property="intMeccRob", type="integer", example=0),
     *              @OA\Property(property="intAeccRob", type="integer", example=0),
     *           )
     *      ),
     *      operationId="store",
     *      @OA\Response(response=200,description="Create Voyage"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $this->voyageRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/voyage/update",
     *     tags={"Voyage"},
     *     summary="Update Voyage",
     *     description="Update Voyage",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=1),
     *              @OA\Property(property="strVesselName", type="string", example="Vessel Name"),
     *              @OA\Property(property="intVesselID", type="integer", example=2),
     *              @OA\Property(property="intVoyageNo", type="integer", example=1),
     *              @OA\Property(property="intCargoTypeID", type="integer", example=2),
     *              @OA\Property(property="strCargoTypeName", type="string", example="Container Cargo"),
     *              @OA\Property(property="intCargoQty", type="integer", example=10),
     *              @OA\Property(property="dteVoyageDate", type="string", example="2020-09-19"),
     *              @OA\Property(property="strPlaceOfVoyageCommencement", type="string", example="Commencement"),
     *              @OA\Property(property="decBunkerQty", type="decimal", example=10),
     *              @OA\Property(property="decDistance", type="decimal", example=10.2),
     *              @OA\Property(property="intFromPortID", type="integer", example=1),
     *              @OA\Property(property="strFromPortName", type="string", example="Durres (Durazzo)"),
     *              @OA\Property(property="intToPortID", type="integer", example=3),
     *              @OA\Property(property="strToPortName", type="integer", example=3),
     *              @OA\Property(property="intVlsfoRob", type="integer", example=0),
     *              @OA\Property(property="intLsmgRob", type="integer", example=0),
     *              @OA\Property(property="intLubOilRob", type="integer", example=0),
     *              @OA\Property(property="intMeccRob", type="integer", example=0),
     *              @OA\Property(property="intAeccRob", type="integer", example=0),
     *           )
     *      ),
     *      operationId="update",
     *      @OA\Response(response=200,description="Update Voyage"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $data = $this->voyageRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/asll/voyage/delete/{id}",
     *     tags={"Voyage"},
     *     summary="Delete Voyage",
     *     description="Delete Voyage",
     *      operationId="destroy",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Delete Voyage"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($id)
    {
        try {
            $data = $this->voyageRepository->delete($id);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
