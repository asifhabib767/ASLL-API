<?php

namespace Modules\PurchaseRequisition\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PurchaseRequisition\Repositories\ItemRepository;

class ItemsController extends Controller
{
    public $itemRepository;
    public $responseRepository;

    public function __construct(ItemRepository $itemRepository, ResponseRepository $rp)
    {
        $this->itemRepository = $itemRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getItemListAll",
     *     tags={"Items"},
     *     summary="getItemListAll",
     *     description="Item Types List",
     *     operationId="getItemListAll",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getItemListAll"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItemListAll(Request $request)
    {
        try {
            $data = $this->itemRepository->getItemAll();
            return $this->responseRepository->ResponseSuccess($data, 'Item List All');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/purchaseRequisition/getItemListByUnit",
     *     tags={"Items"},
     *     summary="getItemListByUnit",
     *     description="Item Types List",
     *     operationId="getItemListByUnit",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getItemListByUnit"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItemListByUnit(Request $request)
    {
        $intUnitId = $request->intUnitId;
        try {
            $data = $this->itemRepository->getItemsByItemByUnitId($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Item List By Unit ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
