<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Statistic\Repositories\DeviceRegistrationRepository;

class NotificationHandler {

    public static function sendNotification()
    {
        $dRP = new DeviceRegistrationRepository();
        
        $notificationsData = NotificationHandler::getNotifiableRows();
        
        foreach ($notificationsData as $notification) {
            $request = new Request();
            $request->notification_title = $notification->notification_title;
            $request->notification_body = $notification->notification_body;
            $request->device_tokens = $notification->strDeviceToken;
            $request->notification_link = $notification->notification_link;
            $dRP->sendDeviceNotification($request);

            // Update in notification table also that sent notification
            DB::table(config('constants.ERP_Apps') . ".tblNotification")
            ->where('intID', $notification->intID)->update([
                'ysnSMSSent' => 1,
                'dteSendDate' => Carbon::now(),
                'strStatus' => 'Sent',
            ]);
        }
    }

    public static function getNotifiableRows()
    {
        $notifiableRows = DB::table(config('constants.ERP_Apps') . ".tblNotification")
        ->join(config('constants.ERP_Apps') . ".tblAppDeviceRegistration", function($join)
        {
            $join->on('tblAppDeviceRegistration.intUserID', '=', 'tblNotification.intUserID');
            $join->on('tblAppDeviceRegistration.strUserType', '=', 'tblNotification.strUserType');
        })
        ->select(
            'tblNotification.intID', 
            'tblNotification.intUserID', 
            'tblNotification.strUserType', 
            'tblNotification.strSMS as notification_title', 
            'tblNotification.strMessage as notification_body', 
            'tblNotification.strDeepLink as notification_link',
            'tblAppDeviceRegistration.strDeviceToken'
        )
        ->where('ysnSMSSent', '!=', 1)
        ->get();

        return $notifiableRows;
    }
}