<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeRecordRepository;

class ASLLHREmployeeRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('asllhr::index');
    }



    public $asllhrEmployeeRecordRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeRecordRepository $asllhrEmployeeRecordRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeRecordRepository = $asllhrEmployeeRecordRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createEmployeeRecord",
     *     tags={"ASLLHR"},
     *     summary="Create Employee Record",
     *     description="Create Employee Record",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="records",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="strRank", type="string", example="3/E"),
     *                              @OA\Property(property="strShipManager", type="string", example="BRSML"),
     *                              @OA\Property(property="strVesselName", type="string", example="MAA SALEHA BEGUM"),
     *                              @OA\Property(property="strFlag", type="string", example="BD"),
     *                              @OA\Property(property="strVesselType", type="string", example="Bulk"),
     *                              @OA\Property(property="strDWT", type="string", example="52084"),
     *                              @OA\Property(property="strEngineName", type="string", example="11880"),
     *                              @OA\Property(property="strFromDate", type="string", example="2020-05-27"),
     *                              @OA\Property(property="strToDate", type="string", example="2020-06-27"),
     *                              @OA\Property(property="strDuration", type="string", example="ly"),
     *                              @OA\Property(property="strReason", type="string", example="sick"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=6),
     *                              @OA\Property(property="intUnitId", type="integer", example=2),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="createEmployeeRecord",
     *      @OA\Response(response=200,description="Create Employee Record"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createEmployeeRecord(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeRecordRepository->createEmployeeRecord($request->all());

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Record Created');
            } else {
                return $this->responseRepository->ResponseError(null, 'Employee Record Create Not Successfull');
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateEmployeeRecord",
     *     tags={"ASLLHR"},
     *     summary="Update Employee Record",
     *     description="Update Employee Record",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *                              @OA\Property(property="intID", type="integer", example=3),
     *                              @OA\Property(property="strCertification", type="string", example="SSC"),
     *                              @OA\Property(property="strInstitution", type="string", example="MCC"),
     *                              @OA\Property(property="strYear", type="string", example="2016"),
     *                              @OA\Property(property="strResult", type="string", example="4.66"),
     *                              @OA\Property(property="image", type="string", example=null),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=2),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *           )
     *      ),
     *      operationId="updateEmployeeRecord",
     *      @OA\Response(response=200,description="Update Employee Education"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateEmployeeRecord(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeRecordRepository->updateEmployeeRecord($request);

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Record Updated');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Record Update Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
