<?php

namespace Modules\Logistic\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Logistic\Repositories\VehicleRepository;

class VehicleController extends Controller
{

    public $vehicleRepository;
    public $responseRepository;


    public function __construct(VehicleRepository $vehicleRepository, ResponseRepository $rp)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->responseRepository = $rp;
    }
    /**
     * @OA\GET(
     *     path="/api/v1/logistic/vehicle",
     *     tags={"Logistic"},
     *     summary="Get Vehicle List",
     *     description="Get Vehicle List",
     *      operationId="getVehicleList",
     *      @OA\Response(response=200,description="Get Vehicle List"),
     *      @OA\Parameter( name="intSupplierID", description="intSupplierID, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVehicleList(Request $request)
    {
        try {
            $data = $this->vehicleRepository->getVehicleList($request->intSupplierID);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle List');
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
        return view('logistic::create');
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
        return view('logistic::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('logistic::edit');
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/logistic/vehicle/update",
     *     tags={"Logistic"},
     *     summary="Vehicle Update",
     *     description="Vehicle Update",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intVehicleId", type="string", example="20505"),
     *              @OA\Property(property="strFullRegistrationNo", type="string", example="Dhaka Metro TA 20-4847"),
     *              @OA\Property(property="intVehicleClassId", type="string", example="1"),
     *              @OA\Property(property="strMetroCity", type="string", example="12"),
     *              @OA\Property(property="strIdentifier", type="string", example="59"),
     *              @OA\Property(property="strSerialNo", type="string", example="16"),
     *              @OA\Property(property="strRegistrationNo", type="string", example="Dhaka Metro TA 16-3421"),
     *              @OA\Property(property="strOwnerName", type="string", example="Mukter"),
     *              @OA\Property(property="strOwnerContact", type="string", example="01714977695"),
     *              @OA\Property(property="intCapacityCFT", type="string", example="7"),
     *              @OA\Property(property="intFuelUsedType", type="string", example="1"),
     *              @OA\Property(property="intUnladenWeightKg", type="string", example="1"),
     *              @OA\Property(property="intMaxLadenWeightKg", type="string", example="6"),
     *              @OA\Property(property="strCapacity", type="string", example="10"),
     *              @OA\Property(property="ysnEnable", type="string", example="1"),
     *              @OA\Property(property="intSupplierCOAID", type="string", example=null),
     *              @OA\Property(property="intDriverID", type="string", example=null),
     *              @OA\Property(property="intSupplierID", type="string", example=1215),
     *              @OA\Property(property="dteInsertDate", type="string", example="2020-09-18 11:44:39.433"),
     *              @OA\Property(property="intUpdateBy", type="string", example=null),
     *              @OA\Property(property="dteUpdateDate", type="string", example=null),
     *          )
     *      ),
     *      operationId="vehicleUpdate",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Vehicle Update"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function vehicleUpdate(Request $request)
    {
        try {
            $data = $this->vehicleRepository->update($request);
            return $this->responseRepository->ResponseSuccess($data, 'Vehicle Updated');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
    }


    /**
     * @OA\GET(
     *     path="/api/v1/logistic/vehicle/getuservehicel",
     *     tags={"Logistic"},
     *     summary="Get user vs Vehicle info",
     *     description="Get Vehicle List",
     *      operationId="getUservsVehicleInfo",
     *      @OA\Response(response=200,description="Get user vs Vehicle info"),
     *      @OA\Parameter( name="intResponsibleEnroll", description="intResponsibleEnroll, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getUservsVehicleInfo(Request $request)
    {

        // return 1;

        try {
            $data = $this->vehicleRepository->getUservsVehicleInfo($request->intResponsibleEnroll);
            return $this->responseRepository->ResponseSuccess($data, 'User vs Vehicle Info');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

 /**
     * @OA\GET(
     *     path="/api/v1/logistic/vehicle/getVehicleCapacity",
     *     tags={"Logistic"},
     *     summary="Get user vs Vehicle info",
     *     description="Get Vehicle List",
     *      operationId="getVehicleCapacity",
     *      @OA\Response(response=200,description="Get user vs Vehicle info"),
     *      @OA\Parameter( name="intUnitId", description="intUnitId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getVehicleCapacity(Request $request)
    {

        // return $request->intUnitId;

        try {
            $data = $this->vehicleRepository->getVehicleCapacity($request->intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'get Vehicle Capacity');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
