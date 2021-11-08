<?php

namespace Modules\Logistic\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Logistic\Repositories\DriverRepository;

class DriverController extends Controller
{
    public $driverRepository;
    public $responseRepository;


    public function __construct(DriverRepository $driverRepository, ResponseRepository $rp)
    {
        $this->driverRepository = $driverRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/logistic/driver",
     *     tags={"Logistic"},
     *     summary="Get Driver List",
     *     description="Get Driver List",
     *      operationId="index",
     *      @OA\Response(response=200,description="Get Driver List"),
     *      @OA\Parameter( name="intSupplierID", description="intSupplierID, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $data = $this->driverRepository->getDriverList($request->intSupplierID);
            return $this->responseRepository->ResponseSuccess($data, 'Driver List');
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
     * @OA\GET(
     *     path="/api/v1/logistic/driver/show/{intDriverId}",
     *     tags={"Logistic"},
     *     summary="Details Driver",
     *     description="Details Driver",
     *      operationId="destroy",
     *      @OA\Parameter( name="intDriverId", description="intDriverId, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Details Driver"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($intDriverId)
    {
        try {
            $data = $this->driverRepository->show($intDriverId);
            return $this->responseRepository->ResponseSuccess($data, 'Driver Details !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
     *     path="/api/v1/logistic/driver/update",
     *     tags={"Logistic"},
     *     summary="Driver Update",
     *     description="Driver Update",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intDriverId", type="integer", example=1),
     *              @OA\Property(property="strPhoneNo", type="string", example="01983847"),
     *              @OA\Property(property="strDriverName", type="string", example="Rahat"),
     *              @OA\Property(property="strDrivingLicence", type="string", example="12"),
     *              @OA\Property(property="strLicenceImagePath", type="string", example="59"),
     *              @OA\Property(property="ysnAppregistration", type="boolean", example=1),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *              @OA\Property(property="intSupplierID", type="integer", example=1216),
     *          )
     *      ),
     *      operationId="update",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Driver Update"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $data = $this->driverRepository->update($request);
            return $this->responseRepository->ResponseSuccess($data, 'Driver Updated');
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
}
