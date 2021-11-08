<?php

namespace Modules\Asll\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Asll\Http\Requests\Cargo\CargoCreateRequest;
use Modules\Asll\Http\Requests\Cargo\CargoUpdateRequest;
use Modules\Asll\Repositories\CargoRepository;

class CargoController extends Controller
{
    public $cargoRepository;
    public $responseRepository;


    public function __construct(CargoRepository $cargoRepository, ResponseRepository $rp)
    {
        $this->cargoRepository = $cargoRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asll/voyage/cargo",
     *     tags={"Cargo"},
     *     summary="Get Cargo List",
     *     description="Get Cargo List",
     *      operationId="index",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Cargo List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        try {
            $data = $this->cargoRepository->getCargo();
            return $this->responseRepository->ResponseSuccess($data, 'Cargo List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
