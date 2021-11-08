<?php

namespace Modules\PurchaseRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PurchaseRequisition\Repositories\UnitRepository;

class UnitController extends Controller
{
    public $unitRepository;
    public $responseRepository;

    public function __construct(UnitRepository $unitRepository, ResponseRepository $rp)
    {
        $this->unitRepository = $unitRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getUnitList",
     *     tags={"Unit"},
     *     summary="getUnitList",
     *     description="Wearehouse List By Unit",
     *     operationId="getUnitList",
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getUnitList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getUnitList(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->unitRepository->getUnitList($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Unit List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
