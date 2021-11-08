<?php

namespace Modules\HR\Repositories;

use App\Helpers\DistanceCalculator;
use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use stdClass;

class HRLoginRepository
{

    // public function getSalaryStatement($intEmployeeId)
    // {
    //     $query = DB::table(config('constants.ERP_HR') . ".tblMonthlySalaryGenerate");
    //     $output = $query->select(
    //         [
    //             'tblMonthlySalaryGenerate.intEmpID',
    //             'tblMonthlySalaryGenerate.monNetPayableSalary'
    //         ]
    //     )
    //         ->where('tblMonthlySalaryGenerate.intEmpID', $intEmployeeId)
    //         ->where('tblMonthlySalaryGenerate.intMonthID', 7)
    //         ->get();

    //     return $output;
    // }

    public function getUserDataByUserEmail($employeeEmail)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployee");
        $output = $query->where('tblEmployee.strOfficeEmail',  $employeeEmail)
                    ->select(
                        'intEmployeeId',
                        'strEmployeeCode',
                        'strEmployeeName',
                        'intUnitId',
                        'intJobStationId',
                        'intJobTypeId',
                        'strOfficeEmail',
                        'strContactNo1',
                        'strPermanentAddress',
                        'strPresentAddress',
                        'strAlias',
                        'strCountry',
                        'strCity',
                        'dteBirth'
                    )->get();
        return $output;
    }

    public function getCafeteriaMenuList($intEmployeeId)
    {
        if (!is_null($intEmployeeId)) {
            $query = DB::table(config('constants.DB_HR') . ".tblEmployeeListForCafeteria")
                ->where('ysnActive', 1)
                ->where('intEnroll ', $intEmployeeId)
                ->get()
                ->count();
        }

        $query1 = DB::table(config('constants.DB_HR') . ".tblMenuListOfFoodCorner");
        $query1->select(
            [
                'tblMenuListOfFoodCorner.intAutoId as intDayOffId',
                'tblMenuListOfFoodCorner.strDayName',
                'tblMenuListOfFoodCorner.strMenu as strMenuList',
            ]
        );
        $query1->where('tblMenuListOfFoodCorner.strDayName', '!=', 'Friday');
        if ($query == 0) {
            $query1->where('tblMenuListOfFoodCorner.strStatus', 'Corporate');
        } else {
            $query1->where('tblMenuListOfFoodCorner.strStatus', 'Panthapath');
        }
        $output = $query1->get();
        $items = [];
        foreach ($output as $meal) {
            $mydate = getdate(date("U"));
            $currentDay = $mydate['weekday'];
            if ($currentDay == $meal->strDayName) {
                $testMeal = new stdClass();
                $testMeal = $meal;
                $testMeal->isToday = true;
            } else {
                $testMeal = new stdClass();
                $testMeal = $meal;
                $testMeal->isToday = false;
            }
            $items[] = $meal;
        }
        return $items;
    }

    public function getEmployeeProfileDetailsWithoutAuth($employeeEmail)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployee");
        $output = $query->where('tblEmployee.strOfficeEmail',  $employeeEmail)->first();
        return $output;
    }


    public function  getMealList($intEmployeeId, $ysnConsumed)
    {

        if ($ysnConsumed == "true") {
            $mealList = DB::select(
                DB::raw(" Select convert(varchar,dteMeal,23) as dteMeal, strNarration, sum(intCountMeal) as MealNo FROM ERP_HR.dbo.tblCafeteriaDetails
                Where datepart(mm,dteMeal) = datepart(mm,cast(Getdate() as date)) and datepart(yyyy,dteMeal) = datepart(yyyy,cast(Getdate() as date)) and
                dteMeal < cast(Getdate() as date) and intEnroll = $intEmployeeId
                Group By dteMeal, strNarration
                    ")
            );
            // ->count();
            return $mealList;
        } else {
            $mealList = DB::select(
                DB::raw("Select dteMeal, strNarration, sum(intCountMeal) as MealNo FROM ERP_HR.dbo.tblCafeteriaDetails
                Where datepart(mm,dteMeal) = datepart(mm,cast(Getdate() as date)) and datepart(yyyy,dteMeal) = datepart(yyyy,cast(Getdate() as date)) and
                dteMeal >= cast(Getdate() as date)  and intEnroll = $intEmployeeId
                Group By dteMeal, strNarration
                    ")
            );
            return $mealList;
        }
    }

    /**
     * update and approve store requisition
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function deleteMealList($request)
    {
        if (!$request->intEnroll) {
            throw new \Exception('Enroll Not Found !');
        }

        $mytime = Carbon::now();
        $currentTime = $mytime->toDateTimeString();
        $subCurrentTime = (int) substr($currentTime, 11, 2);
        $subCurrentTimeMinutes = (int) substr($currentTime, 14, 2);
        $CurrentDate = substr($currentTime, 0, 10);
        // return $CurrentDate;
        // $requestDate = substr($request->dteMeal, 8, 2);


        try {
            // get date from input and set updatable = false
            $updatable = false;

            // if date is today and time is greater than 10:00 AM, set updatable = false else true
            if ($request->dteMeal == $CurrentDate && $subCurrentTime >= 10 && $subCurrentTimeMinutes > 0) {
                $updatable = false;
            } else {
                if ($request->dteMeal < $CurrentDate) {
                    $updatable = false;
                } else {
                    $updatable = true;
                }
            }

            // if updatable true > update
            if ($updatable) {
                DB::table(config('constants.DB_HR') . ".tblCafeteriaDetails")
                    ->where('intEnroll', $request->intEnroll)
                    ->where('dteMeal', $request->dteMeal)
                    ->update(
                        [
                            'intCountMeal' => 0,
                        ]
                    );
                return true;
            } else {
                throw new \Exception('Sorry! Meal already consumed or cancellation time is over. Last time is 10:00 AM');
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getProfileByEnrollandUnitId($intUnitId)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployee");
        $output = $query->select(
            [
                'tblEmployee.intEmployeeID',
                'tblEmployee.strEmployeeCode',
                'tblEmployee.strEmployeeName',
            ]
        )
            ->where('tblEmployee.intUnitID', $intUnitId)
            ->get();
        return $output;
    }
    public function getEmployeeProfileSearch($employeeInfo)
    {

        $query = DB::table(config('constants.DB_HR') . ".tblEmployee");
        $output = $query->select(
            [
                'tblEmployee.intEmployeeID',
                'tblEmployee.strEmployeeCode',
                'tblEmployee.strEmployeeName',
            ]
        )
            ->where('tblEmployee.strEmployeeName', 'like', '%' . $employeeInfo . '%')
            ->orWhere('tblEmployee.intEmployeeID', 'like', '%' . $employeeInfo . '%')
            ->get();
        return $output;
    }


    public function getEmployeeProfileByEmail($employeeEmail)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployee");
        $output = $query->where('tblEmployee.strOfficeEmail',  $employeeEmail)->first();
        return $output;
    }

    public function getGeolocationforAllJobstation($intUnitID)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployeeJobStation as js ")
            ->leftJoin(config('constants.DB_Remote') . ".tblGeoLocationForJobstation as gj", 'js.intEmployeeJobStationId', '=', 'gj.intJobStationId');


        $output = $query->select(
            [
                'js.intEmployeeJobStationId',
                'js.strJobStationName',
                'gj.intUnitId',
                'decLatitude',
                'decLongitude',
                'intZAxis',
                'dteCreatedAt',
                'dteUpdateAt',
                'intActionBy',
                'intUpdateBy'
            ]
        )
            ->where('js.intUnitID', $intUnitID)
            ->orderBy('js.strJobStationName', 'asc')
            ->get();
        return $output;
    }

    public function getGeolocationforSingleJobstation($intEmployeeJobStationId)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployeeJobStation as js ")
            ->leftJoin(config('constants.DB_Remote') . ".tblGeoLocationForJobstation as gj", 'js.intEmployeeJobStationId', '=', 'gj.intJobStationId');


        $output = $query->select(
            [
                'js.intEmployeeJobStationId',
                'js.strJobStationName',
                'gj.intUnitId',
                'decLatitude',
                'decLongitude',
                'intZAxis',
                'dteCreatedAt',
                'dteUpdateAt',
                'intActionBy',
                'intUpdateBy'
            ]
        )
            ->where('js.intEmployeeJobStationId', $intEmployeeJobStationId)
            ->orderBy('js.strJobStationName', 'asc')
            ->first();
        return $output;
    }

    public function postGeolocationUpdateByManpower(Request $request)
    {
        // Add Single Entry in tblStoreIssue table

        try {
            DB::beginTransaction();

            // Exist in DB_Remote.tblGeoLocationForJobstation table, then update else create
            $checkData =  DB::table(config('constants.DB_Remote') . ".tblGeoLocationForJobstation")
                ->where('intJobStationId', $request->intJobStationId)
                ->first();

            if (is_null($checkData)) {
                $intPKID = DB::table(config('constants.DB_Remote') . ".tblGeoLocationForJobstation")->insertGetId(
                    [
                        'intJobStationId' => $request->intJobStationId,
                        'intUnitId' => $request->intUnitId,
                        'decLatitude' => $request->decLatitude,
                        'decLongitude' => $request->decLongitude,
                        'intZAxis' => $request->intZAxis,
                        'dteCreatedAt' => Carbon::now(),
                        'dteUpdateAt' => Carbon::now(),
                        'intUpdateBy' => $request->intUpdateBy,
                        'intActionBy' =>  $request->intUpdateBy,
                    ]
                );
            } else {
                $intPKID = DB::table(config('constants.DB_Remote') . ".tblGeoLocationForJobstation")
                    ->where('intJobStationId', $request->intJobStationId)
                    ->update(
                        [
                            'decLatitude' => $request->decLatitude,
                            'decLongitude' => $request->decLongitude,
                            'intZAxis' => $request->intZAxis,
                            'dteUpdateAt' => Carbon::now(),
                            'intUpdateBy' => $request->intUpdateBy
                        ]
                    );
            }

            DB::commit();
            return $intPKID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function postEmployeeAttendance(Request $request)
    {
        try {
            // Exist if in between 100 meter range
            // $checkData =  DB::table(config('constants.DB_Remote') . ".tblGeoLocationForJobstation")
            //     ->where('intEnroll', $request->intEnroll)
            //     ->where('dteAction', $request->dteAction)
            //     ->first();
            $response = [
                'status' => 'false',
                'distance' => 0,
                'message' => '',
            ];

            $latitude1 = $request->strCurrentLaty;
            $longitude1 = $request->strCurrentLonx;

            $jobStationData =  DB::table(config('constants.DB_Remote') . ".tblGeoLocationForJobstation")
                ->where('intJobStationId', $request->intJobStationId)
                ->first();

            if (!is_null($jobStationData)) {
                $latitude2 = $jobStationData->decLatitude;
                $longitude2 = $jobStationData->decLongitude;
                if ($latitude2 == 0 || $longitude2 == 0) {
                    return [
                        'status' => 'false',
                        'distance' => 0,
                        'message' => 'দুঃখিত, সেটিংস থেকে আপনার ম্যাপটি একটিভ করুন। আপনার লোকেশন পাওয়া যায়নি !',
                    ];
                }

                // echo ' latitude1 - ' . $latitude1;
                // echo ' longitude1 - ' . $longitude1;
                // echo ' latitude2 - ' . $latitude2;
                // echo ' longitude2 - ' . $longitude2;
                // dd();

                // Check if in 100 meters

                $checkMeter = DistanceCalculator::calculateDistance($latitude1, $longitude1, $latitude2, $longitude2, 'meter');
                $response['distance'] = $checkMeter;

                if ($checkMeter <= 100) {
                    DB::table(config('constants.DB_Remote') . ".tblAFBLGeoPunch")->insertGetId(
                        [
                            'intEnroll' => $request->intEnroll,
                            'intPoint' => $request->intPoint,
                            'intActionBy' =>  $request->intEnroll,
                            'strLocation' => "NA",
                            'strCurrentLonx' => $request->strCurrentLonx,
                            'strCurrentLaty' => $request->strCurrentLaty,
                            'strDistance' => $checkMeter,
                            'dteAction' => Carbon::now(),
                        ]
                    );

                    // Insert into attendance table also
                    $checkcountpunch =  DB::table(config('constants.DB_HR') . ".tblEmployeeAttendance")
                        ->where('intEmployeeID', $request->intEnroll)
                        ->where('dteAttendanceDate', date('Y-m-d'))
                        ->first();

                    if (is_null($checkcountpunch)) {
                        DB::table(config('constants.DB_HR') . ".tblEmployeeAttendance")->insertGetId(
                            [
                                'strEmployeeBarcode' => date('F, Y', strtotime(Carbon::now())),
                                'intEmployeeID' => $request->intEnroll,
                                'intJobStationID' => $request->intPoint,
                                'dteAttendanceDate' => date('Y-m-d'),
                                'dteAttendanceTime' => Carbon::now(),
                                'intUserID' => $request->intEnroll,
                                'strUserIP' =>  "Geo punch for Job station number => " . $request->intPoint,
                                'timeHoursLate' => Carbon::now(),
                            ]
                        );
                        $response['status'] = 'true';
                        $response['message'] = 'আপনার এটেন্ডেন্স সফলভাবে সম্পন্ন হয়েছে !';
                    } else {
                        $response['message'] = 'দুঃখিত! আপনার একবার এটেন্ডেন্স নেয়া হয়েছে !';
                    }
                } else {
                    $distance = $checkMeter >= 1000 ? $checkMeter / 1000 : $checkMeter;
                    $response['message'] = 'দুঃখিত! আপনি জব স্টেশনের রেঞ্জ থেকে ' . round($distance, 0);
                    if ($checkMeter >= 1000) {
                        $response['message'] .= ' কিলোমিটার ';
                    } else {
                        $response['message'] .= ' মিটার ';
                    }
                    $response['message'] .= 'দূরে আছেন।';
                }
            } else {
                $response['message'] = 'দুঃখিত! আপনার জব স্টেশন সেটাপ করা হয়নি !';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        $responseData = new stdClass();
        $responseData->status = $response['status'];
        $responseData->message = $response['message'];
        $responseData->distance = $response['distance'];
        return $responseData;
    }

    public function getSupervisorVsEmployeeList($intSupervisorId)
    {
        $query = DB::table(config('constants.DB_BrandTradeMkt') . ".tblTADAPermissionGlobal");


        $output = $query->select(
            [
                'intEmployeeid', 'intSupervisorId', 'intLevel', 'intUnit'
            ]
        )
            ->where('intSupervisorId', $intSupervisorId)
            ->where('intLevel', 3)
            ->orderBy('intEmployeeid', 'asc')
            ->get();
        return $output;
    }


    public function getOvertime($travelDate, $endTime)
    {
        $travelDateOnly = substr($travelDate, 0, 10);
        $overTimeStart = $travelDateOnly . ' ' . '06:00:00';
        $overTimeEnd = $travelDateOnly . ' ' . substr($endTime, 0, 8);
        $newStartformat = Carbon::parse($overTimeStart);
        $newEndformat =  Carbon::parse($overTimeEnd);
        $overTime = $newEndformat->diffInMinutes($newStartformat, true);
        // $headerOverTime = DateHelper::ConvertToHoursMins($overTime, '%02d H %02d M');
        return $overTime;
    }


    public function getManpowerOvertime($overTimeStart, $overTimeEnd)
    {

        $newStartformat = Carbon::parse($overTimeStart);
        $newEndformat =  Carbon::parse($overTimeEnd);

        $overTime = $newEndformat->diffInHours($newStartformat, true);
        // $headerOverTime = DateHelper::ConvertToHoursMins($overTime, '%02d H %02d M');
        return $overTime;
    }

    public function postOvertimeEntry(Request $request)
    {
        try {

            $response = [
                'status' => 'false',
                'distance' => 0,
                'message' => '',
            ];

            // intUnitId,dteBillDate,decStartime ,decEndtime,decMovDuration ,intHour,strNotes,intPurpouseId
            //   ,intApplicantenrol ,intInsertBy,dteInsertionDate,created_at,updated_at





            $intUnitId1 = $request->intUnitId;
            $dteBillDate1 = $request->dteBillDate;
            $intApplicantenrol1 = $request->intApplicantenrol;
            $strattime = $request->decStartime;
            $endtime = $request->decEndtime;


            $overTime = $this->getOvertime($strattime,  $endtime);

            return $overTime;

            $overTimeData =  DB::table(config('constants.DB_HR') . ".tblEmployeeTimeSheet")
                ->where('intApplicantenrol',  $intApplicantenrol1)
                ->where('dteBillDate', $dteBillDate1)
                ->first();

            if (is_null($overTimeData)) {
                $intHour = 1;


                if ($intHour > 0) {
                    DB::table(config('constants.DB_HR') . ".tblEmployeeTimeSheet")->insertGetId(
                        [
                            'intUnitId' => $request->intUnitId,
                            'dteBillDate' => $request->dteBillDate,
                            'decStartime' =>  $request->decStartime,
                            'decEndtime' =>  $request->decEndtime,
                            'decMovDuration' => $request->decMovDuration,
                            'intHour' => $request->intHour,
                            'strNotes' =>  $request->strNotes,

                            'intApplicantenrol' => $request->intApplicantenrol,
                            'intInsertBy' => $request->intApplicantenrol,

                            'dteInsertionDate' => Carbon::now(),
                        ]
                    );
                }
            } else {
                $response['message'] = 'Faill!';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        $responseData = new stdClass();
        $responseData->status = $response['status'];
        $responseData->message = $response['message'];
        $responseData->distance = $response['distance'];
        return $responseData;
    }
}
