<?php

namespace Modules\Item\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Item\Repositories\ItemRepository;

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
     *     path="/api/v1/item/items",
     *     tags={"Product"},
     *     summary="Get Products",
     *     description="Get Products",
     *     operationId="getItems",
     *      @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", example=4, required=true, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="intCategoryId", description="intCategoryId, eg; 4", example=15, required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="search", description="search, eg; Octen", example="Octen", required=false, in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="Get Products"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getItems(Request $request)
    {
        try {
            $data = $this->itemRepository->getFuelItems($request->intUnitId, $request->intCategoryId, $request->search);
            return $this->responseRepository->ResponseSuccess($data, 'Item List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
