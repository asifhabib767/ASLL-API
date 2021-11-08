<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Repositories\VesselTypeRepository;

class VesselTypesController extends Controller
{
    public $vesselTypeRepository;
    public $responseRepository;


    public function __construct(VesselTypeRepository $vesselTypeRepository, ResponseRepository $rp)
    {
        $this->vesselTypeRepository = $vesselTypeRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/vessel/types",
     *     tags={"Vessel"},
     *     summary="Get Vessel Type List",
     *     description="Get Vessel Type List",
     *      operationId="getVesselTypes",
     *      @OA\Response(response=200,description="Get Vessel Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVesselTypes()
    {
        try {
            $data = $this->vesselTypeRepository->getVesselTypes();
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
