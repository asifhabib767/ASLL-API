<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeEducationRepository;

class ASLLHREmployeeEducationController extends Controller
{


    public $asllhrEmployeeEducationRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeEducationRepository $asllhrEmployeeEducationRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeEducationRepository = $asllhrEmployeeEducationRepository;
        $this->responseRepository = $rp;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('asllhr::index');
    }
    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createEmployeeEducation",
     *     tags={"ASLLHR"},
     *     summary="Create Employee Education",
     *     description="Create Employee Education",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="educations",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="strCertification", type="string", example="SSC"),
     *                              @OA\Property(property="strInstitution", type="string", example="AIUB"),
     *                              @OA\Property(property="strYear", type="string", example="2016"),
     *                              @OA\Property(property="strResult", type="string", example="4.66"),
     *                              @OA\Property(property="image", type="string", example="/images"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=2),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="createEmployeeEducation",
     *      @OA\Response(response=200,description="Create Employee Education"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createEmployeeEducation(Request $request)
    {
        // try {
            $data = $this->asllhrEmployeeEducationRepository->createEmployeeEducation($request->all());

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Education Created');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Education Create Not Successfull');
        // } catch (\Exception $e) {
        //     return $this->responseRepository->ResponseError(null, $e->getMessage());
        // }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateEmployeeEducation",
     *     tags={"ASLLHR"},
     *     summary="Update Employee Education",
     *     description="Update Employee Education",
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
     *      operationId="updateEmployeeEducation",
     *      @OA\Response(response=200,description="Update Employee Education"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateEmployeeEducation(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeEducationRepository->updateEmployeeEducation($request);

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Education Updated');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Education Update Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
