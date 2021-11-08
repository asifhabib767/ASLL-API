<?php

namespace Modules\VoyageLighter\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\VoyageLighter\Entities\CodeCount;
use Modules\VoyageLighter\Entities\ItemType;
use Modules\VoyageLighter\Entities\Lighter;
use Modules\VoyageLighter\Entities\LighterEmployee;
use Modules\VoyageLighter\Entities\LighterLoadingPoint;
use Modules\VoyageLighter\Entities\LighterPositionStatus;
use Modules\VoyageLighter\Entities\LighterVoyageActivity;
use Modules\VoyageLighter\Entities\LoadingPointType;
use Modules\VoyageLighter\Entities\VoyageLighterMain;
use Modules\VoyageLighter\Entities\VoyageLighterDetails;

class VoyageLighterRepository
{
    public function getVoyageLighter($dteStartDate, $dteEndDate)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        try {
            $voyageLighter = VoyageLighterMain::where('ysnActive', 1)
                ->whereBetween('dteDate', [$startDate, $endDate])
                ->with('details')
                ->orderBy('intID', 'desc')
                ->get();
            return $voyageLighter;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getLighter()
    {
        try {
            $lighterType = Lighter::with('employees')->get();
            return $lighterType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getVoyageLighterDetails($intVoyageLighterId)
    {
        try {
            $voyageLighter = VoyageLighterMain::where('intID', $intVoyageLighterId)
                ->with('details', 'activities')
                ->first();

            $statusList = $this->getLighterStatus();
            $i = 0;
            foreach ($statusList as $st) {
                $st->ysnCompleted = false;
                $activity = $this->getWorkingStatusByVoyageAndStatusType($voyageLighter->intID, $st->intID);
                if (!is_null($activity)) {
                    $statusList[$i]->ysnCompleted = is_null($activity) ? false : true;
                    $statusList[$i]->dteCompletionDate = $activity->dteCompletionDate;
                    $statusList[$i]->strCompletionTime = $activity->strCompletionTime;
                } else {
                    $statusList[$i]->ysnCompleted = false;
                    $statusList[$i]->dteCompletionDate = null;
                    $statusList[$i]->strCompletionTime = null;
                }
                $i++;
            }
            $voyageLighter->statusList = $statusList;
            return $voyageLighter;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getWorkingStatusByVoyageAndStatusType($intVoyageID, $intStatusId)
    {
        return LighterVoyageActivity::where('intLighterVoyageId', $intVoyageID)
            ->where('intLighterPositionStatusId', $intStatusId)
            ->first();
    }

    public function getVoyageLighterVesselId($intVesselId)
    {
        try {
            $lighterVoyageListDetails = VoyageLighterDetails::where('intVesselId', $intVesselId)
                ->get();
            return $lighterVoyageListDetails;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItemType()
    {
        try {
            $itemType = ItemType::get();
            return $itemType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getLoadingPointType()
    {
        try {
            $loadingPointType = LoadingPointType::get();
            return $loadingPointType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getLighterStatus()
    {
        try {
            $lighterStatus = LighterPositionStatus::get();
            return $lighterStatus;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function voyageLighterStore(Request $request)
    {
        $tripCode = $this->tripCodeGenerate($request);

        if (count($request->voyageLighters) == 0) {
            return "No Item Given";
        }
        try {

            $lighter = VoyageLighterMain::create([
                'dteDate' => Carbon::now(),
                'intLoadingPointId' => $request->intLoadingPointId,
                'strLoadingPointName' => $request->strLoadingPointName,
                'intLighterId' => $request->intLighterId,
                'strLighterName' => $request->strLighterName,
                'strCode' => $tripCode['code'],
                'intLighterVoyageNo' => $tripCode['no'],
                'intMasterId' => $request->intMasterId,
                'strMasterName' => $request->strMasterName,
                'strUnloadStartDate' => Carbon::now(),
                'strUnloadCompleteDate' => Carbon::now(),
                'intDriverId' => $request->intDriverId,
                'strDriverName' => $request->strDriverName,
                'strComments' => $request->strComments,
                'intCreatedBy' => $request->intCreatedBy,
                'ysnActive' => $request->ysnActive,
            ]);

            $i = 1;

            foreach ($request->voyageLighters as $voyageLighter) {
                // Check if already an entry in VoyageLighterMain table
                // $lighter = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->first();

                $lighterDetails = VoyageLighterDetails::create([
                    'intVoyageLighterId' => $lighter->intID,
                    'intItemId' => $voyageLighter['intItemId'],
                    'strItemName' => $voyageLighter['strItemName'],
                    'intQuantity' => $voyageLighter['intQuantity'],
                    'intVesselId' => $voyageLighter['intVesselId'],
                    'strVesselName' => $voyageLighter['strVesselName'],
                    'dteETAVessel' => $voyageLighter['dteETAVessel'],
                    'intVoyageId' => $voyageLighter['intVoyageId'],
                    'intVoyageNo' => $voyageLighter['intVoyageNo'],
                    'strLCNo' => $voyageLighter['strLCNo'],
                    'intBoatNoteQty' => $voyageLighter['intBoatNoteQty'],
                    'intSurveyNo' => $voyageLighter['intSurveyNo'],
                    'intSurveyQty' => $voyageLighter['intSurveyQty'],
                ]);
                $i++;
            }
            return $lighterDetails;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function voyageLighterUpdate(Request $request, $id)
    {
        // $tripCode = $this->tripCodeGenerate($request);
        try {
            $lighter = VoyageLighterMain::where('intID', $request->intId)
                ->update([
                    'dteDate' => Carbon::now(),
                    'intLoadingPointId' => $request->intLoadingPointId,
                    'strLoadingPointName' => $request->strLoadingPointName,
                    'intLighterId' => $request->intLighterId,
                    'strLighterName' => $request->strLighterName,
                    'strCode' => $request->strCode,
                    'intLighterVoyageNo' => $request->intLighterVoyageNo,
                    'intMasterId' => $request->intMasterId,
                    'strMasterName' => $request->strMasterName,
                    'strUnloadStartDate' => Carbon::now(),
                    'strUnloadCompleteDate' => Carbon::now(),
                    'intDriverId' => $request->intDriverId,
                    'strDriverName' => $request->strDriverName,
                    'strComments' => $request->strComments,
                    'intCreatedBy' => $request->intCreatedBy,
                    'ysnActive' => $request->ysnActive,
                ]);

            $i = 1;

            foreach ($request->voyageLighters as $voyageLighter) {
                // Check if already an entry in VoyageActivityBoilerMain table by this date
                // $lighter = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->first();

                $lighterDetails = VoyageLighterDetails::where('intVoyageLighterId', $request->intVoyageLighterId)
                    ->update([
                        // 'intVoyageLighterId'=> $lighter->intVoyageLighterId,
                        'intVoyageLighterId' => $lighter->intID,
                        'intItemId' => $voyageLighter['intItemId'],
                        'strItemName' => $voyageLighter['strItemName'],
                        'intQuantity' => $voyageLighter['intQuantity'],
                        'intVesselId' => $voyageLighter['intVesselId'],
                        'strVesselName' => $voyageLighter['strVesselName'],
                        'dteETAVessel' => $voyageLighter['dteETAVessel'],
                        'intVoyageId' => $voyageLighter['intVoyageId'],
                        'intVoyageNo' => $voyageLighter['intVoyageNo'],
                        'strLCNo' => $voyageLighter['strLCNo'],
                        'intBoatNoteQty' => $voyageLighter['intBoatNoteQty'],
                        'intSurveyNo' => $voyageLighter['intSurveyNo'],
                        'intSurveyQty' => $voyageLighter['intSurveyQty'],
                    ]);
                $i++;
            }
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function tripCodeGenerate(Request $request)
    {
        // $month = date('m'); // '07'
        $fullYear = date('Y'); // '2020'

        $data = CodeCount::where('strCodeFor', 'Lighter Voyage')
            ->where('year', $fullYear)
            ->where('intLighterId', $request->intLighterId)
            // ->where('intMonth', $month)
            ->get();

        // Get that countNo and return
        $year = $fullYear;
        $intLighterVoyageNo = 0;

        $intLighterId = str_pad($request->intLighterId, 3, "0", STR_PAD_LEFT);


        if (count($data) > 0) {
            $count = $data[0]->intCount;
            $code = $year . "" . $intLighterId . "" . ($count + 1);
            // Update intCount
            CodeCount::where('strCodeFor', 'Lighter Voyage')
                ->where('year', $fullYear)
                // ->where('intMonth', $month)
                ->update(
                    ['intCount' => ($count + 1)]
                );
            $intLighterVoyageNo = $count + 1;
        } else {
            $code = $year . "" . $intLighterId . "" . '1';
            CodeCount::create(
                [
                    'intLighterId' => $intLighterId,
                    'strCodeFor' => "Lighter Voyage",
                    'year' => $fullYear,
                    'intCount' => 1,
                ]
            );
            $intLighterVoyageNo = 1;
        }
        $data =  [[
            'code' => $code,
            'no' => $intLighterVoyageNo
        ]];
        return $data[0];
    }

    /**
     * show voyege activity boiler by id
     *
     * @param integer $id
     * @return object voyage activity boiler object
     */
    public function show($id)
    {
        // $id = (int) $id;
        // return $id;
        try {
            $lighterUpdate = VoyageLighterMain::find($id);
            return $lighterUpdate;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Voyage Lighter Not Found !');
        }
    }

    public function getEmployeeList($intEmployeeType)
    {
        try {
            $employeeList = LighterEmployee::where('intEmployeeType', $intEmployeeType)
                ->get();
            return $employeeList;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getEmployeeListByLighterId($intLighterId)
    {
        try {
            $employeeListByLighterId = LighterEmployee::select('*');

            if ($intLighterId != null) {
                $employeeListByLighterId = $employeeListByLighterId->where('intLighterId', $intLighterId);
            }

            $employeeListByLighterId = $employeeListByLighterId->get();

            return $employeeListByLighterId;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function lighterEmployeeUpdate(Request $request, $id)
    {
        try {
            $lighterEmployee = LighterEmployee::where('intLighterEmployeeId', $id)
                ->update([
                    'strLighterEmployeeName' => $request->strLighterEmployeeName,
                    'intEmployeeType' => $request->intEmployeeType,
                    'intLighterId' => $request->intLighterId,
                    'intUpdatedBy' => $request->intUpdatedBy,
                ]);
            return $lighterEmployee;
        } catch (\Exception $e) {
            return false;
        }
    }
}
