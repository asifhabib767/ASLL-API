<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeCertificateRepository;

class ASLLHREmployeeCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('asllhr::index');
    }

    public $asllhrEmployeeCertificateRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeCertificateRepository $asllhrEmployeeCertificateRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeCertificateRepository = $asllhrEmployeeCertificateRepository;
        $this->responseRepository = $rp;
    }


        /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getEmployeeCertificateList",
     *     tags={"ASLLHR"},
     *     summary="Get Employee Certificate List",
     *     description="Get Employee Certificate List",
     *      operationId="getEmployeeCertificateList",
     *      @OA\Response(response=200,description="Get Employee Certificate List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeCertificateList()
    {
        try {
            $data = $this->asllhrEmployeeCertificateRepository->getEmployeeCertificateList();
            return $data;
            return $this->responseRepository->ResponseSuccess($data, 'Employee List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createEmployeeCertificate",
     *     tags={"ASLLHR"},
     *     summary="Create Employee Certificate",
     *     description="Create Employee Certificate",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="certificates",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="strCourseName", type="string", example="Somthing"),
     *                              @OA\Property(property="strIssueBy", type="string", example="Abir Ahmad"),
     *                              @OA\Property(property="strNumber", type="string", example="12345678"),
     *                              @OA\Property(property="strIssueDate", type="string", example="2020-09-09"),
     *                              @OA\Property(property="strExpiryDate", type="string", example="2020-10-10"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=6),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *                              @OA\Property(property="imageFile", type="string", example="/images"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="createEmployeeCertificate",
     *      @OA\Response(response=200,description="Create Employee Certificate"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createEmployeeCertificate(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeCertificateRepository->createEmployeeCertificate($request->all());

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Certificate Created');
            } else {
                return $this->responseRepository->ResponseError(null, 'Employee Certificate Create Not Successfull');
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateEmployeeCertificate",
     *     tags={"ASLLHR"},
     *     summary="Update Employee Document",
     *     description="Update Employee Document",
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
     *      operationId="updateEmployeeCertificate",
     *      @OA\Response(response=200,description="Update Employee Document"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateEmployeeCertificate(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeCertificateRepository->updateEmployeeCertificate($request);

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Certificate Updated');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Certificate Update Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
