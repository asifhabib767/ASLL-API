<?php

namespace Modules\Customer\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Customer\Repositories\CustomerBalanceRepository;

class CustomerBalanceController extends Controller
{

    public $CustomerBalanceRepository;
    public $responseRepository;

    public function __construct(CustomerBalanceRepository $CustomerBalanceRepository, ResponseRepository $rp)
    {
        $this->CustomerBalanceRepository = $CustomerBalanceRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/customer/getCustomerbalanceInformation",
     *     tags={"Customer"},
     *     summary="getCustomerbalanceInformation",
     *     description="getCustomerbalanceInformation",
     *     operationId="getCustomerbalanceInformation",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intCustomerId", description="intCustomerId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getCustomerbalanceInformation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCustomerbalanceInformation(Request $request)
    {
        $intUnitId = $request->intUnitId;
        $intCustomerId = $request->intCustomerId;

        // return  $intCustomerId;
        try {
            $data = $this->CustomerBalanceRepository->getCustomerBalanceInformation($intUnitId, $intCustomerId);
            return $this->responseRepository->ResponseSuccess($data, 'Customer Balance');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
