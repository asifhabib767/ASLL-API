<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{

    public $currencyRepository;
    public $responseRepository;


    public function __construct(CurrencyRepository $currencyRepository, ResponseRepository $rp)
    {
        $this->currencyRepository = $currencyRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getCurrency",
     *     tags={"ASLLHR"},
     *     summary="Get Currency List",
     *     description="Get Currency List",
     *      operationId="index",
     *      @OA\Response(response=200,description="Get Currency List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCurrency()
    {
        try {
            $data = $this->currencyRepository->getCurrency();
            return $this->responseRepository->ResponseSuccess($data, 'Currency List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/currency/create",
     *     tags={"ASLLHR"},
     *     summary="Post Currency",
     *     description="Post Currency",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intEmployeeId", type="integer", example=7),
     *              @OA\Property(property="intVesselId", type="integer", example=2),
     *              @OA\Property(property="dteActionDate", type="string", example="2020-10-21"),
     *              @OA\Property(property="ysnSignIn", type="boolean", example="true"),
     *              @OA\Property(property="strRemarks", type="string", example="Hello"),
     *              @OA\Property(property="intLastVesselId", type="integer", example="1"),
     *          )
     *      ),
     *      operationId="create",
     *      @OA\Response(response=200,description="Post Currency"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function create(Request $request)
    {
        try {
            $data = $this->currencyRepository->createCurrency($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Signed in');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

      /**
     * @OA\POST(
     *     path="/api/v1/asllhr/currencyConversionPost",
     *     tags={"ASLLHR"},
     *     summary="Post Currency Conversion",
     *     description="Post Currency Conversion",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intConvertedFromId", type="integer", example=1),
     *              @OA\Property(property="intConvertedToId", type="integer", example=2),
     *              @OA\Property(property="decUSDAmount", type="string", example="1"),
     *              @OA\Property(property="decBDTAmount", type="string", example="84"),
     *          )
     *      ),
     *      operationId="currencyConversionPost",
     *      @OA\Response(response=200,description="Post Currency Conversion"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function currencyConversionPost(Request $request)
    {
        try {
            $data = $this->currencyRepository->currencyConversionPost($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Currency SuccessFully Converted');
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
        return view('asllhr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('asllhr::edit');
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
