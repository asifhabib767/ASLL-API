<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeReferenceRepository;

class ASLLHREmployeeReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('asllhr::index');
    }



    public $asllhrEmployeeReferenceRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeReferenceRepository $asllhrEmployeeReferenceRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeReferenceRepository = $asllhrEmployeeReferenceRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createEmployeeReference",
     *     tags={"ASLLHR"},
     *     summary="Create Employee Reference",
     *     description="Create Employee Reference",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="references",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="strCompanyName", type="string", example="Akij Shipping"),
     *                              @OA\Property(property="strCountry", type="string", example="Bangladesh"),
     *                              @OA\Property(property="strEmail", type="string", example="abir.ahmad@gmail.com"),
     *                              @OA\Property(property="strPersonName", type="string", example="Abir Ahmad"),
     *                              @OA\Property(property="strTelephone", type="string", example="0183934784"),
     *                              @OA\Property(property="strDWT", type="string", example="52084"),
     *                              @OA\Property(property="strAddress", type="string", example="dhaka"),
     *                              @OA\Property(property="isVisa", type="string", example="yes"),
     *                              @OA\Property(property="maritimeAccident", type="string", example="no"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=6),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="createEmployeeReference",
     *      @OA\Response(response=200,description="Create Employee Reference"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createEmployeeReference(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeReferenceRepository->createEmployeeReference($request->all());

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Reference Created');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Reference Create Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateEmployeeReference",
     *     tags={"ASLLHR"},
     *     summary="Update Employee Reference",
     *     description="Update Employee Reference",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *                              @OA\Property(property="intID", type="integer", example=3),
     *                              @OA\Property(property="image", type="string", example=null),
     *                              @OA\Property(property="strCompanyName", type="string", example="CompanyName"),
     *                              @OA\Property(property="strCountry", type="string", example="Country"),
     *                              @OA\Property(property="strEmail", type="string", example="Email"),
     *                              @OA\Property(property="strPersonName", type="string", example="PersonName"),
     *                              @OA\Property(property="strTelephone", type="string", example="Telephone"),
     *                              @OA\Property(property="strAddress", type="string", example="Address"),
     *                              @OA\Property(property="isVisa", type="string", example="Visa"),
     *                              @OA\Property(property="maritimeAccident", type="string", example="maritimeAccident"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=2),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *           )
     *      ),
     *      operationId="updateEmployeeReference",
     *      @OA\Response(response=200,description="Update Employee Reference"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateEmployeeReference(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeReferenceRepository->updateEmployeeReference($request);

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Reference Updated');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Reference Update Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
