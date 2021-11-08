<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeSignInOutRepository;

class ASLLHREmployeeSignInOutController extends Controller
{

    public $asllhrEmployeeSignInOutRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeSignInOutRepository $asllhrEmployeeSignInOutRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeSignInOutRepository = $asllhrEmployeeSignInOutRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/employeeSignInOut",
     *     tags={"ASLLHR"},
     *     summary="Get Employee Sign In Or Out List",
     *     description="Get Employee Sign In Or Out List",
     *      @OA\Parameter(name="isPaginated", description="isPaginated, eg; 0", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="paginateNo", description="paginateNo, eg; 0", required=false, in="query", @OA\Schema(type="integer")),
     *      security={{"bearer": {}}},
     *      operationId="getEmployeeSignInOut",
     *      @OA\Response(response=200,description="Get Employee Sign In Or Out List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeSignInOut()
    {
        try {
            $data = $this->asllhrEmployeeSignInOutRepository->getEmployeeSignInOutList();
            return $this->responseRepository->ResponseSuccess($data, 'Employee Sign List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/employeeSignInOut/create",
     *     tags={"ASLLHR"},
     *     summary="Post EmployeeSignInOut",
     *     description="Post EmployeeSignInOut",
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
     *      @OA\Response(response=200,description="Post EmployeeSignInOut"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function create(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeSignInOutRepository->createEmployeeSignInOut($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Signed in');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/employeeSignInOut/update",
     *     tags={"ASLLHR"},
     *     summary="Update EmployeeSignInOut",
     *     description="Update EmployeeSignInOut",
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
     *      operationId="update",
     *      @OA\Response(response=200,description="Update EmployeeSignInOut"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeSignInOutRepository->updateEmployeeSignInOut($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Signed in');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\DELETE(
     *     path="/api/v1/asllhr/employeeSignInOut/deleteEmployeeSignInOut",
     *     tags={"ASLLHR"},
     *     summary="Delete EmployeeSignInOut",
     *     description="Delete EmployeeSignInOut",
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      operationId="deleteEmployeeSignInOut",
     *      @OA\Response(response=200,description="Delete EmployeeSignInOut"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteEmployeeSignInOut(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeSignInOutRepository->deleteEmployeeSignInOut($request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Signed Data Deleted !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/employeeSignInOut/getemployeeSigningSearch",
     *     tags={"ASLLHR"},
     *     summary="Get Search Employee ",
     *     description="Get Single Employee Details",
     *      @OA\Parameter( name="employeeName", description="EmployeeId, eg; 1", in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="vesselId", description="vesselId, eg; 1", in="query", @OA\Schema(type="integer")),
     *      operationId="getemployeeSigningSearch",
     *      @OA\Response(response=200,description="Get Single Employee Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getemployeeSigningSearch(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeSignInOutRepository->getemployeeSigningSearch($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Search SuccessFully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
