<?php

namespace Modules\Item\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Item\Repositories\ProductPriceRepository;

class ProductPriceController extends Controller
{

    public $vesselRepository;
    public $responseRepository;


    public function __construct(ProductPriceRepository $vesselRepository, ResponseRepository $rp)
    {
        $this->vesselRepository = $vesselRepository;
        $this->responseRepository = $rp;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('item::index');
    }

    /**
     * @OA\POST(
     *     path="/api/v1/item/productPriceInsert",
     *     tags={"Product"},
     *     summary="Set Product Price",
     *     description="Set Product Price",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intProductId", type="integer", example=1),
     *              @OA\Property(property="intThanaID", type="integer", example=1),
     *              @OA\Property(property="monPrice", type="string", example="415"),
     *              @OA\Property(property="decMinQnt", type="integer", example=50),
     *           )
     *      ),
     *      operationId="productPriceInsert",
     *      @OA\Response(response=200,description="Set Product Price"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */


    public function productPriceInsert(Request $request)
    {
        try {
            $data = $this->vesselRepository->productPriceInsert($request);
            return $this->responseRepository->ResponseSuccess($data, 'Product Price Inserted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('item::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('item::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
