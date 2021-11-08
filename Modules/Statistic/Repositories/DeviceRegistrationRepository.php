<?php

namespace Modules\Statistic\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceRegistrationRepository
{

    public function getRegisteredDeviceList($intUnitID = null)
    {
        try {
            $query = DB::table(config('constants.DB_Apps') . ".tblAppDeviceRegistration");

            if (!is_null($intUnitID)) {
                $query->where('intUnitID', $intUnitID);
            }

            $data = $query->get();
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Register Device By getting Device token
     *
     * @param Request $request
     * @return void
     */
    public function registerDevice(Request $request)
    {
        try {
            // Check if already an entry for this user in this table and token
            $firstEntry = DB::table(config('constants.DB_Apps') . ".tblAppDeviceRegistration")
                ->where('intUserID', $request->intUserID)
                ->where('intUnitID', $request->intUnitID)
                ->where('strUserType', $request->strUserType)
                ->first();

            if (is_null($firstEntry)) {
                $intAutoID = DB::table(config('constants.DB_Apps') . ".tblAppDeviceRegistration")
                    ->insertGetId([
                        'strDeviceToken' => $request->strDeviceToken,
                        'intUnitID' => $request->intUnitID,
                        'intUserID' => $request->intUserID,
                        'ysnERPUser' => $request->ysnERPUser,
                        'ysnERPUserTable' => $request->ysnERPUserTable,
                        'strUserEmail' => $request->strUserEmail,
                        'strUserName' => $request->strUserName,
                        'strUserType' => $request->strUserType,
                        'app_version' => $request->app_version,
                        'dteCreatedAt' => Carbon::now(),
                        'dteUpdatedAt' => null
                    ]);
            } else { // Update the data with new device token
                $intAutoID =  DB::table(config('constants.DB_Apps') . ".tblAppDeviceRegistration")
                    ->where('intUserID', $request->intUserID)
                    ->where('intUnitID', $request->intUnitID)
                    ->where('strUserType', $request->strUserType)
                    ->update([
                        'strDeviceToken' => $request->strDeviceToken,
                        'ysnERPUser' => $request->ysnERPUser ? $request->ysnERPUser : $firstEntry->ysnERPUser,
                        'ysnERPUserTable' => $request->ysnERPUserTable ? $request->ysnERPUserTable : $firstEntry->ysnERPUserTable,
                        'strUserEmail' => $request->strUserEmail ? $request->strUserEmail : $firstEntry->strUserEmail,
                        'strUserName' => $request->strUserName ? $request->strUserName : $firstEntry->strUserName,
                        'strUserType' => $request->strUserType ? $request->strUserType : $firstEntry->strUserType,
                        'app_version' => $request->app_version ? $request->app_version : $firstEntry->app_version,
                        'dteUpdatedAt' => Carbon::now()
                    ]);
            }
            return $intAutoID;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function sendDeviceNotification($request)
    {

        try {
            $devices = [];
            $user_ids = [];
            $notification_title = $request->notification_title;
            $notification_body =  $request->notification_body;
            $notification_link =  $request->notification_link;
            $notification_image = "";
            if ($request->api_token === "AkijiApp2020") {

                if ($request->send_all_device == 1) {
                    foreach ($this->getRegisteredDeviceList() as $device) {
                        array_push($devices, $device->strDeviceToken);
                        array_push($user_ids, $device->intUserID);
                    }
                } else {
                    // Get Device Token List
                    if ($request->device_tokens !== "") {
                        $devices = explode(", ", $request->device_tokens);
                    }
                }


                if ($request->is_attendance_check_notification == 1) {
                    // Check the employees attendance history if there is an entry
                    $devices = [];
                    foreach ($this->getRegisteredDeviceList() as $device) {
                        $attendanceData = DB::table(config('constants.DB_HR') . ".tblEmployeeAttendance")
                            ->where('dteAttendanceDate', date('Y-m-d'))
                            ->where('intEmployeeID', $device->intUserID)
                            ->first();
                        if (is_null($attendanceData)) {
                            array_push($devices, $device->strDeviceToken);
                        }
                    }

                    $notification_title = $request->notification_title;
                    $notification_body =  $request->notification_body;
                }

                $devices = json_encode($devices);
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://fcm.googleapis.com/fcm/send?Authorization=key%3DAAAAPnloUa8%3AAPA91bHoM4qpXZ3lzWuQcFdpGUC8Xf1O-71XFOIVeduQVIw7Yczj68NHsh3Dfl5nyMvav9MB5z16AZKW91aFMQRDzckpCDBeccMny-B2wrk91jwKgnfMzc_FJnpVCkwKfc3n800tx3e2&Content-Type=application%2Fjson",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 300,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\r\n\"registration_ids\":
                    $devices
                    \"notification\" : {\r\n
                        \"body\" : \"$notification_body\",\r\n
                        \"title\": \"$notification_title\"\r\n
                    },\r\n
                    \"data\" : {\r\n
                        \"body\" : \"$notification_body\",\r\n
                        \"title\": \"$notification_title\",\r\n
                    }\r\n
                }",
                    CURLOPT_HTTPHEADER => array(
                        "authorization: key=AAAAPnloUa8:APA91bHoM4qpXZ3lzWuQcFdpGUC8Xf1O-71XFOIVeduQVIw7Yczj68NHsh3Dfl5nyMvav9MB5z16AZKW91aFMQRDzckpCDBeccMny-B2wrk91jwKgnfMzc_FJnpVCkwKfc3n800tx3e2",
                        "cache-control: no-cache",
                        "content-type: application/json",
                        "postman-token: d3db4509-57f7-4b6c-179c-272a694c2397"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err) {
                    return "cURL Error #:" . $err;
                } else {
                    return json_decode($response);
                }
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
