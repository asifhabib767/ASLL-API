<?php

namespace Modules\PurchaseRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PurchaseRequisition\Repositories\ItemTypeRepository;

class ItemTypesController extends Controller
{
    public $itemTypeRepository;
    public $responseRepository;

    public function __construct(ItemTypeRepository $itemTypeRepository, ResponseRepository $rp)
    {
        $this->itemTypeRepository = $itemTypeRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getItemTypeListAll",
     *     tags={"Items"},
     *     summary="getItemTypeListAll",
     *     description="Item Types List",
     *     operationId="getItemTypeListAll",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getItemTypeListAll"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItemTypeListAll(Request $request)
    {
        try {
            $data = $this->itemTypeRepository->getItemTypesAll();
            return $this->responseRepository->ResponseSuccess($data, 'Item Types List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
