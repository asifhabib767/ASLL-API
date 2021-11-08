<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeApplicationRepository;
use Modules\ASLLHR\Http\Requests\EmployeeApplicationCreateRequest;
use Modules\ASLLHR\Http\Requests\EmployeeApplicationUpdateRequest;

class ASLLHREmployeeApplicationController extends Controller
{
    public $asllhrEmployeeApplicationRepository;
    public $responseRepository;

    public function __construct(ASLLHREmployeeApplicationRepository $asllhrEmployeeApplicationRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeApplicationRepository = $asllhrEmployeeApplicationRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/employeeApplication",
     *     tags={"EmployeeApplication"},
     *     summary="Get Employee Application List",
     *     description="Get Employee Application List",
     *      @OA\Parameter(name="isPaginated", description="isPaginated, eg; 0", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="paginateNo", description="paginateNo, eg; 0", required=false, in="query", @OA\Schema(type="integer")),
     *      operationId="getEmployeeApplication",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Get Employee Application List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeApplication()
    {
        try {
            $data = $this->asllhrEmployeeApplicationRepository->getEmployeeApplicationList();
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/employeeApplication/create",
     *     tags={"EmployeeApplication"},
     *     summary="Post Employee Application",
     *     description="Post Employee Application",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intApplicationTypeId", type="integer", example=2),
     *              @OA\Property(property="intEmployeeId", type="integer", example=3),
     *              @OA\Property(property="intRankId", type="integer", example=2),
     *              @OA\Property(property="intVesselId", type="integer", example=2),
     *              @OA\Property(property="strReceiverName", type="string", example="Captain Masud"),
     *              @OA\Property(property="dteFromDate", type="string", example="2021-01-21"),
     *              @OA\Property(property="strPortName", type="string", example="Chittagong"),
     *              @OA\Property(property="strApplicationBody", type="text", example="Chittagong"),
     *              @OA\Property(property="strCommencementTenure", type="string", example="Test"),
     *              @OA\Property(property="dteDateOfCompletion", type="string", example="2021-01-25"),
     *              @OA\Property(property="dteExtensionRequested", type="string", example="2021-01-25"),
     *              @OA\Property(property="dteRejoiningDate", type="string", example="2021-01-25"),
     *              @OA\Property(property="strRemarks", type="text", example="Sickness"),
     *              @OA\Property(property="strApplicationSubject", type="string", example="Request to permit my leave"),
     *          )
     *      ),
     *      operationId="create",
     *      @OA\Response(response=200,description="Post Employee Application"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function create(EmployeeApplicationCreateRequest $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationRepository->createEmployeeApplication($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/employeeApplication/update",
     *     tags={"EmployeeApplication"},
     *     summary="Update Employee Application",
     *     description="Update Employee Application",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=2),
     *              @OA\Property(property="intApplicationTypeId", type="integer", example=2),
     *              @OA\Property(property="intEmployeeId", type="integer", example=3),
     *              @OA\Property(property="intRankId", type="integer", example=2),
     *              @OA\Property(property="intVesselId", type="integer", example=2),
     *              @OA\Property(property="strReceiverName", type="string", example="Captain Masud"),
     *              @OA\Property(property="dteFromDate", type="string", example="2021-01-21"),
     *              @OA\Property(property="strPortName", type="string", example="Chittagong"),
     *              @OA\Property(property="strApplicationBody", type="string", example="Chittagong"),
     *              @OA\Property(property="strCommencementTenure", type="string", example="Test"),
     *              @OA\Property(property="dteDateOfCompletion", type="string", example="2021-01-25"),
     *              @OA\Property(property="dteExtensionRequested", type="string", example="2021-01-25"),
     *              @OA\Property(property="dteRejoiningDate", type="string", example="2021-01-25"),
     *              @OA\Property(property="strRemarks", type="string", example="Sickness"),
     *              @OA\Property(property="strApplicationSubject", type="string", example="Request to permit my leave"),
     *          )
     *      ),
     *      operationId="update",
     *      @OA\Response(response=200,description="Update Employee Application"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(EmployeeApplicationUpdateRequest $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationRepository->updateEmployeeApplication($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Updated');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\DELETE(
     *     path="/api/v1/asllhr/employeeApplication/deleteEmployeeApplication",
     *     tags={"EmployeeApplication"},
     *     summary="Delete Employee Application",
     *     description="Delete Employee Application",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      operationId="deleteEmployeeApplication",
     *      @OA\Response(response=200,description="Delete Employee Application"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteEmployeeApplication(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationRepository->deleteEmployeeApplication($request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Deleted !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/employeeApplication/getEmployeeApplicationSearch",
     *     tags={"EmployeeApplication"},
     *     summary="Get Search Employee Application ",
     *     description="Get Employee Application Details",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="strReceiverName", description="strReceiverName, eg; sickness", in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="intApplicationTypeId", description="intApplicationTypeId, eg; 1", in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 1", in="query", @OA\Schema(type="integer")),
     *      operationId="getEmployeeApplicationSearch",
     *      @OA\Response(response=200,description="Get Employee Application Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getEmployeeApplicationSearch(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationRepository->getEmployeeApplicationSearch($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Search SuccessFully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/employeeApplication/getById",
     *     tags={"EmployeeApplication"},
     *     summary="Get Employee Application details by Id",
     *     description="Get Employee Application details by Id",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      operationId="getById",
     *      @OA\Response(response=200,description="Get Employee Application details by Id"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getById(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationRepository->getById($request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Details By Id !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
