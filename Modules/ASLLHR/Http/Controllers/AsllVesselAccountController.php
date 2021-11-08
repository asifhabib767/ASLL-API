<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\AsllVesselAccountRepository;

class AsllVesselAccountController extends Controller
{
    public $asllVesselAccountRepository;
    public $responseRepository;


    public function __construct(AsllVesselAccountRepository $asllVesselAccountRepository, ResponseRepository $rp)
    {
        $this->asllVesselAccountRepository = $asllVesselAccountRepository;
        $this->responseRepository = $rp;
    }
    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getVesselAccountInfo/{intVesselId}",
     *     tags={"ASLLHR"},
     *     summary="Get Vessel Account",
     *     description="Get Vessel Account",
     *      @OA\Parameter( name="intVesselId", description="intVesselId, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      operationId="getVesselAccountInfo",
     *      @OA\Response(response=200,description="Get Vessel Account"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVesselAccountInfo($intVesselId)
    {
        try {
            $data = $this->asllVesselAccountRepository->getVesselAccountInfo($intVesselId);
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Account info By Vessel Id');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getVesselAccountTransaction",
     *     tags={"ASLLHR"},
     *     summary="Get Vessel Account Tranasction",
     *     description="Get Vessel Account Tranasction",
     *      @OA\Parameter( name="intVesselId", description="intVesselId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      operationId="getVesselAccountTransaction",
     *      @OA\Response(response=200,description="Get Vessel Account Tranasction"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVesselAccountTransaction()
    {
        $intVesselId = request()->intVesselId;
        try {
            $data = $this->asllVesselAccountRepository->getVesselAccountTransaction($intVesselId);
            return $this->responseRepository->ResponseSuccess($data, 'Vessel Account Transaction History');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('asllhr::create');
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
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateVesselAccountInfo",
     *     tags={"ASLLHR"},
     *     summary="Update Vassel Account Information",
     *     description="Update Vassel Account Information",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *                              @OA\Property(property="intID", type="integer", example=1),
     *                              @OA\Property(property="intVesselId", type="integer", example=1),
     *                              @OA\Property(property="strVesselName", type="string", example="VesselName"),
     *                              @OA\Property(property="decBondAccountBalance", type="float", example=123),
     *                              @OA\Property(property="decCashAccountBalance", type="float", example=123),
     *                              @OA\Property(property="intCreatedBy", type="string", example="CreatedBy"),
     *           )
     *      ),
     *      operationId="updateVesselAccountInfo",
     *      @OA\Response(response=200,description="Update Vassel Account Information"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateVesselAccountInfo(Request $request)
    {
        $updatedData = $this->asllVesselAccountRepository->updateVesselAccountInfo($request, $request->intVesselId);
        try {
            return $this->responseRepository->ResponseSuccess($updatedData, 'Data Updated Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
