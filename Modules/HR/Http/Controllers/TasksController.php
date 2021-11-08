<?php

namespace Modules\HR\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\HR\Repositories\TaskRepository;

class TasksController extends Controller
{
    public $taskRepository;
    public $responseRepository;


    public function __construct(TaskRepository $taskRepository, ResponseRepository $rp)
    {
        $this->taskRepository = $taskRepository;
        $this->responseRepository = $rp;
    }


    /**
     * @OA\GET(
     *     path="/api/v1/hr/getTaskAssignedToEmployee",
     *     tags={"Tasks"},
     *     summary="Task Assigned To Employee",
     *     description="Task Assigned To Employee",
     *     operationId="getTaskAssignedToEmployee",
     *     @OA\Parameter(name="intEmployeeId", example="439590", description="intEmployeeId, eg; 422906", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="status", example="pending", description="Possible Values: pending, done, reject, all", in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getTaskAssignedToEmployee"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getTaskAssignedToEmployee(Request $request)
    {
        $taskStatus = $request->status;
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->taskRepository->getTaskAssignedToEmployee($intEmployeeId, $taskStatus);
            return $this->responseRepository->ResponseSuccess($data, 'Task Assigned ToEmployee');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/hr/getTaskAssignedByEmployee",
     *     tags={"Tasks"},
     *     summary="Task Assigned By Employee",
     *     description="Task Assigned By Employee",
     *     operationId="getTaskAssignedByEmployee",
     *     @OA\Parameter(name="intEmployeeId", example="439590", description="intEmployeeId, eg; 422906", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="status", example="pending", description="Possible Values: pending, done, reject, all", in="query", @OA\Schema(type="string")),
     *     security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getTaskAssignedByEmployee"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getTaskAssignedByEmployee(Request $request)
    {
        $taskStatus = $request->status;
        $intEmployeeId = $request->intEmployeeId;
        try {
            $data = $this->taskRepository->getTaskAssignedByEmployee($intEmployeeId, $taskStatus);
            return $this->responseRepository->ResponseSuccess($data, 'Task Assigned ToEmployee');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/hr/storeNewTask",
     *     tags={"Tasks"},
     *     summary="Create Employee Task",
     *     description="Create Employee Task",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="strTaskTitle", type="string", example="Test Task"),
     *                 @OA\Property(property="strTaskDetails", type="string", example="Test Task Details"),
     *                 @OA\Property(property="intAssignedTo", type="integer", example=392407),
     *                 @OA\Property(property="intAssignedBy", type="integer", example=439590),
     *                 @OA\Property(property="dteTaskStartDateTime", type="string", example="2020-10-28 12:00:00"),
     *                 @OA\Property(property="dteTaskEndDateTime", type="string", example="2020-10-28 12:00:00"),
     *                 @OA\Property(property="intUnitId", type="integer", example=4)
     *              )
     *           ),
     *      operationId="storeNewTask",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create Employee Task" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeNewTask(Request $request)
    {
        try {
            $request->validate([
                'strTaskTitle' => 'required',
                'intAssignedTo' => 'required',
                'intAssignedBy' => 'required',
            ]);

            $data = $this->taskRepository->storeNewTask($request);
            return $this->responseRepository->ResponseSuccess($data, 'Task Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/hr/updateTask",
     *     tags={"Tasks"},
     *     summary="Update Employee Task",
     *     description="Update Employee Task",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intTaskId", type="integer", example=5),
     *                 @OA\Property(property="strTaskTitle", type="string", example="Test Task"),
     *                 @OA\Property(property="strTaskDetails", type="string", example="Test Task Details"),
     *                 @OA\Property(property="strTaskUpdateDetails", type="string", example="Test Task Details"),
     *                 @OA\Property(property="intUpdatedBy", type="integer", example=392407),
     *                 @OA\Property(property="dteTaskStartDateTime", type="string", example="2020-10-28 12:00:00"),
     *                 @OA\Property(property="dteTaskEndDateTime", type="string", example="2020-10-28 12:00:00"),
     *                 @OA\Property(property="status", type="string", example="done"),
     *              )
     *           ),
     *      operationId="updateTask",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Update Employee Task" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function updateTask(Request $request)
    {
        try {
            $request->validate([
                'intUpdatedBy' => 'required',
                'status' => 'required',
            ]);

            $data = $this->taskRepository->updateTask($request, $request->intTaskId);
            return $this->responseRepository->ResponseSuccess($data, 'Task Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @OA\POST(
     *     path="/api/v1/hr/storeEmployeeTrack",
     *     tags={"EmployeeTrack"},
     *     summary="Create Employee Tracking",
     *     description="Create Employee Tracking",
     *          @OA\RequestBody(
     *            @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="intUnitId", type="integer", example=4),
     *                 @OA\Property(property="intEmployeeID", type="integer", example=1272),
     *                 @OA\Property(property="intEmployeeTypeID", type="integer", example=1),
     *                 @OA\Property(property="dteDate", type="string", example="2020-10-28"),
     *                 @OA\Property(property="dtePunchInTime", type="string", example="2020-10-28 12:00:00"),
     *                 @OA\Property(property="dtePunchOutTime", type="string", example="2020-10-28 12:00:00"),
     *                 @OA\Property(property="decLatitude", type="string", example="e"),
     *
     *                 @OA\Property(property="decLongitude", type="string", example="e"),
     *                 @OA\Property(property="intDutyAutoID", type="integer", example=3),
     *                 @OA\Property(property="strLocation", type="string", example="Noakhali"),
     *                 @OA\Property(property="intContactID", type="integer", example=1),
     *                 @OA\Property(property="strContacName", type="string", example="Test Contact"),

     *              )
     *           ),
     *      operationId="storeEmployeeTrack",
     *     security={{"bearer": {}}},
     *      @OA\Response( response=200, description="Create Employee Tracking" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeEmployeeTrack(Request $request)
    {
        try {
            // $request->validate([
            //     'intEmployeeID' => 'required',
            //     'dteDate' => 'required',

            // ]);
            $data = $this->taskRepository->storeEmployeeTrack($request);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *      path="/api/v1/hr/getEmployeeDutyInfo",
     *     tags={"EmployeeTrack"},
     *     summary="getEmployeeDutyInfo",
     *     description="getEmployeeDutyInfo",
     *     operationId="getEmployeeDutyInfo",
     *     @OA\Parameter(name="intEmployeeID", example="439590", description="intEmployeeID, eg; 422906", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="ysnVisited", example="439590", description="ysnVisited, eg; 1", required=false, in="query", @OA\Schema(type="integer")),
     *    security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getEmployeeDutyInfo"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeeDutyInfo(Request $request)
    {
        try {
            $data = $this->taskRepository->getEmployeeDutyInfo($request->intEmployeeID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Duty');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\GET(
     *      path="/api/v1/hr/getEmployeePuchInfo",
     *     tags={"EmployeeTrack"},
     *     summary="getEmployeePuchInfo",
     *     description="getEmployeePuchInfo",
     *     operationId="getEmployeePuchInfo",
     *     @OA\Parameter(name="intEmployeeID", example="439590", description="intEmployeeID, eg; 422906", required=true, in="query", @OA\Schema(type="integer")),
     *    security={{"bearer": {}}},
     *     @OA\Response(response=200,description="getEmployeePuchInfo"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getEmployeePuchInfo(Request $request)
    {
        try {
            $data = $this->taskRepository->getEmployeePuchInfo($request->intEmployeeID);
            return $this->responseRepository->ResponseSuccess($data, 'Employee Duty');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/hr/creatEmployee",
     *     tags={"Tasks"},
     *     summary="Create New Employee",
     *     description="Create New Employee",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intEmployeeID", type="integer", example=1),
     *              @OA\Property(property="intEmployeeTypeID", type="integer", example=1),
     *              @OA\Property(property="strLocation", type="string", example="Location"),
     *              @OA\Property(property="decLatitude", type="integer", example=1),
     *              @OA\Property(property="decLongitude", type="integer", example=1),
     *              @OA\Property(property="ysnVisited", type="integer", example=1),
     *              @OA\Property(property="intAssignedBy", type="integer", example=1),
     *              @OA\Property(property="strRemarks", type="string", example="Address"),
     *              @OA\Property(property="intContactID", type="integer", example=1),
     *              @OA\Property(property="strContacName", type="string", example="Address"),
     *              @OA\Property(property="ysnEnable", type="integer", example=1),
     *              @OA\Property(property="created_at", type="string", example="2021-02-04"),
     *           )
     *      ),
     *      operationId="storeEmployee",
     *      security={{"bearer": {}}},
     *      @OA\Response(response=200,description="Create New Employee"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function storeEmployee(Request $request)
    {
        // return $request;
        try {
            $data = $this->taskRepository->storeEmployee($request);
            return $this->responseRepository->ResponseSuccess($data, 'New Employee Created successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
