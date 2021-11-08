<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Repositories\VoyagePortRepository;

class VoyagePortsController extends Controller
{
    public $voyagePortRepository;
    public $responseRepository;


    public function __construct(VoyagePortRepository $voyagePortRepository, ResponseRepository $rp)
    {
        $this->voyagePortRepository = $voyagePortRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyage/ports",
     *     tags={"Voyage Ports"},
     *     summary="Get Voyage Port List",
     *     description="Get Voyage Port List",
     *      operationId="getVoyagePortList",
     *      @OA\Response(response=200,description="Get Voyage Port List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVoyagePortList()
    {
        try {
            $data = $this->voyagePortRepository->getVoyagePorts();
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Port List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyage/ports-search",
     *     tags={"Voyage Ports"},
     *     summary="Get Voyage Port List By Search",
     *     description="Get Voyage Port List By Search",
     *      operationId="getVoyagePortListBySearch",
     *      @OA\Parameter( name="search", description="search, eg; 1", required=true, in="query", @OA\Schema(type="string"), example="ban"),
     *      @OA\Response(response=200,description="Get Voyage Port List By Search"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVoyagePortListBySearch(Request $request)
    {
        $searchQuery = $request->search;
        try {
            $data = $this->voyagePortRepository->getVoyagePortsBySearch($searchQuery);
            return $this->responseRepository->ResponseSuccess($data, 'Voyage Port List By Search');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asll/voyage/ports/store",
     *     tags={"Voyage Ports"},
     *     summary="Create Port",
     *     description="Create Port",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strPortCode", type="string", example="Port12"),
     *              @OA\Property(property="strPortName", type="string", example="Test Port"),
     *              @OA\Property(property="strCountryName", type="string", example="Bangladesh"),
     *              @OA\Property(property="strCountryCode", type="string", example="BD"),
     *              @OA\Property(property="strLOCODE", type="string", example="BD12345"),
     *          )
     *      ),
     *      operationId="store",
     *      @OA\Response(response=200,description="Create New Port"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $this->voyagePortRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Port Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
