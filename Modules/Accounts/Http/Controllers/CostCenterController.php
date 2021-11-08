<?php

namespace Modules\Accounts\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounts\Repositories\CostCenterRepository;

class CostCenterController extends Controller
{
    public $costCenterRepository;
    public $responseRepository;

    public function __construct(CostCenterRepository $costCenterRepository, ResponseRepository $rp)
    {
        $this->costCenterRepository = $costCenterRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/accounts/getCostCenterByUnitId",
     *     tags={"Cost Center"},
     *     summary="getCostCenterByUnitId",
     *     description="Item Types List",
     *     operationId="getCostCenterByUnitId",
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getCostCenterByUnitId"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCostCenterByUnitId(Request $request)
    {
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->costCenterRepository->getCostCenterByUnitId($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Cost Center List By Unit ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
