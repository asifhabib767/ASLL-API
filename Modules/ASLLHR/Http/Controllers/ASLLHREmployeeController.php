<?php

namespace Modules\ASLLHR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ASLLHR\Repositories\ASLLHREmployeeRepository;
use Illuminate\Support\Facades\Auth;

class ASLLHREmployeeController extends Controller
{


    public $asllhrEmployeeRepository;
    public $responseRepository;


    public function __construct(ASLLHREmployeeRepository $asllhrEmployeeRepository, ResponseRepository $rp)
    {
        $this->asllhrEmployeeRepository = $asllhrEmployeeRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getEmployeePersonal",
     *     tags={"ASLLHR"},
     *     summary="Get Employee List",
     *     description="Get Employee List",
     *      operationId="index",
     *      security={{"bearer": {}}},
     *      @OA\Parameter( name="intVesselId", description="intVesselId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Get Employee List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        // if(!request()->user()->hasPermissionTo('crew.employee.view')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        try {
            $data = $this->asllhrEmployeeRepository->getEmployeePersonal();
            return $this->responseRepository->ResponseSuccess($data, 'Employee List Fetched successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getEmployeeDropdownList",
     *     tags={"ASLLHR"},
     *     summary="Get Employee List",
     *     description="Get Employee List",
     *      operationId="getEmployeeDropdownList",
     *      security={{"bearer": {}}},
     *      @OA\Parameter( name="intVesselId", description="intVesselId, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Get Employee List"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeDropdownList()
    {
        // if(!request()->user()->hasPermissionTo('crew.employee.view')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        try {
            $data = $this->asllhrEmployeeRepository->getEmployeeDropdownList();
            return $data;
            return $this->responseRepository->ResponseSuccess($data, 'Employee List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getEmployeePersonalDetails/{intID}",
     *     tags={"ASLLHR"},
     *     summary="Get Employee Details",
     *     description="Get Employee Details",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      operationId="getEmployeePersonalDetails",
     *      @OA\Response(response=200,description="Get Employee Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeePersonalDetails($intID)
    {
        // if(!request()->user()->hasPermissionTo('view_profile')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        try {
            $data = $this->asllhrEmployeeRepository->getEmployeePersonalDetails($intID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Details By ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getEmployeeDetails/{intID}",
     *     tags={"ASLLHR"},
     *     summary="Get Single Employee Details",
     *     description="Get Single Employee Details",
     *     security={{"bearer": {}}},
     *      @OA\Parameter( name="intID", description="intID, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      operationId="getEmployeeDetails",
     *      @OA\Response(response=200,description="Get Single Employee Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeDetails($intID)
    {
        // if(!request()->user()->hasPermissionTo('view_profile')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        if (Auth::user()->intEnroll != $intID) {
            return $this->responseRepository->ResponseSuccess(null, 'Sorry! You are not authenticated to see this data.');
        }

        try {
            $data = $this->asllhrEmployeeRepository->getEmployeeDetails($intID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Details By ID');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/createEmployeePersonal",
     *     tags={"ASLLHR"},
     *     summary="Post Employee",
     *     description="Post Employee",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="strName", type="string", example="Abir Ahmad"),
     *              @OA\Property(property="strBirthdate", type="string", example="1993-08-06"),
     *              @OA\Property(property="strBirthPlace", type="string", example="Dhaka"),
     *              @OA\Property(property="image", type="image/png", example="/images"),
     *              @OA\Property(property="strHomeTelephone", type="string", example="01832203578"),
     *              @OA\Property(property="strRank", type="string", example="Captain"),
     *              @OA\Property(property="strAvailabilityDate", type="string", example="2020-12-19"),
     *              @OA\Property(property="strEmail", type="string", example="abir.corp@akij.net"),
     *              @OA\Property(property="strHeight", type="string", example="5'6''"),
     *              @OA\Property(property="strWeight", type="string", example="70"),
     *              @OA\Property(property="strNationality", type="string", example="Bangladeshi"),
     *              @OA\Property(property="strEmgrPersonalTel", type="string", example="34534643"),
     *              @OA\Property(property="strEmgrPersonName", type="string", example="Akash"),
     *              @OA\Property(property="strEmgrPersonRelation", type="string", example="friend"),
     *              @OA\Property(property="strEmgrPersonAddress", type="string", example="Dhaka"),
     *              @OA\Property(property="strTradingArea", type="string", example="Chittagong"),
     *              @OA\Property(property="strCargoCarried", type="string", example="Akij Pearl"),
     *              @OA\Property(property="strNearestAirport", type="string", example="Shahjalal Airport"),
     *              @OA\Property(property="strBoilersuit", type="string", example="taken"),
     *              @OA\Property(property="strSafetyShoes", type="string", example="taken"),
     *              @OA\Property(property="strUniformShirt", type="string", example="taken"),
     *              @OA\Property(property="strUniformTrouser", type="string", example="taken"),
     *              @OA\Property(property="strWinterJacket", type="string", example="taken"),
     *              @OA\Property(property="strPermanentAddress", type="string", example="mohakhali"),
     *              @OA\Property(property="strPresentAddress", type="string", example="mohakhali"),
     *              @OA\Property(property="strRemarks", type="string", example="A burned sign on left hand"),
     *              @OA\Property(property="create_at", type="string", example="2020-12-19 00:00:00"),
     *              @OA\Property(property="updated_at", type="string", example="2020-12-19 00:00:00"),
     *          )
     *      ),
     *      operationId="createEmployeePersonal",
     *      @OA\Response(response=200,description="Post Employee"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createEmployeePersonal(Request $request)
    {
        // if(!request()->user()->hasPermissionTo('view_profile')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        try {
            $data = $this->asllhrEmployeeRepository->createEmployeePersonal($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Info Created Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/asllhr/updateEmployeePersonal",
     *     tags={"ASLLHR"},
     *     summary="Update Employee",
     *     description="Update Employee",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=1),
     *              @OA\Property(property="strName", type="string", example="Abir Ahmad"),
     *              @OA\Property(property="strBirthdate", type="string", example="1993-08-06"),
     *              @OA\Property(property="strBirthPlace", type="string", example="Dhaka"),
     *              @OA\Property(property="image", type="string", format="base64"),
     *              @OA\Property(property="strHomeTelephone", type="string", example="01832203578"),
     *              @OA\Property(property="strRank", type="string", example="Captain"),
     *              @OA\Property(property="strAvailabilityDate", type="string", example="2020-12-19"),
     *              @OA\Property(property="strEmail", type="string", example="abir.corp@akij.net"),
     *              @OA\Property(property="strHeight", type="string", example="5'6''"),
     *              @OA\Property(property="strWeight", type="string", example="70"),
     *              @OA\Property(property="strNationality", type="string", example="Bangladeshi"),
     *              @OA\Property(property="strEmgrPersonalTel", type="string", example="34534643"),
     *              @OA\Property(property="strEmgrPersonName", type="string", example="Akash"),
     *              @OA\Property(property="strEmgrPersonRelation", type="string", example="friend"),
     *              @OA\Property(property="strEmgrPersonAddress", type="string", example="Dhaka"),
     *              @OA\Property(property="strTradingArea", type="string", example="Chittagong"),
     *              @OA\Property(property="strCargoCarried", type="string", example="Akij Pearl"),
     *              @OA\Property(property="strNearestAirport", type="string", example="Shahjalal Airport"),
     *              @OA\Property(property="strBoilersuit", type="string", example="taken"),
     *              @OA\Property(property="strSafetyShoes", type="string", example="taken"),
     *              @OA\Property(property="strUniformShirt", type="string", example="taken"),
     *              @OA\Property(property="strUniformTrouser", type="string", example="taken"),
     *              @OA\Property(property="strWinterJacket", type="string", example="taken"),
     *              @OA\Property(property="strPermanentAddress", type="string", example="mohakhali"),
     *              @OA\Property(property="strPresentAddress", type="string", example="mohakhali"),
     *              @OA\Property(property="strRemarks", type="string", example="A burned sign on left hand"),
     *              @OA\Property(property="create_at", type="string", example="2020-12-19 00:00:00"),
     *              @OA\Property(property="updated_at", type="string", example="2020-12-19 00:00:00"),
     *          )
     *      ),
     *      operationId="updateEmployeePersonal",
     *      @OA\Response(response=200,description="Update Employee"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateEmployeePersonal(Request $request)
    {
        // if(!request()->user()->hasPermissionTo('crew.employee.edit')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        try {
            $data = $this->asllhrEmployeeRepository->updateEmployeePersonal($request);
            return $this->responseRepository->ResponseSuccess($data, 'Post Employee Info Updated Successfully');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/asllhr/delete/{id}",
     *     tags={"ASLLHR"},
     *     summary="Delete Employee",
     *     description="Delete Employee",
     *      operationId="deleteEmployee",
     *      @OA\Parameter( name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *      @OA\Response(response=200,description="Delete Employee"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteEmployee($id)
    {
        // if(!request()->user()->hasPermissionTo('crew.employee.delete')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        try {
            $data = $this->asllhrEmployeeRepository->deleteEmployee($id);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/asllhr/getemployeeSearch",
     *     tags={"ASLLHR"},
     *     summary="Get Search Employee ",
     *     description="Get Single Employee Details",
     *      @OA\Parameter( name="employeeName", description="EmployeeId, eg; 1", in="query", @OA\Schema(type="string")),
     *      @OA\Parameter( name="vesselId", description="vesselId, eg; 1", in="query", @OA\Schema(type="integer")),
     *      operationId="getemployeeSearch",
     *      @OA\Response(response=200,description="Get Single Employee Details"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function getemployeeSearch(Request $request)
    {
        // if(!request()->user()->hasPermissionTo('crew.employee.view')){
        //     return $this->responseRepository->ResponseError(null, 'You are not authorized to give permission', Response::HTTP_UNAUTHORIZED);
        // }
        try {
            $data = $this->asllhrEmployeeRepository->getemployeeSearch($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Search SuccessFully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
