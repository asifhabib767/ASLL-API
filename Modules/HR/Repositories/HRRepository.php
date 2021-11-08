<?php

namespace Modules\HR\Repositories;

use App\Helpers\DistanceCalculator;
use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Modules\HR\Repositories\LogRepository;
use Carbon\Carbon;
use stdClass;

class HRRepository
{
    public function __construct(LogRepository $logReporsitory)
    {
        $this->logReporsitory = $logReporsitory;
    }

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

    public function getSalaryStatement($intEmployeeId)
    {
        $date = null;
        if ($date == null) {
            $date = Carbon::now();
        }
        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');
        $intYear = (int) $year;
        $intMonth = (int) $month;
        if ($intMonth == 1) {
            $intYear = $intYear - 1;
        }
        $query = DB::table(config('constants.DB_HR') . ".tblMonthlySalaryGenerate");
        $output = $query->select(
            [
                'tblMonthlySalaryGenerate.intEmpID',
                'tblMonthlySalaryGenerate.intWorkingDays',
                'tblMonthlySalaryGenerate.intOffDay',
                'tblMonthlySalaryGenerate.intHoliday',
                'tblMonthlySalaryGenerate.intPresent',
                'tblMonthlySalaryGenerate.intAbsent',
                'tblMonthlySalaryGenerate.intCL',
                'tblMonthlySalaryGenerate.intSL',
                'tblMonthlySalaryGenerate.intEL',
                'tblMonthlySalaryGenerate.intML',
                'tblMonthlySalaryGenerate.intPL',
                'tblMonthlySalaryGenerate.intBL',
                'tblMonthlySalaryGenerate.intLWP',
                'tblMonthlySalaryGenerate.intLate',
                'tblMonthlySalaryGenerate.monNetPayableSalary',
                'tblMonthlySalaryGenerate.monAbsentPunishmentAmount',
                'tblMonthlySalaryGenerate.monLeavePunishmentAmount',
                'tblMonthlySalaryGenerate.monLatePunishmentAmount',
            ]
        )
            ->where('tblMonthlySalaryGenerate.intEmpID', $intEmployeeId)
            ->where('tblMonthlySalaryGenerate.intYearID', $intYear)
            ->where('tblMonthlySalaryGenerate.intMonthID', $intMonth - 1)
            ->first();
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





            $empCode = $request->empCode;
            $intLeaveTypeID = $request->intLeaveTypeID;
            $dateAppliedFrom = $request->dateAppliedFrom;
            $dateAppliedTo = $request->dateAppliedTo;
            $tmStart = $request->tmStart;

            $tmEnd = $request->tmEnd;
            $strLeaveReason = $request->strLeaveReason;
            $strAddressDuetoLeave = $request->strAddressDuetoLeave;
            $strphoneDuetoLeave = $request->strphoneDuetoLeave;
            $intAppliedBy = $request->intAppliedBy;



            $overTime = $this->getOvertime($starttime,  $endTime);

            return $overTime;

            $overTimeData =  DB::table(config('constants.DB_HR') . ".tblEmployeeTimeSheet")
                ->where('intApplicantenrol',  $dateAppliedFrom)
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

    public function gettAttenanceDailySummaryReport($intEmployeeId, $MonthNum, $Year)
    {
        $ItemList = DB::select(
            DB::raw("SELECT  * FROM ERP_HR.dbo.funReportAttenanceDailySummaryReportCalanderViewAPI ( $intEmployeeId, $MonthNum,$Year)")

        );



        return $ItemList;
    }


    public function getLeaveApplicationSummaryByUser($intEmployeeId)
    {
        // 'srtApprovedStatus'=
        // Case When app.srtApprovedStatus = 'Y' Then 'Approved' When app.srtApprovedStatus = 'R' Then 'Rejected'
        // Else 'Pending' End



        $query = DB::table(config('constants.DB_HR') . ".tblLeaveApplication as app")
            ->Join(config('constants.DB_HR') . ".tblLeaveTypeSetup as leaveType", 'app.intLeaveTypeID', '=', 'leaveType.intLeaveTypeID');


        $output = $query->select(
            [
                'app.intApplicationId', 'leaveType.intLeaveTypeID', 'leaveType.strLeaveType', 'app.dateApplicationDate', 'app.dateAppliedFromDate',
                'app.dateAppliedToDate', 'app.strLeaveReason', 'app.strAddressDuetoLeave', 'app.strphoneDuetoLeave', 'app.srtApprovedStatus'
            ]
        )

            ->where('app.intEmployeeID', $intEmployeeId)
            // ->where('YEAR(app.dateApplicationDate)',$(YEAR(Carbon::now()))
            ->orderBy('app.intApplicationId', 'desc')
            ->get();
        return $output;
    }


    public function getLeaveApplicationTypeByUser($intEmployeeId)
    {
        // OR (leaveType.strApplicableFor =
        // (Select tblEmployee.strGender from tblEmployee where tblEmployee.intEmployeeID = @intEmployeeId)))
        // union
        // SELECT intLeaveTypeID, strLeaveType, intMaximumAllowedAt_A_Time FROM tblLeaveTypeSetup where intLeaveTypeID=8

        $leavetype = 'B';
        $intJobTypeId = 1;
        $intJobStationID = 4;

        // $query = DB::table(config('constants.DB_HR') . ".tblEmployeeGroupPermissionLeave as PerLeave")
        // ->Join(config('constants.DB_HR') . ".tblLeaveTypeSetup as leaveType",'PerLeave.intLeaveTypeID', '=', 'leaveType.intLeaveTypeID');

        // $output = $query->select(
        //     [
        //         'PerLeave.intLeaveTypeID','leaveType.strLeaveType','leaveType.intMaximumAllowedAt_A_Time'
        //     ]

        // ->where('PerLeave.intGroupID',$intEmployeeId)
        // ->where('PerLeave.intJobTypeId',$intJobTypeId)
        // ->where('PerLeave.intJobStationID',$intJobStationID)
        // ->where('leaveType.strApplicableFor', $leavetype)



        $query = DB::table(config('constants.DB_HR') . ".tblLeaveTypeSetup as leaveType");


        $output = $query->select(
            [
                'intLeaveTypeID', 'strLeaveType', 'intMaximumAllowedAt_A_Time', 'ysnBalanceCheck'
            ]
        )

            // ->where('PerLeave.intGroupID',$intEmployeeId)
            ->where('leaveType.intLeaveTypeID', '!=', 9)


            ->get();
        return $output;
    }


    /**
     * Delete Leave Application
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function DeleteLeaveApplication($request)
    {

        // return $request->intApplicationId;
        // if not exists(select * from tblLeaveApplication Where intApplicationId=@intApplicationID and( ysnApproved=1 or ysnRejected=1))

        $checkdata =  DB::table(config('constants.DB_HR') . ".tblLeaveApplication")
            ->where('intApplicationId', $request->intApplicationId)
            // ->where('ysnApproved', 1)
            // ->orWhere('ysnRejected', 1)

            ->first();

        // Delete From tblLeaveApplication Where intApplicationId=@intApplicationID

        // return $checkdata->srtApprovedStatus;

        if ($checkdata->srtApprovedStatus = "N") {

            // return "here N";

            DB::table(config('constants.DB_HR') . ".tblLeaveApplication")->where('intApplicationId', $request->intApplicationId)->delete();


            DB::table(config('constants.DB_HR') . ".tblHRDataHistory")->insertGetId(
                [
                    'strAction' => 'Delete',
                    'strDescription' => 'Deleted Sucessfully',
                    'strTblName' => 'tblHRDataHistory',
                    'dteDate' =>   Carbon::now(),
                    'intUserID' => $request->intApplicationId,

                ]
            );
        }
    }

    public function getMovementApplicationSummaryByUser($intEmpID)
    {

        // return $intEmpID;

        // $query = DB::table(config('constants.DB_HR') . ".tblofficialMovement as mov")
        //     ->Join(config('constants.DB_HR') . ".tblofficialMovementType as movtype", 'mov.intMoveTypeID', '=', 'movtype.intMoveTypeID')
        //     ->Join(config('constants.DB_HR') . ".tblCountry as coun", 'mov.intCountryID', '=', 'coun.intCountryID')
        //     ->Join(config('constants.DB_HR') . ".tblDistrict as dist", 'mov.intDistrictID', '=', 'dist.intDistrictID');

        // $output = $query->select(
        //     [
        //         'coun.intCountryID as intCountryID', 'dist.intDistrictID as intDistrictID', 'mov.intId as intId', 'movtype.strMoveType as strMoveType', 'mov.dteAppliedTime as dteAppliedTime', 'mov.dteStartTime as strMoveType', 'mov.dteEndTime as dteEndTime',
        //         'mov.strReason as strReason', 'mov.strAddress as strAddress'
        //         , DB::raw('(CASE WHEN mov.ysnApproved= 1 THEN "Approved"
        //         WHEN mov.ysnRejected= 1 THEN "Rejected"


        //         ELSE "Pending" END) AS srtStatus')

        //     ]
        // )

        //     ->where('mov.intEmpID', $intEmpID)
        //     ->whereBetween('mov.dteStartTime', [
        //         Carbon::now()->startOfYear(),
        //         Carbon::now()->endOfYear(),
        //     ])
        //     ->orderBy('mov.intId', 'desc')
        //     ->get();
        // return $output;
        // Order by mov.intId desc
        $output = DB::select(
            DB::raw("Select coun.intCountryID, dist.intDistrictID, mov.intId, movtype.strMoveType, cast (mov.dteAppliedTime as date) as dteAppliedTime, mov.dteStartTime, mov.dteEndTime,
            mov.strReason, mov.strAddress, 'srtStatus'= Case When mov.ysnApproved = 1 Then 'Approved'
            When mov.ysnRejected = 1 Then 'Rejected' Else 'Pending' End
            From ERP_HR.dbo.tblofficialMovement mov inner join ERP_HR.dbo.tblofficialMovementType movtype on mov.intMoveTypeID=movtype.intMoveTypeID
            inner join ERP_HR.dbo.tblCountry coun on mov.intCountryID=coun.intCountryID
            inner join ERP_HR.dbo.tblDistrict dist on mov.intDistrictID=dist.intDistrictID
            Where mov.intEmpID=$intEmpID and (Year(Getdate()) Between year(mov.dteStartTime) and  Year(mov.dteEndTime))
            Order by mov.intId desc")
        );


        return $output;





    }
    public function postLeaveApplication(Request $request)
    {
        $intEmployeeID = $request->intEmployeeID;
        $EmployeeInfo = $this->getEmployeeInformation($intEmployeeID);
        $data = null;
        if (!is_null($EmployeeInfo)) {
            $data = $this->getCheckMovementLeaveHolidayOffday($request, $EmployeeInfo);


            if (!$data['ysnMovement'] || !$data['ysnLeave'] || !$data['ysnHoliday'] || !$data['ysnOffday']) {

                $dataLeaveExistency = $this->getCheckLeaveExistency($request, $EmployeeInfo);

           // return  $dataLeaveExistency;
                if ($dataLeaveExistency['ysnValidStrategy'] == '1') {
                    $joingdate = $request->dteJoiningDate;
                    $dateAppliedFrom = $request->dateAppliedFrom;
                    $dateAppliedTo = $request->dateAppliedTo;
                    if ($request->intLeaveTypeID == 7) {

                        $dateAppliedTo = DB::select(
                            DB::raw("select case when cast(dateadd(year,3,DATEADD(DAY,-1,$joingdate)) as date)<=CAST( CAST(DATEPART(year,dateadd(year,-1,getdate())) AS VARCHAR(4)) + RIGHT('0' + CAST(12 AS VARCHAR(2)), 2) + RIGHT('0' + CAST(31 AS VARCHAR(2)), 2) AS DATE) Then
                    cast( DATEADD(day,9,$dateAppliedFrom) as date)
                    when cast(dateadd(year,2,DATEADD(DAY,-1,$joingdate)) as date)<=CAST( CAST(DATEPART(year,dateadd(year,-1,getdate())) AS VARCHAR(4)) + RIGHT('0' + CAST(12 AS VARCHAR(2)), 2) + RIGHT('0' + CAST(31 AS VARCHAR(2)), 2) AS DATE) Then
                    cast( DATEADD(day,6,$dateAppliedFrom) as date)
                    when cast(dateadd(year,1,DATEADD(DAY,-1,$joingdate)) as date)<=CAST( CAST(DATEPART(year,dateadd(year,-1,getdate())) AS VARCHAR(4)) + RIGHT('0' + CAST(12 AS VARCHAR(2)), 2) + RIGHT('0' + CAST(31 AS VARCHAR(2)), 2) AS DATE) Then
                    cast( DATEADD(day,4,$dateAppliedFrom) as date)
                    END")
                        );
                    }
                    //   return $dateAppliedTo;
                    if (!is_null($dateAppliedTo) &&  !is_null($dateAppliedFrom)) {
                        $intLeaveID =   DB::table(config('constants.DB_HR') . ".tblLeaveApplication")->insertGetId(
                            [
                                'intLeaveTypeID' => $request->intLeaveTypeID,
                                'intEmployeeID' => $request->intEmployeeID,
                                'dateApplicationDate' => Carbon::now(),
                                'dateAppliedFromDate' => $dateAppliedFrom,
                                'dateAppliedToDate' => $dateAppliedTo,
                                'strLeaveReason' => $request->strLeaveReason,
                                'strAddressDuetoLeave' => $request->strAddressDuetoLeave,
                                'strphoneDuetoLeave' => $request->strphoneDuetoLeave,
                                'srtApprovedStatus' => 'N',
                                'intActionBy' => $request->intAppliedBy,
                                'dteAction' => Carbon::now(),
                                'tmStart' => $request->tmStart,
                                'tmEnd' => $request->tmEnd

                            ]
                        );
                    }
                    if ($intLeaveID > 0) {

                        DB::table(config('constants.DB_HR') . ".tblHRDataHistory")->insertGetId(
                            [
                                'strAction' => 'Insert',
                                'strDescription' => 'Leave Application Data For' . " " . $intLeaveID,
                                'strTblName' => 'tblLeaveApplication',
                                'dteDate' =>   Carbon::now(),
                                'intUserID' => $request->intEmployeeID,

                            ]
                        );
                    }
                    return $intLeaveID;
                } else {
                   // return '1900-00-00';

                   return $data=$dataLeaveExistency;
                }
            } else {
            }
        }

        return $data;
    }


    public function getEmployeeInformation($intEmployeeID)
    {
        $query = DB::table(config('constants.DB_HR') . ".tblEmployee as empl");
        $output = $query->select(['intEmployeeID', 'dteJoiningDate', 'intGroupID', 'intJobTypeId', 'intJobStationID'])
            ->where('empl.intEmployeeID', $intEmployeeID)
            ->first();
        return $output;
    }

    // @dteDuty Date, @intGroupID int,@intJobTypeID int,@intJobStationId int,@intEmployeeID int
    public function getCheckMovementLeaveHolidayOffday($request, $EmployeeInfo)
    {
        $dteDutyFrom = $request->dateAppliedFrom;
        $dteDutyTo = $request->dateAppliedTo;
        $intGroupID = $EmployeeInfo->intGroupID;
        $intJobTypeId = $EmployeeInfo->intJobTypeId;
        $intJobStationID = $EmployeeInfo->intJobStationID;
        $intEmployeeID = $EmployeeInfo->intEmployeeID;

        $data = [
            'ysnMovement' => false,
            'ysnLeave' => false,
            'ysnHoliday' => false,
            'ysnOffday' => false
        ];




        if (DB::table(config('constants.DB_HR') . ".tblOfficialMovement as mov")
            ->where('intEmpID', $intEmployeeID)
            // ->whereDate('dteAppliedTime', '<', $dteDutyFrom)
            ->whereDate('dteStartTime', '>=', $dteDutyFrom)
            ->whereDate('dteEndTime', '<=', $dteDutyTo)
            ->exists()
        ) {
            $data['ysnMovement'] = true;
        } else {
            $data['ysnMovement'] = false;
        }





        if (DB::table(config('constants.DB_HR') . ".tblLeaveApplication as mov")
            ->where('intEmployeeID', $intEmployeeID)
            ->where('ysnApproved', true)
            ->whereDate('dateApprovedFromDate', '>=', $dteDutyFrom)
            ->whereDate('dateApprovedFromDate', '<=', $dteDutyTo)
            ->exists()
        ) {
            $data['ysnLeave'] = true;
        } else {
            $data['ysnLeave'] = false;
        }

        if (DB::table(config('constants.DB_HR') . ".tblLeaveApplication as mov")
            ->where('intEmployeeID', $intEmployeeID)

            ->whereDate('dateAppliedFromDate', '>=', $dteDutyFrom)
            ->whereDate('dateAppliedToDate', '<=', $dteDutyTo)
            ->exists()
        ) {
            $data['ysnLeave'] = true;
        } else {
            $data['ysnLeave'] = false;
        }






        if (DB::table(config('constants.DB_HR') . ".tblEmployeeGroupPermissionHolidays as mov")
            ->where('intGroupID', $intGroupID)
            ->where('intJobTypeId', $intJobTypeId)
            ->where('intJobStationID', $intJobStationID)
            ->whereBetween('dteFromDate', [$dteDutyFrom, $dteDutyTo])

            ->exists()
        ) {
            $data['ysnHoliday'] = true;
        } else {
            $data['ysnHoliday'] = false;
        }



        $getOffDayIDs = DB::table(config('constants.DB_HR') . ".tblEmployeeOffDay")
            ->where('intEmployeeID', $intEmployeeID)
            ->select('intDayOffId')
            ->get();

        // return  $getOffDayIDs;

        $getOffDayIDsArray = [];
        foreach ($getOffDayIDs as $val) {
            array_push($getOffDayIDsArray, $val->intDayOffId);
        }
        $startDayWeek = (int) Carbon::parse($dteDutyFrom)->dayOfWeek + 1;
        $endDayWeek = (int) Carbon::parse($dteDutyTo)->dayOfWeek + 1;

        if (in_array($startDayWeek, $getOffDayIDsArray) || in_array($endDayWeek, $getOffDayIDsArray)) {
            $data['ysnOffday'] = true;
        } else {
            $data['ysnOffday'] = false;
        }


        if (DB::table(config('constants.DB_HR') . ".tblEmployee as empl")
            ->where('intEmployeeID', $intEmployeeID)
            // ->where('intDayOffID', $intJobTypeId)
            ->exists()
        ) {
            $data['ysnOffday'] = true;
        } else {
            $data['ysnOffday'] = false;
        }
        return $data;
    }

    public function getCheckLeaveExistency($request, $EmployeeInfo)
    {
        $intEmployeeID = $EmployeeInfo->intEmployeeID;
        $intLeaveTypeID = $request->intLeaveTypeID;
        $dteDutyFrom = $request->dateAppliedFrom;
        $dteDutyTo = $request->dateAppliedTo;
        $intAppliedBy = $request->intAppliedBy;



        $data = [
            'ysnValidStrategy' => 'Na',
        ];

        $intMaxAllowedAtaTime = DB::table(config('constants.DB_HR') . ".tblLeaveTypeSetup");
        $intMaximumAllowedAt_A_Time = $intMaxAllowedAtaTime->select(
            [
                'intMaximumAllowedAt_A_Time'
            ]
        )
            ->where('intLeaveTypeID', $intLeaveTypeID)
            ->value('intMaximumAllowedAt_A_Time');

        // return  $intMaximumAllowedAt_A_Time;

        $dteDutyFrom1 = Carbon::parse($request->input('$dteDutyFrom'));
        $dteDutyTo1 = Carbon::parse($request->input('$dteDutyTo'));

        $intAppliedDays = $dteDutyFrom1->diffInDays($dteDutyTo1);
        $intAppliedDays = $intAppliedDays + 1;
        $RemainingDaysQuery = DB::table(config('constants.DB_HR') . ".tblLeaveBalance");
        $intRemainingDays = $RemainingDaysQuery->select(['intRemainingDays'])
            ->where('intEmployeeID',  $intEmployeeID)
            ->where('intLeaveTypeId',  $intLeaveTypeID)
            ->value('intRemainingDays');
        // return $intLeaveTypeID;

        if ($intLeaveTypeID == 1 || $intLeaveTypeID == 4 || $intLeaveTypeID == 9) {

            if (DB::table(config('constants.DB_HR') . ".tblLeaveApplication")
                // ->where('intLeaveTypeID', $intLeaveTypeID)
                ->where('intEmployeeID', $intEmployeeID)
                ->where('dateAppliedFromDate', '>=', $dteDutyFrom)
                ->where('dateAppliedToDate', '<=', $dteDutyTo)
                ->exists()
            ) {

                $data['ysnValidStrategy'] = false;
            } else {
                $data['ysnValidStrategy'] = true;
            }

            if ($data['ysnValidStrategy'] == true) {


                if ($intRemainingDays >= $intAppliedDays) {

                    if ($intAppliedDays <=   $intMaximumAllowedAt_A_Time) {
                        if ($intEmployeeID == $intAppliedBy && $intLeaveTypeID == 1) {

                            $data['ysnValidStrategy'] = 'You are not allowed for this leave.';
                        } else {
                            $data['ysnValidStrategy'] = '1';
                        }
                    } else if ($intLeaveTypeID = 9 &&  in_array($intAppliedBy, [3592, 3591, 189116])) {
                        if ($intAppliedDays <= $intMaximumAllowedAt_A_Time) {
                            $data['ysnValidStrategy'] = '1';
                        } else {
                            $data['ysnValidStrategy'] = 'Maximum  allowed days is less than applied days.';
                        }
                    } else {
                        $data['ysnValidStrategy'] = 'Sorry you have no leave balance.';
                    }
                } else {
                    $data['ysnValidStrategy'] = 'Sorry you have no leave balance111.';
                }
            }
        } else if ($intLeaveTypeID == 2) { // Check Leave Type Strategy For CL (2)


            if (DB::table(config('constants.DB_HR') . ".tblLeaveApplication")
                // ->where('intLeaveTypeID', $intLeaveTypeID)
                ->where('intEmployeeID', $intEmployeeID)
                ->where('dateAppliedFromDate', '>=', $dteDutyFrom)
                ->where('dateAppliedToDate', '<=', $dteDutyTo)
                ->exists()
            ) {

                $data['ysnValidStrategy'] = false;
            } else {
                $data['ysnValidStrategy'] = true;
            }

            // return $data;

            if ($data['ysnValidStrategy'] == true) {
                $balanceDays = 1; // query
                if ($intRemainingDays >= $intAppliedDays) {
                    $BalanceDaysQuery = DB::table(config('constants.DB_HR') . ".tblLeaveBalance");
                    $intBalanceDays = $BalanceDaysQuery->select(['intBalanceDays'])
                        ->where('intEmployeeID',  $intEmployeeID)
                        ->where('intLeaveTypeId',  $intLeaveTypeID)
                        ->value('intBalanceDays');

                    //  $getdates = Carbon::parse(Carbon::now());

                    $getdates = Carbon::now()->format('Y-m-d');


                    if ($intBalanceDays != 0) {
                        if ($intAppliedDays <= $intMaximumAllowedAt_A_Time) {

                            if ($intEmployeeID == $intAppliedBy && $dteDutyFrom < $getdates) {

                                $data['ysnValidStrategy'] = 'Sorry! This application is back-dated!';
                            } else {
                                $data['ysnValidStrategy'] = '1';
                            }
                        }
                    } else {
                        $data['ysnValidStrategy'] = 'Sorry, You can take casual leave single time at a month.';
                    }
                } else {
                    $data['ysnValidStrategy'] = 'Sorry you have no leave balance111.';
                }
            }

            return $data;
        } else if ($intLeaveTypeID == 5  || $intLeaveTypeID == 6) {

            if (DB::table(config('constants.DB_HR') . ".tblLeaveApplication")
                // ->where('intLeaveTypeID', $intLeaveTypeID)
                ->where('intEmployeeID', $intEmployeeID)
                ->where('dateAppliedFromDate', '>=', $dteDutyFrom)
                ->where('dateAppliedToDate', '<=', $dteDutyTo)
                ->exists()
            ) {

                $data['ysnValidStrategy'] = false;
            } else {
                $data['ysnValidStrategy'] = true;
            }

            if ($data['ysnValidStrategy'] == true) {

                if ($intAppliedDays <= $intMaximumAllowedAt_A_Time) {
                    $data['ysnValidStrategy'] = '1';
                    if ($intEmployeeID = $intAppliedBy && $intLeaveTypeID == 5) {

                        $data['ysnValidStrategy'] = 'You are not allowed for this leave.';
                    }
                } else {
                    $data['ysnValidStrategy'] = 'Maximum allowed day is less than applied days.';
                }


                return $data;
            }
        } else if ($intLeaveTypeID == 3) { // Check Leave Type Strategy For ML (3)


            if (DB::table(config('constants.DB_HR') . ".tblLeaveApplication")
                // ->where('intLeaveTypeID', $intLeaveTypeID)
                ->where('intEmployeeID', $intEmployeeID)
                ->where('dateAppliedFromDate', '>=', $dteDutyFrom)
                ->where('dateAppliedToDate', '<=', $dteDutyTo)
                ->exists()
            ) {
                $data['ysnValidStrategy'] = true;
            } else {
                $data['ysnValidStrategy'] = 'Sorry, You can take maternal leave single time at a year.';
            }

            if ($data['ysnValidStrategy'] == true) {
                $balanceDays = 1; // query

                $RemainingDaysQuery = DB::table(config('constants.DB_HR') . ".tblLeaveBalance");
                $RemainingDays = $RemainingDaysQuery->select(['intRemainingDays'])
                    ->where('intEmployeeID',  $intEmployeeID)
                    ->where('intLeaveTypeId',  $intLeaveTypeID)
                    ->value('intRemainingDays');

                //  $getdates = Carbon::parse(Carbon::now());

                $getdates = Carbon::now()->format('Y-m-d');


                if ($RemainingDays != 0) {
                    if ($intAppliedDays <= $intMaximumAllowedAt_A_Time) {
                        $data['ysnValidStrategy'] = '1';
                    } else {
                        $data['ysnValidStrategy'] = 'Maximum allowed days is less than applied days.';
                    }
                } else {
                    $data['ysnValidStrategy'] = 'Sorry, you have no leave balance.';
                }
            }

            return $data;
        } else if ($intLeaveTypeID == 7) { // Check Leave Type Strategy For PL (7)



            if (DB::table(config('constants.DB_HR') . ".tblLeaveApplication")
                // ->where('intLeaveTypeID', $intLeaveTypeID)
                ->where('intEmployeeID', $intEmployeeID)
                ->where('dateAppliedFromDate', '>=', $dteDutyFrom)
                ->where('dateAppliedToDate', '<=', $dteDutyTo)
                ->exists()
            ) {
                $data['ysnValidStrategy'] = true;
            } else {
                $data['ysnValidStrategy'] = 'Sorry, You can take PL single time at a year.';
            }

            if ($data['ysnValidStrategy'] == true) {
                $balanceDays = 1; // query

                $RemainingDaysQuery = DB::table(config('constants.DB_HR') . ".tblLeaveBalance");
                $RemainingDays = $RemainingDaysQuery->select(['intRemainingDays'])
                    ->where('intEmployeeID',  $intEmployeeID)
                    ->where('intLeaveTypeId',  $intLeaveTypeID)
                    ->value('intRemainingDays');

                //  $getdates = Carbon::parse(Carbon::now());

                $getdates = Carbon::now()->format('Y-m-d');


                if ($RemainingDays != 0) {
                    if ($intAppliedDays <= $intMaximumAllowedAt_A_Time) {
                        $data['ysnValidStrategy'] = '1';
                    } else {
                        $data['ysnValidStrategy'] = 'Maximum allowed days is less than applied days.';
                    }
                } else {
                    $data['ysnValidStrategy'] = 'Sorry, PL is not allowed at this month';
                }
            }

            return $data;
        }

        return $data;
    }

    public function GetMovementType()
    {


        $query = DB::table(config('constants.DB_HR') . ".tblofficialMovementType");


        $output = $query->select(
            [
                'intMoveTypeID as intId', 'strMoveType as strName'
            ]
        )

            ->where('ysnActive', true)
            ->get();
        return $output;
    }

    public function GetCountryList()
    {


        $query = DB::table(config('constants.DB_HR') . ".tblCountry");


        $output = $query->select(
            [
                'intCountryID as intId', 'strCountry as strName'
            ]
        )


            ->get();
        return $output;
    }


    public function MovementApplication(Request $request)
    {

        $intEmployeeID = $request->intEmployeeID;
        $intCountry = $request->intCountry;
        $intDistrict = $request->intDistrict;
        $dateFrom = $request->dateFrom;

        $dateTo = $request->dateTo;
        $strReason = $request->strReason;
        $strAddress = $request->strAddress;
        $intAppliedBy = $request->intAppliedBy;

        // return $request->dateFrom;

        // return $intEmployeeID;
        if (DB::table(config('constants.DB_HR') . ".tblOfficialMovement as mov")
            ->where('intEmpID', $intEmployeeID)

            // ->whereDate('dteStartTime', '>=', $dateFrom)
            // ->whereDate('dteEndTime', '<=',  $dateTo)

            ->where('dteStartTime', '>=', $dateFrom)
            ->where('dteEndTime', '<=', $dateTo)

            ->exists()
        ) {
            $data['ysnMovement'] = true;
        } else {
            $data['ysnMovement'] = false;
            $msg = "Faill......";
        }

        // return $data;

        if ($data['ysnMovement'] == false) {
            if (!is_null($dateFrom) &&  !is_null($dateTo)) {
                $intLeaveID =   DB::table(config('constants.DB_HR') . ".tblOfficialMovement")->insertGetId(
                    [
                        'intEmpID' =>  $intEmployeeID,
                        'intMoveTypeID' => 2,
                        'dteStartTime' =>  $dateFrom,
                        'dteEndTime' =>  $dateTo,
                        'dteAppliedTime' => Carbon::now(),
                        'intCountryID' =>  $intCountry,
                        'strAddress' =>  $strAddress,
                        'intDistrictID' =>  $intDistrict,
                        'strReason' =>  $strReason,
                        'ysnApproved' => 'False',
                        'ysnRejected' => 'False',


                    ]
                );
            }
            if ($intLeaveID > 0) {

                DB::table(config('constants.DB_HR') . ".tblHRDataHistory")->insertGetId(
                    [
                        'strAction' => 'Insert',
                        'strDescription' => 'Movement Application Data For' . " " . $intLeaveID,
                        'strTblName' => 'tblOfficialMovement',
                        'dteDate' =>   Carbon::now(),
                        'intUserID' => $request->intEmployeeID,

                    ]
                );
            }
            return $intLeaveID;
        } else {
            return 0;
        }
    }

    public function GetDistrictList()
    {


        $query = DB::table(config('constants.DB_HR') . ".tblDistrict");


        $output = $query->select(
            [
                'intDistrictID as intId', 'strDistrict as strName', 'strDistrictBanglaName as strBanglaName'
            ]
        )


            ->get();
        return $output;
    }

    /**
     * Delete Move Application
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function MovementApplicationDelete($request)
    {


        $intId = $request->intId;

        // return $intId  A non-numeric value encountered;
        $checkdata =  DB::table(config('constants.DB_HR') . ".tblOfficialMovement")
            ->where('intId', $intId)

            ->where('ysnApproved', false)
            //    ->orWhere('ysnRejected', false)
            ->get();



        //   return   $checkdata;

        //         if ($checkdata->ysnApproved == false) {

        // return "here N";

        DB::table(config('constants.DB_HR') . ".tblOfficialMovement")
            ->where('intId', $request->intId)
            ->where('ysnRejected', false)
            ->delete();


        DB::table(config('constants.DB_HR') . ".tblHRDataHistory")->insertGetId(
            [
                'strAction' => 'Delete',
                'strDescription' => 'Movement Application Data For ' + $request->intId,
                'strTblName' => 'tblHRDataHistory',
                'dteDate' =>   Carbon::now(),
                'intUserID' => $request->intEmpID,

            ]
        );
        // }
    }
}
