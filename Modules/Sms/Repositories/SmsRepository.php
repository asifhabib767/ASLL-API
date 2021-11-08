<?php

namespace Modules\Sms\Repositories;

use App\Helpers\DistanceCalculator;
use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use stdClass;

class SmsRepository
{
    public function SmsSend(Request $request)
    {



        try {

// return 11;

            $strPhoneNo = $request->phoneNo;
            $strSMS =$request->message;
            $masking = $request->masking;
            $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=akijgroupadmin-abfd7bb4-2148-4ecd-81f8-295522b001f8&sid=".$masking."&sms=" .$strSMS. "&msisdn=" .$strPhoneNo."&csms_id=4473433434pZ684333392";
            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // grab URL and pass it to the browser
            curl_exec($ch);

            // close cURL resource, and free up system resources
            curl_close($ch);
            return true;

            // DB::table(config('constants.DB_AFBLSMSServer') . ".tblAPIsms")->insertGetId(
            //     [
            //         'strPhoneNo' => $request->strPhoneNo,
            //         'strMessage' => 'Hello AFML',
            //         'strSMS' => 'Challan Info',
            //         'dteInsertDate' => Carbon::now(),
            //         'dteSendDate' => Carbon::now(),
            //         'strStatus' => 'Success',
            //         'intUnitID' => 53
            //     ]
            // );

            // $response['message'] = 'Sucessfully complete';
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        $responseData = new stdClass();

        $responseData->message = $response['message'];

        return $responseData;
    }





    public function GetFGItemListForAFML()
    {
       $strType='Finish Goods';

        $query = DB::table(config('constants.DB_SAD') . ".tblItem as i ")
            ->leftJoin(config('constants.DB_SAD') . ".tblItemType as it", 'i.intTypeID', '=', 'it.intID');
        $output = $query->select(
            [
                'i.strProductName AS ProductName', 'i.strProductName AS Code','i.intID AS intProductId', 'i.intUnitID'
            ]
        )
            ->where('i.ysnActive', true)
            ->where('it.strType',  $strType)
            ->where('i.intUnitID', 53)
            ->get();
        return $output;
    }
    public function GetCustomerForAFML()
    {

        $query = DB::table(config('constants.DB_SAD') . ".TBLCUSTOMER");



        $output = $query->select(
            [
                'strName as CustomerName','strCustomerCode as Code','strAddress as Address','strPhone as MobileNo'
            ]
        )
            ->where('intUnitID', 53)
            ->where('ysnCustActive',  true)


            ->get();
        return $output;
    }

    public function GetPendingItemByCustomerForAFML()
    {

        $output = DB::table(config('constants.DB_SAD') . ".tblSalesOrder AS o")
        ->Join(config('constants.DB_SAD') . ".tblSalesOrderDetails AS od", 'o.intId', '=', 'od.intSOId')
        ->Join(config('constants.DB_SAD') . ".tblItem AS i", 'od.intProductId', '=', 'i.intID')
        ->select([
            'o.intCustomerId AS CustomerID', 'i.strProductName AS ProductName', 'o.intUnitId AS UnitId', 'od.intProductId AS ProductId',
            // DB::raw('SUM(od.numRestQuantity) AS PendingQuantity'),
            DB::raw(' SUM(CASE WHEN od.numRestQuantity IS NULL THEN 0 ELSE od.numRestQuantity END)  AS PendingQuantity'),

        ])
      ->groupBy('o.intCustomerId', 'i.strProductName', 'o.intUnitId', 'od.intProductId')
      ->where('o.ysnEnable', true)
      ->where('o.intUnitId', 53)
      ->where('od.numRestQuantity', '>', 0)
      ->get();
      return $output;



    // $output = $query->select(
    //     [
    //         'o.intCustomerId AS CustomerID', 'i.strProductName AS ProductName', 'SUM(od.numRestQuantity) AS PendingQuantity', 'o.intUnitId AS UnitId', 'od.intProductId AS ProductId'
    //     ]
    // )
    //     ->where('o.ysnEnable', true)
    //     ->where('o.intUnitId', 53)
    //     ->where('od.numRestQuantity',' >', 0)


    //     ->get();

    }



    public function SmsSendByITDept(Request $request)
    {



        try {


            $strPhoneNo = $request->phoneNo;
            $strSMS =$request->message;
            $masking = $request->masking;
            $url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=akijgroupadmin-abfd7bb4-2148-4ecd-81f8-295522b001f8&sid=".$masking."&sms=" .$strSMS. "&msisdn=" .$strPhoneNo."&csms_id=4473433434pZ684333392";
            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // grab URL and pass it to the browser
            curl_exec($ch);

            // close cURL resource, and free up system resources
            curl_close($ch);
            return true;

            // DB::table(config('constants.DB_AFBLSMSServer') . ".tblAPIsms")->insertGetId(
            //     [
            //         'strPhoneNo' => $request->strPhoneNo,
            //         'strMessage' => 'Hello AFML',
            //         'strSMS' => 'Challan Info',
            //         'dteInsertDate' => Carbon::now(),
            //         'dteSendDate' => Carbon::now(),
            //         'strStatus' => 'Success',
            //         'intUnitID' => 53
            //     ]
            // );

            // $response['message'] = 'Sucessfully complete';
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        $responseData = new stdClass();

        $responseData->message = $response['message'];

        return $responseData;
    }


}
