<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\VesselCreateRequest;
use Modules\Asll\Http\Requests\VesselUpdateRequest;
use Modules\Asll\Repositories\VesselRepository;
use Anchu\Ftp\FtpServiceProvider;

class VesselsController extends Controller
{
    public $vesselRepository;
    public $responseRepository;


    public function __construct(VesselRepository $vesselRepository, ResponseRepository $rp)
    {
        $this->vesselRepository = $vesselRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/vessel",
     *     tags={"Vessel"},
     *     summary="Get Vessel List",
     *     description="Get Vessel List",
     *      @OA\Parameter( name="intVesselId", description="intVesselId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      operationId="index",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Vessel List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        try {
            $data = $this->vesselRepository->getVessels();
            return $this->responseRepository->ResponseSuccess($data, 'Vessel List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/vessel/show/{id}",
     *     tags={"Vessel"},
     *     summary="Details Vessel",
     *     description="Details Vessel",
     *      operationId="destroy",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Details Vessel"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id)
    {
        try {
            $data = $this->vesselRepository->show($id);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Details !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/vessel/getFtpImage",
     *     tags={"Vessel"},
     *     summary="Details Vessel",
     *     description="Details Vessel",
     *      operationId="getFtpImage",
     *      @OA\Response(response=200,description="Details Vessel"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getFtpImage()
    {
        // try {
        // $listing = FTP::connection()->getDirListing();
        $status = $listing = FTP::connection()->getDirListing('APPSDocuments');
        return $status;
        // } catch (\Exception $e) {
        //     return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }



    /**
     * @OA\POST(
     *     path="/api/v1/asll/vessel/store",
     *     tags={"Vessel"},
     *     summary="Create Vessel",
     *     description="Create Vessel",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strVesselName", type="string", example="Vessel Name"),
     *              @OA\Property(property="intVesselTypeID", type="integer", example=1),
     *              @OA\Property(property="strVesselTypeName", type="string", example="Cargo"),
     *              @OA\Property(property="intYardCountryId", type="integer", example=1),
     *              @OA\Property(property="strYardCountryName", type="string", example="Bangladesh"),
     *              @OA\Property(property="strVesselFlag", type="string", example="Flag"),
     *              @OA\Property(property="numDeadWeight", type="integer", example=10),
     *              @OA\Property(property="strBuildYear", type="string", example="2020"),
     *              @OA\Property(property="strEngineName", type="string", example="Engine K/W"),
     *              @OA\Property(property="intTotalCrew", type="integer", example=100)
     *           )
     *      ),
     *      operationId="store",
     *      @OA\Response(response=200,description="Create Vessel"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */


    public function store(VesselCreateRequest $request)
    {
        try {
            $data = $this->vesselRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asll/vessel/update",
     *     tags={"Vessel"},
     *     summary="Update Vessel",
     *     description="Update Vessel",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=1),
     *              @OA\Property(property="strVesselName", type="string", example="Vessel Name"),
     *              @OA\Property(property="strIMONumber", type="string", example="534534"),
     *              @OA\Property(property="intVesselTypeID", type="integer", example=1),
     *              @OA\Property(property="strVesselTypeName", type="string", example="Cargo"),
     *              @OA\Property(property="intYardCountryId", type="integer", example=18),
     *              @OA\Property(property="strYardCountryName", type="string", example="Bangladesh"),
     *              @OA\Property(property="strVesselFlag", type="string", example="Flag"),
     *              @OA\Property(property="numDeadWeight", type="float", example=10),
     *              @OA\Property(property="numGrossWeight", type="float", example=10),
     *              @OA\Property(property="numNetWeight", type="float", example=10),
     *              @OA\Property(property="strBuildYear", type="string", example="2020"),
     *              @OA\Property(property="strEngineName", type="string", example="Engine K/W"),
     *              @OA\Property(property="intTotalCrew", type="integer", example=100)
     *           )
     *      ),
     *      operationId="update",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Update Vessel"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(VesselUpdateRequest $request)
    {
        try {
            $data = $this->vesselRepository->update($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/asll/vessel/delete/{id}",
     *     tags={"Vessel"},
     *     summary="Delete Vessel",
     *     description="Delete Vessel",
     *      operationId="destroy",
     *      security={{"bearer": {}}},
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Delete Vessel"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($id)
    {
        // try {
        $data = $this->vesselRepository->delete($id);
        //     return $this->responseRepository->ResponseSuccess($data, 'Vessel Deleted Successfully !');
        // } catch (\Exception $e) {
        //     return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
        return $data;
    }
}
