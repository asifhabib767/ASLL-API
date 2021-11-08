<?php

namespace Modules\HR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\HR\Http\Requests\GetMealRequest;
use Modules\HR\Repositories\HRRepository;

class HRController extends Controller
{

    public $hrRepository;
    public $responseRepository;


    public function __construct(HRRepository $hrRepository, ResponseRepository $rp)
    {
        $this->hrRepository = $hrRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getSalaryStatement",
     *     tags={"HR"},
     *     summary="getSalaryStatement",
     *     description="getSalaryStatement",
     *     operationId="getSalaryStatement",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 422906", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getSalaryStatement"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSalaryStatement(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        // return $intEmployeeId;
        try {
            $data = $this->hrRepository->getSalaryStatement($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Salary Statement');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getCafeteriaMenuList",
     *     tags={"HR"},
     *     summary="getCafeteriaMenuList",
     *     description="getCafeteriaMenuList",
     *     operationId="getCafeteriaMenuList",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 422906", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getCafeteriaMenuList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getCafeteriaMenuList(Request $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        // return $intEmployeeId;
        try {
            $data = $this->hrRepository->getCafeteriaMenuList($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Cafeteria Menu');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getMealList",
     *     tags={"HR"},
     *     summary="getMealList",
     *     description="getMealList",
     *     operationId="getMealList",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 422906", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="ysnConsumed", description="ysnConsumed, eg; true", required=true, in="query", @OA\Schema(type="boolean")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getMealList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMealList(GetMealRequest $request)
    {
        $intEmployeeId = $request->intEmployeeId;
        $ysnConsumed = $request->ysnConsumed;

        try {
            $data = $this->hrRepository->getMealList($intEmployeeId, $ysnConsumed);
            return $this->responseRepository->ResponseSuccess($data, 'Meal List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\PUT(
     *     path="/api/v1/hr/deleteMealList",
     *     tags={"HR"},
     *     summary="Delete Meal",
     *     description="Delete Meal",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intEnroll", type="integer", example=422906),
     *              @OA\Property(property="dteMeal", type="string", example="2020-12-19"),
     *          )
     *      ),
     *      operationId="deleteMealList",
     *     security={{"bearer": {}}},
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Delete Meal"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteMealList(Request $request)
    {
        try {
            $data = $this->hrRepository->deleteMealList($request);
            return $this->responseRepository->ResponseSuccess($data, 'Delete Meal List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getProfileByEnrollandUnitId",
     *     tags={"Profile Data"},
     *     summary="getSalaryStatement",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getProfileByenrollandUnitId",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intUnitId", description="intUnitId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getProfileByenrollandUnitId"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getProfileByEnrollandUnitId(Request $request)
    {

        $intUnitId = $request->intUnitId;
        try {
            $data = $this->hrRepository->getProfileByEnrollandUnitId($intUnitId);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Profile');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/v1/hr/getEmployeeProfileSearch",
     *     tags={"Profile Data"},
     *     summary="getEmployeeProfileSearch",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getEmployeeProfileSearch",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeID", description="intEmployeeID  , eg; farid uddin", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200,description="getEmployeeProfileSearch"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeProfileSearch(Request $request)
    {

        $intEmployeeID = $request->intEmployeeID;
        try {
            $data = $this->hrRepository->getEmployeeProfileSearch($intEmployeeID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Profile');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/hr/getEmployeeProfileDetails",
     *     tags={"Profile Data"},
     *     summary="getEmployeeProfileDetails",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getEmployeeProfileDetails",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="strOfficeEmail", description="strOfficeEmail  , eg; akash.corp@akij.net", required=true, in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200,description="getEmployeeProfileDetails"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeProfileDetails(Request $request)
    {
        // if ($request->user()->email != $request->strOfficeEmail) {
        //     return $this->responseRepository->ResponseSuccess(null, 'Sorry! You are not authenticated to see this data.');
        // }

        $strOfficeEmail = $request->strOfficeEmail;
        try {
            $data = $this->hrRepository->getEmployeeProfileByEmail($strOfficeEmail);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Profile By Email Address');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getGeolocationforAllJobstation",
     *     tags={"Jobstation Geo Location"},
     *     summary="getGeolocationforAllJobstation",
     *     description="getProfileByenrollandUnitId",
     *     security={{"bearer": {}}},
     *     operationId="getGeolocationforAllJobstation",
     *     @OA\Parameter( name="intUnitID", description="intUnitID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getGeolocationforAllJobstation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getGeolocationforAllJobstation(Request $request)
    {

        $intUnitID = $request->intUnitID;

        // return  $intUnitID;
        try {
            $data = $this->hrRepository->getGeolocationforAllJobstation($intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Jobstation Geo Location');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getGeolocationforSingleJobstation",
     *     tags={"Jobstation Geo Location"},
     *     summary="getGeolocationforSingleJobstation",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getGeolocationforSingleJobstation",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeJobStationId", description="intEmployeeJobStationId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getGeolocationforSingleJobstation"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getGeolocationforSingleJobstation(Request $request)
    {

        $intEmployeeJobStationId = $request->intEmployeeJobStationId;

        // return  $intEmployeeJobStationId;
        try {
            $data = $this->hrRepository->getGeolocationforSingleJobstation($intEmployeeJobStationId);
            return $this->responseRepository->ResponseSuccess($data, 'Jobstation Geo Location');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/hr/postGeolocationUpdateByManpower",
     *     tags={"Jobstation Geo Location"},
     *     summary="Create New Jobstation Geo Location",
     *     description="Create New Jobstation Geo Location",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intJobStationId", type="integer", example=1),
     *                 @OA\Property(property="intUnitId", type="integer", example=1),
     *                 @OA\Property(property="decLatitude", type="integer", example=1),
     *                 @OA\Property(property="decLongitude", type="integer", example=1),
     *                 @OA\Property(property="intZAxis", type="integer", example=4),
     *                 @OA\Property(property="intUpdateBy", type="integer", example=1272),

     *              )
     *           ),
     *      operationId="postGeolocationUpdateByManpower",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create New DepositNItemInformationByApps" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postGeolocationUpdateByManpower(Request $request)
    {
        try {
            $data = $this->hrRepository->postGeolocationUpdateByManpower($request);
            return $this->responseRepository->ResponseSuccess($data, 'Job Station Configured Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // intEnroll,intPoint,intActionBy,strLocation,strCurrentLonx,strCurrentLaty,strDistance
    /**
     * @OA\POST(
     *     path="/api/v1/hr/postEmployeeAttendance",
     *     tags={"Attendance"},
     *     summary="Insertion Employee Attendance",
     *     description="Insertion Employee Attendance",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intJobStationId", type="integer", example=1),
     *                 @OA\Property(property="intEnroll", type="integer", example=1),
     *                 @OA\Property(property="intPoint", type="integer", example=1),
     *                 @OA\Property(property="strLocation", type="string", example=1),
     *                 @OA\Property(property="strCurrentLonx", type="string", example=1),
     *                 @OA\Property(property="strCurrentLaty", type="strCurrentLaty", example=1),
     *              )
     *           ),
     *      operationId="postEmployeeAttendance",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Insertion Employee Attendance" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postEmployeeAttendance(Request $request)
    {
        try {
            $data = $this->hrRepository->postEmployeeAttendance($request);
            if ($data->status == false) {
                return $this->responseRepository->ResponseError(null, $data->message, Response::HTTP_OK);
            } else {
                return $this->responseRepository->ResponseSuccess($data, $data->message);
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getSupervisorVsEmployeeList",
     *     tags={"Jobstation Geo Location"},
     *     summary="getSupervisorVsEmployeeList",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getSupervisorVsEmployeeList",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intSupervisorId", description="intSupervisorId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="getSupervisorVsEmployeeList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getSupervisorVsEmployeeList(Request $request)
    {

        $intSupervisorId = $request->intSupervisorId;

        // return  $intSupervisorId;
        try {
            $data = $this->hrRepository->getSupervisorVsEmployeeList($intSupervisorId);
            return $this->responseRepository->ResponseSuccess($data, 'Jobstation Geo Location');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/hr/postOvertimeEntry",
     *     tags={"OverTime"},
     *     summary="Insertion Employe Overtime",
     *     description="Insertion Employe Overtime",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intUnitId", type="integer", example=1),
     *                 @OA\Property(property="dteBillDate", type="integer", example=1),
     *                 @OA\Property(property="decStartime", type="string", example=1),
     *                 @OA\Property(property="decEndtime", type="string", example=1),
     *                 @OA\Property(property="decMovDuration", type="string", example=1),
     *                 @OA\Property(property="intHour", type="integer", example=1),
     *
     *                 @OA\Property(property="strNotes", type="string", example=1),
     *                 @OA\Property(property="intPurpouseId", type="integer", example=1),
     *                 @OA\Property(property="intApplicantenrol", type="integer", example=1),
     *
     *  )
     *           ),
     *      operationId="postOvertimeEntry",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Insertion Employe Overtime" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postOvertimeEntry(Request $request)
    {
        try {
            $data = $this->hrRepository->postOvertimeEntry($request);
            if ($data->status == false) {
                return $this->responseRepository->ResponseError(null, $data->message, Response::HTTP_OK);
            } else {
                return $this->responseRepository->ResponseSuccess($data, $data->message);
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/hr/gettAttenanceDailySummaryReport",
     *     tags={"Jobstation Geo Location"},
     *     summary="gettAttenanceDailySummaryReport",
     *     description="getProfileByenrollandUnitId",
     *     operationId="gettAttenanceDailySummaryReport",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="MonthNum", description="MonthNum, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="Year", description="Year, eg; 4", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="gettAttenanceDailySummaryReport"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function gettAttenanceDailySummaryReport(Request $request)
    {

        $intEmployeeId = $request->intEmployeeId;
        $MonthNum = $request->MonthNum;

        $Year = $request->Year;


        // return  $intEmployeeId;
        try {
            $data = $this->hrRepository->gettAttenanceDailySummaryReport($intEmployeeId, $MonthNum,$Year);
            return $this->responseRepository->ResponseSuccess($data, 'Attendance Daily Summery');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

  /**
     * @OA\GET(
     *     path="/api/v1/hr/getLeaveApplicationSummaryByUser",
     *     tags={"Jobstation Geo Location"},
     *     summary="getLeaveApplicationSummaryByUser",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getLeaveApplicationSummaryByUser",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),


     *     @OA\Response(response=200,description="getLeaveApplicationSummaryByUser"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLeaveApplicationSummaryByUser(Request $request)
    {

        $intEmployeeId = $request->intEmployeeId;



        // return  $intEmployeeId;
        try {
            $data = $this->hrRepository->getLeaveApplicationSummaryByUser($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'Attendance Daily Summery');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


      /**
     * @OA\GET(
     *     path="/api/v1/hr/getLeaveApplicationTypeByUser",
     *     tags={"Jobstation Geo Location"},
     *     summary="getLeaveApplicationTypeByUser",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getLeaveApplicationTypeByUser",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmployeeId", description="intEmployeeId, eg; 4", required=true, in="query", @OA\Schema(type="integer")),


     *     @OA\Response(response=200,description="getLeaveApplicationTypeByUser"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getLeaveApplicationTypeByUser(Request $request)
    {

        $intEmployeeId = $request->intEmployeeId;



        // return  $intEmployeeId;
        try {
            $data = $this->hrRepository->getLeaveApplicationTypeByUser($intEmployeeId);
            return $this->responseRepository->ResponseSuccess($data, 'get LeaveApplication Type By User');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\DELETE(
     *     path="/api/v1/hr/DeleteLeaveApplication",
     *     tags={"HR"},
     *     summary="Delete LeaveApplication",
     *     description="Delete LeaveApplication",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intEnroll", type="integer", example=422906),
     *              @OA\Property(property="intApplicationId", type="integer", example=1),
     *          )
     *      ),
     *      operationId="DeleteLeaveApplication",
     *     security={{"bearer": {}}},

     *      @OA\Response(response=200,description="DeleteLeaveApplication"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function DeleteLeaveApplication(Request $request)
    {
        try {
            $data = $this->hrRepository->DeleteLeaveApplication($request);
            return $this->responseRepository->ResponseSuccess($data, 'Delete LeaveApplication');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

      /**
     * @OA\GET(
     *     path="/api/v1/hr/getMovementApplicationSummaryByUser",
     *     tags={"HR"},
     *     summary="getMovementApplicationSummaryByUser",
     *     description="getProfileByenrollandUnitId",
     *     operationId="getMovementApplicationSummaryByUser",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intEmpID", description="intEmpID, eg; 4", required=true, in="query", @OA\Schema(type="integer")),


     *     @OA\Response(response=200,description="getMovementApplicationSummaryByUser"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getMovementApplicationSummaryByUser(Request $request)
    {

        $intEmpID = $request->intEmpID;



        // return  $intEmpID;
        try {
            $data = $this->hrRepository->getMovementApplicationSummaryByUser($intEmpID);
            return $this->responseRepository->ResponseSuccess($data, 'get LeaveApplication Type By User');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @OA\POST(
     *     path="/api/v1/hr/postLeaveApplication",
     *     tags={"HR"},
     *     summary="Insertion Employe Leave",
     *     description="Insertion Employe Leave",
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intEmployeeID", type="integer", example=1272),
     *                 @OA\Property(property="intLeaveTypeID", type="integer", example=1),
     *                 @OA\Property(property="dateAppliedFrom", type="string", example="2021-01-01"),
     *                 @OA\Property(property="dateAppliedTo", type="string", example="2021-01-07"),
     *                 @OA\Property(property="tmStart", type="string", example="06:00:00"),
     *                 @OA\Property(property="tmEnd", type="string", example="06:00:00"),
     *
     *                 @OA\Property(property="strLeaveReason", type="string", example="Personal"),
     *                 @OA\Property(property="strAddressDuetoLeave", type="string", example="Personal"),
     *                 @OA\Property(property="strphoneDuetoLeave", type="string", example="0173"),
     *                 @OA\Property(property="intAppliedBy", type="integer", example=1)
     *              )
     *           ),
     *      operationId="postLeaveApplication",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Insertion Employe Leave" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function postLeaveApplication(Request $request)
    {
        // return $request;

        try {
            $data = $this->hrRepository->postLeaveApplication($request);
            return  $data ;

            if ($data['status'] == false) {
                return $this->responseRepository->ResponseError(null, $data->message, Response::HTTP_OK);
            } else {
                return $this->responseRepository->ResponseSuccess($data, $data->message);
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
/**
     * @OA\GET(
     *     path="/api/v1/hr/GetMovementType",
     *     tags={"HR"},
     *     summary="GetMovementType",
     *     description="getProfileByenrollandUnitId",
     *     operationId="GetMovementType",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetMovementType"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetMovementType()
    {



        try {
            $data = $this->hrRepository->GetMovementType();
            return $this->responseRepository->ResponseSuccess($data, 'Jobstation Geo Location');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * @OA\GET(
     *     path="/api/v1/hr/GetCountryList",
     *     tags={"HR"},
     *     summary="GetCountryList",
     *     description="Get CountryList List",
     *     operationId="GetCountryList",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetCountryList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetCountryList()
    {



        try {
            $data = $this->hrRepository->GetCountryList();
            return $this->responseRepository->ResponseSuccess($data, 'Get Country List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/hr/MovementApplication",
     *     tags={"HR"},
     *     summary="Insertion MovementApplication",
     *     description="Insertion MovementApplication",
     *     @OA\RequestBody(
     *       @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intEmployeeID", type="integer", example=1272),
     *                 @OA\Property(property="intCountry", type="integer", example=1),
     *                 @OA\Property(property="intDistrict", type="integer", example=11),
     *                 @OA\Property(property="dateFrom", type="string", example="2021-01-07"),
     *                 @OA\Property(property="dateTo", type="string", example="2021-01-07"),
     *                 @OA\Property(property="strReason", type="string", example="Test"),
     *
     *                 @OA\Property(property="strAddress", type="string", example="Dhaka"),
     *                 @OA\Property(property="intAppliedBy", type="integer", example=1272),
     *              )
     *           ),
     *      operationId="MovementApplication",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Insertion MovementApplication" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function MovementApplication(Request $request)
    {
    //    return $request;

        try {
            $data = $this->hrRepository->MovementApplication($request);
            return  $data ;

            if ($data['status'] == false) {
                return $this->responseRepository->ResponseError(null, $data->message, Response::HTTP_OK);
            } else {
                return $this->responseRepository->ResponseSuccess($data, $data->message);
            }
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/GetDistrictList",
     *     tags={"HR"},
     *     summary="GetDistrictList",
     *     description="getProfileByenrollandUnitId",
     *     operationId="GetDistrictList",
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="GetDistrictList"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function GetDistrictList()
    {



        try {
            $data = $this->hrRepository->GetDistrictList();
            return $this->responseRepository->ResponseSuccess($data, 'Get Country List');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/hr/MovementApplicationDelete",
     *     tags={"HR"},
     *     summary="Delete Movement Application",
     *     description="Delete Movement Application",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intId", type="integer", example=422906),
     *              @OA\Property(property="intEmpID", type="integer", example=1),
     *          )
     *      ),
     *      operationId="MovementApplicationDelete",
     *     security={{"bearer": {}}},

     *      @OA\Response(response=200,description="MovementApplicationDelete"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function MovementApplicationDelete(Request $request)
    {
        try {
            $data = $this->hrRepository->MovementApplicationDelete($request);
          return $data ;

             return $this->responseRepository->ResponseSuccess($data, 'Delete Movement Application');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
