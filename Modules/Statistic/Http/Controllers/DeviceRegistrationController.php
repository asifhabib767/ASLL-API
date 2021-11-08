<?php

namespace Modules\Statistic\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Statistic\Repositories\DeviceRegistrationRepository;

class DeviceRegistrationController extends Controller
{
    public $deviceRegistrationRepository;
    public $responseRepository;


    public function __construct(DeviceRegistrationRepository $deviceRegistrationRepository, ResponseRepository $rp)
    {
        $this->deviceRegistrationRepository = $deviceRegistrationRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/statistic/registered-device",
     *     tags={"App Device Statistics"},
     *     summary="Get Device Registration List",
     *     description="get Registered DeviceList",
     *      operationId="getRegisteredDeviceList",
     *      @OA\Parameter(name="intUnitID", description="intUnitID, eg; 4", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="getRegisteredDeviceList"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getRegisteredDeviceList(Request $request)
    {
        try {
            $data = $this->deviceRegistrationRepository->getRegisteredDeviceList($request->intUnitID);
            return $this->responseRepository->ResponseSuccess($data, 'Device Data List Who are registered !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/statistic/storeDeviceRegistration",
     *     tags={"App Device Statistics"},
     *     summary="Store Device Registration",
     *     description="storeDeviceRegistration",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intUserID", type="integer", example=1272),
     *              @OA\Property(property="intUnitID", type="integer", example=4),
     *              @OA\Property(property="ysnERPUser", type="integer", example=1),
     *              @OA\Property(property="ysnERPUserTable", type="integer", example=1),
     *              @OA\Property(property="strDeviceToken", type="string", example="8293723bkjjbdf"),
     *              @OA\Property(property="strUserEmail", type="string", example="monirul@akij.net"),
     *              @OA\Property(property="strUserName", type="string", example="monirul"),
     *              @OA\Property(property="strUserType", type="string", example="ERP User"),
     *              @OA\Property(property="app_version", type="string", example="1.2.5"),
     *           )
     *      ),
     *      operationId="storeDeviceRegistration",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="storeDeviceRegistration"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeDeviceRegistration(Request $request)
    {
        try {
            $data = $this->deviceRegistrationRepository->registerDevice($request);
            return $this->responseRepository->ResponseSuccess($data, 'Device Data Registered !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/statistic/sendDeviceNotification",
     *     tags={"App Device Statistics"},
     *     summary="Send Welcome Notification",
     *     description="Send Welcome Notification",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="send_all_device", type="integer", example=1),
     *              @OA\Property(property="device_tokens", type="string", example=""),
     *              @OA\Property(property="is_attendance_check_notification", type="integer", example=0),
     *              @OA\Property(property="notification_title", type="string", example="Welcome to Akij iApp"),
     *              @OA\Property(property="notification_body", type="string", example="Welcome to Akij iApp. Please start your task by opening Akij iApp"),
     *              @OA\Property(property="api_token", type="string", example="AkijiApp2020"),
     *           )
     *      ),
     *      operationId="sendDeviceNotification",
     *     security={{"bearer": {}}},
     *      @OA\Response(response=200,description="sendDeviceNotification"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function sendDeviceNotification(Request $request)
    {
        try {
            $data = $this->deviceRegistrationRepository->sendDeviceNotification($request);
            return $this->responseRepository->ResponseSuccess($data, 'Send Notification to the Device');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
