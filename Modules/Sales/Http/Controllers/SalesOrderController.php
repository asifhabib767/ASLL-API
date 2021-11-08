<?php

namespace Modules\Sales\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Sales\Repositories\SalesOrderRepository;

class SalesOrderController extends Controller
{

    public $salesOrderRepository;
    public $responseRepository;

    public function __construct(SalesOrderRepository $salesOrderRepository, ResponseRepository $rp)
    {
        $this->salesOrderRepository = $salesOrderRepository;
        $this->responseRepository = $rp;
    }
    /**
     * @OA\GET(
     *     path="/api/v1/sales/getSalesOrderListByTerritory",
     *     tags={"SalesOrder"},
     *     summary="Get Sales Order List By Territory",
     *     description="Get Sales Order List By Territory",
     *     operationId="getSalesOrderListByTerritory",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="dteStartDate", description="dteStartDate, eg; 2020-11-01", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Parameter( name="dteEndDate", description="dteEndDate, eg; 2020-12-23", required=false, in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200,description="Get Sales Order List By Territory"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getSalesOrderListByTerritory(Request $request)
    {
        $intUnitId = $request->intUnitId;
        // $intPriceVarId = $request->intPriceVarId;
        $dteStartDate = $request->dteStartDate;
        $dteEndDate = $request->dteEndDate;
        try {
            $data = $this->salesOrderRepository->getSalesOrderListByTerritory($intUnitId, $dteStartDate, $dteEndDate);
            return $this->responseRepository->ResponseSuccess($data, 'Sales Order List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
