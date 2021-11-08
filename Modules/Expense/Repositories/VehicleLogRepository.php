<?php

namespace Modules\Expense\Repositories;

// use App\Helpers\ImageUploadHelper;

use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AdditionDeductionDetails;
use Modules\Expense\Entities\VehicleLog;
use Modules\Expense\Entities\VehicleLogHeader;

class VehicleLogRepository
{


    public function additionDeductionListByEmployee($intEmployeeId)
    {
        try {
            $additionDeductionList = DB::table(config('constants.DB_ASLL') . ".tblAdditionDeductionDetails")
                ->select(
                    'intID',
                    'intAdditionDeductionId',
                    'intAdditionDeductionTypeId',
                    'strAdditionDeductionTypeName',
                    'amount',
                    'updated_at',
                    'created_at'
                )
                ->where('intEmployeeId', $intEmployeeId)
                ->orderBy('intID', 'desc')
                ->get();
            return $additionDeductionList;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * Create Vehicle Log
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createVehicleLog($request)
    {
        if (count($request) == 0) {
            return "No Item Given";
        }


        try {
            DB::beginTransaction();
            $strTravelCode = 'VL-';
            $business = DB::table(config('constants.DB_HR') . ".tblUnit")
                ->where('intUnitID',  $request[0]['intBusinessUnitId'])
                ->first();


            if (!is_null($business)) {
                $vehicleLogHeader = VehicleLogHeader::create([
                    'strTravelCode' => $strTravelCode,
                    'dteTravelDate' => $request[0]['dteTravelDate'],
                    'intAccountId' => null,
                    'intBusinessUnitId' => $business->intUnitID,
                    'strBusinessUnitName' => $business->strUnit,
                    // 'strTotalOvertime' => $request[0]['strTotalOvertime'],
                    'ysnActive' => true,
                    'intActionBy' => $request[0]['intActionBy'],
                    'dteLastActionDateTime' => Carbon::now(),
                    'dteServerDateTime' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $intVehicleLogHeaderId = $vehicleLogHeader->intVehicleLogHeaderId;
                $vehicleLogHeader->strTravelCode = "VL-" . $intVehicleLogHeaderId;

                $totalOvertime = 0;
                foreach ($request as $multiple) {
                    $overTime = $this->getOvertime($multiple['dteTravelDate'], $multiple['dteEndTime']);
                    $totalOvertime += $overTime;
                    $totalOvertimeFormated = DateHelper::ConvertToHoursMins($overTime, '%02d H %02d M');
                }

                $vehicleLogHeader->strTotalOvertime = $totalOvertimeFormated;
                $vehicleLogHeader->save();

                $intRequestId = null;
                foreach ($request as $multiple) {
                    if ($intVehicleLogHeaderId > 0) {

                        $travelDate = $multiple['dteTravelDate'];
                        $travelDateOnly = substr($travelDate, 0, 10);

                        $startTime = $multiple['dteStartTime'];
                        $endTime = $multiple['dteEndTime'];
                        $overTime = $this->getOvertime($multiple['dteTravelDate'], $multiple['dteEndTime']);




                        // $overTimeStart = $travelDateOnly . ' ' . '06:00:00';
                        // $overTimeEnd = $travelDateOnly . ' ' . substr($endTime, 0, 8);
                        // $newStartformat = Carbon::parse($overTimeStart);
                        // $newEndformat =  Carbon::parse($overTimeEnd);
                        // $overTime = $newEndformat->diffInMinutes($newStartformat, true);
                        // $headerOverTime = DateHelper::ConvertToHoursMins($overTime, '%02d H %02d M');
                        // return $headerOverTime;

                        // $hour = substr($endTime, 0, 2);
                        // $minute = substr($endTime, 2, 5);
                        // $overTime = ((int) $hour * 60) + (int) $minute - 6;
                        // return $overTime;

                        $startTimeDate = $travelDateOnly . ' ' . $startTime;
                        $endTimeDate = $travelDateOnly . ' ' . $endTime;




                        $intRequestId = VehicleLog::create(
                            [
                                'intVehicleLogHeaderId' => $intVehicleLogHeaderId,
                                'strTravelCode' => $vehicleLogHeader->strTravelCode,
                                'dteTravelDate' => $multiple['dteTravelDate'],
                                'intBusinessUnitId' => $business->intUnitID,
                                'strBusinessUnitName' => $business->strUnit,
                                'dteStartTime' => $startTimeDate,
                                'dteEndTime' => $endTimeDate,

                                // 'strFromAddress' => $multiple['strFromAddress'],
                                // 'strToAddress' => $multiple['strToAddress'],
                                'intVehicleId' => $multiple['intVehicleId'],
                                'strVehicleNumber' => $multiple['strVehicleNumber'],

                                'numVehicleStartMileage' => $multiple['numVehicleStartMileage'],
                                'numVehicleEndMileage' => $multiple['numVehicleEndMileage'],
                                'numVehicleConsumedMileage' => $multiple['numVehicleConsumedMileage'],

                                'intDriverId' => $multiple['intDriverId'],
                                'strDriverName' => $multiple['strDriverName'],
                                'strOverTime' => (string) $overTime,

                                // 'intSBUId' => $multiple['intSBUId'],
                                // 'strSBUName' => $multiple['strSBUName'],
                                // 'numRate' => $multiple['numRate'],
                                // 'numAmount' => $multiple['numAmount'],
                                // 'strExpenseLocation' => $multiple['strExpenseLocation'],
                                'strVisitedPlaces' => $multiple['strVisitedPlaces'],
                                // 'strAttachmentLink' => $multiple['strAttachmentLink'],
                                // 'isFuelPurchased' => $multiple['isFuelPurchased'],
                                'strPersonalUsage' => $multiple['strPersonalUsage'],
                                'intActionBy' => $multiple['intActionBy'],
                                'dteLastActionDateTime' =>  Carbon::now(),
                                'dteServerDateTime' =>  Carbon::now(),
                                'created_at' =>  Carbon::now(),
                                'updated_at' =>  Carbon::now()
                            ]
                        );
                    }
                }
            }
            DB::commit();
            return $vehicleLogHeader;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function deleteAdditionDetailsData($intID)
    {
        try {
            $details = AdditionDeductionDetails::find($intID);
            if (!is_null($details)) {
                $details->delete();
            }
            return $details;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function updateAdditionDetailsData($intID, $amount)
    {
        try {
            $details = AdditionDeductionDetails::find($intID);
            $details->amount = $amount;
            $details->save();
            return $details;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getVehicleLogList($intActionBy)
    {
        $data = VehicleLogHeader::where('intActionBy', $intActionBy)
            ->orderBy('intVehicleLogHeaderId', 'desc')
            ->get();
        return $data;
    }

    public function getVehicleLogDetailsById($intVehicleLogHeaderId)
    {
        $data = VehicleLogHeader::with('logs')->find($intVehicleLogHeaderId);
        return $data;
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

    /**
     * Vehicle Meter Approve by intVehicleLogHeaderId
     *
     * @param Request $request
     * @param integer $intVehicleLogHeaderId
     * @return object Vehicle Meter Approve object
     */
    public function vehicleMeterApprove(Request $request, $intVehicleLogHeaderId)
    {
        try {
            $vehicleLogHeader = VehicleLogHeader::where('intVehicleLogHeaderId', $intVehicleLogHeaderId)
                ->update([
                    'ysnComplete' => $request->ysnComplete
                ]);

            $vehicleLog = VehicleLog::where('intVehicleLogHeaderId', $intVehicleLogHeaderId)
                ->update([
                    'ysnComplete' => $request->ysnComplete
                ]);

            return $this->show($intVehicleLogHeaderId);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show Vehicle Meter by intVehicleLogHeaderId
     *
     * @param integer $intVehicleLogHeaderId
     * @return object Vehicle Meter object
     */
    public function show($intVehicleLogHeaderId)
    {
        try {
            $data = VehicleLogHeader::with('logs')->find($intVehicleLogHeaderId);
            return $data;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Vehicle Log Not Found !');
        }
    }
}
