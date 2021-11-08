<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeDocumentRepository;

class ASLLHREmployeeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('asllhr::index');
    }


    public $asllhrEmployeeDocumentRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeDocumentRepository $asllhrEmployeeDocumentRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeDocumentRepository = $asllhrEmployeeDocumentRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createEmployeeDocument",
     *     tags={"ASLLHR"},
     *     summary="Create Employee Document",
     *     description="Create Employee Document",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                      property="documents",
     *                      type="array",
     *                      @OA\Items(
     *                              @OA\Property(property="strType", type="string", example="Passport"),
     *                              @OA\Property(property="strIssueBy", type="string", example="Abir Ahmad"),
     *                              @OA\Property(property="strNumber", type="string", example="12345678"),
     *                              @OA\Property(property="strIssueDate", type="string", example="2020-09-09"),
     *                              @OA\Property(property="strExpiryDate", type="string", example="2020-10-10"),
     *                              @OA\Property(property="intEmployeeId", type="integer", example=6),
     *                              @OA\Property(property="intUnitId", type="integer", example=17),
     *                              @OA\Property(property="imageFiles", type="string", example="/images"),
     *                          ),
     *                      ),
     *              )
     *      ),
     *      operationId="createEmployeeDocument",
     *      @OA\Response(response=200,description="Create Employee Document"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createEmployeeDocument(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeDocumentRepository->createEmployeeDocument($request->all());

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Document Created');
            } else {
                return $this->responseRepository->ResponseError(null, 'Employee Document Create Not Successfull');
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }


    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/updateEmployeeDocument",
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
     *      operationId="updateEmployeeDocument",
     *      @OA\Response(response=200,description="Update Employee Document"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateEmployeeDocument(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeDocumentRepository->updateEmployeeDocument($request);

            if (!is_null($data)) {
                return $this->responseRepository->ResponseSuccess($data, 'Employee Document Updated');
            }
            return $this->responseRepository->ResponseError(null, 'Employee Document Update Not Successfull');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage());
        }
    }
}
