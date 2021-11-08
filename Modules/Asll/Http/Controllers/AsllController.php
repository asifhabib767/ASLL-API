<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Repositories\CountryRepository;
use Modules\Asll\Repositories\MasterRepository;

class AsllController extends Controller
{
    public $masterRepository;
    public $countryRepository;
    public $responseRepository;


    public function __construct(CountryRepository $countryRepository, MasterRepository $masterRepository, ResponseRepository $rp)
    {
        $this->countryRepository = $countryRepository;
        $this->masterRepository = $masterRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/getCountries",
     *     tags={"Master Data"},
     *     summary="Get Country List",
     *     description="Get Country List",
     *      operationId="getCountries",
     *      @OA\Response(response=200,description="Get Country List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCountries()
    {
        try {
            $data = $this->countryRepository->getCountries();
            return $this->responseRepository->ResponseSuccess($data, 'Country List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/getShipConditionType",
     *     tags={"Master Data"},
     *     summary="Get Ship Condition Type List",
     *     description="Get Ship Condition Type List",
     *      operationId="getShipConditionType",
     *      @OA\Response(response=200,description="Get Ship Condition Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShipConditionType()
    {
        try {
            $data = $this->masterRepository->getShipConditionType();
            return $this->responseRepository->ResponseSuccess($data, 'Ship Condition Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/getShipEngine",
     *     tags={"Master Data"},
     *     summary="Get Ship Engine List",
     *     description="Get Ship Engine List",
     *      operationId="getShipEngine",
     *      @OA\Response(response=200,description="Get Ship Engine List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShipEngine()
    {
        try {
            $data = $this->masterRepository->getShipEngine();
            return $this->responseRepository->ResponseSuccess($data, 'Ship Engine List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/getShipPosition",
     *     tags={"Master Data"},
     *     summary="Get Ship Position List",
     *     description="Get Ship Position List",
     *      operationId="getShipPosition",
     *      @OA\Response(response=200,description="Get Ship Position List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getShipPosition()
    {
        try {
            $data = $this->masterRepository->getShipPosition();
            return $this->responseRepository->ResponseSuccess($data, 'Ship Position List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
