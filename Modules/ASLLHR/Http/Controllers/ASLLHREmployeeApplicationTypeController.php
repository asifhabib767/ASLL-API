<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeApplicationTypeRepository;

class ASLLHREmployeeApplicationTypeController extends Controller
{
    public $asllhrEmployeeApplicationTypeRepository;
    public $responseRepository;

    public function __construct(ASLLHREmployeeApplicationTypeRepository $asllhrEmployeeApplicationTypeRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeApplicationTypeRepository = $asllhrEmployeeApplicationTypeRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/employeeApplicationType",
     *     tags={"EmployeeApplicationType"},
     *     summary="Get Employee Application Type List",
     *     description="Get Employee Application Type List",
     *     security={{"bearer": {}}},
     *      operationId="getEmployeeApplicationType",
     *      @OA\Response(response=200,description="Get Employee Application Type List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeApplicationType()
    {
        try {
            $data = $this->asllhrEmployeeApplicationTypeRepository->getEmployeeApplicationTypeList();
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Type List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/employeeApplicationType/create",
     *     tags={"EmployeeApplicationType"},
     *     summary="Post Employee Application Type",
     *     description="Post Employee Application Type",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strTypeName", type="string", example="Casual Leave"),
     *              @OA\Property(property="ysnCRReport", type="boolean", example=true),
     *          )
     *      ),
     *      operationId="create",
     *      @OA\Response(response=200,description="Post Employee Application Type"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function create(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationTypeRepository->createEmployeeApplicationType($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Type Created');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/asllhr/employeeApplicationType/update",
     *     tags={"EmployeeApplicationType"},
     *     summary="Update Employee Application Type",
     *     description="Update Employee Application Type",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=2),
     *              @OA\Property(property="strTypeName", type="string", example="Casual Leave"),
     *              @OA\Property(property="ysnCRReport", type="boolean", example=true),
     *          )
     *      ),
     *      operationId="update",
     *      @OA\Response(response=200,description="Update Employee Application Type"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationTypeRepository->updateEmployeeApplicationType($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Type Updated');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\DELETE(
     *     path="/api/v1/asllhr/employeeApplicationType/deleteEmployeeApplicationType",
     *     tags={"EmployeeApplicationType"},
     *     summary="Delete Employee Application Type",
     *     description="Delete Employee Application Type",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *      operationId="deleteEmployeeApplicationType",
     *      @OA\Response(response=200,description="Delete Employee Application Type"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteEmployeeApplicationType(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationTypeRepository->deleteEmployeeApplicationType($request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Type Deleted !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/employeeApplicationType/getEmployeeApplicationTypeSearch",
     *     tags={"EmployeeApplicationType"},
     *     summary="Get Search Employee Application Type ",
     *     description="Get Employee Application Type Details",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="strTypeName", description="strTypeName, eg; Medical", in="query", @OA\Schema(type="string")),
     *      operationId="getEmployeeApplicationTypeSearch",
     *      @OA\Response(response=200,description="Get Employee Application Type Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getEmployeeApplicationTypeSearch(Request $request)
    {
        try {
            $data = $this->asllhrEmployeeApplicationTypeRepository->getEmployeeApplicationTypeSearch($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Application Type Search SuccessFully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
