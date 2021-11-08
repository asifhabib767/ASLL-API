<?php

namespace Modules\VoyageLighter\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\VoyageLighter\Entities\FuelLogMain;
use Modules\VoyageLighter\Entities\FuelLogDetails;

class FuelLogRepository
{
    public function getFuelLog($dteStartDate, $dteEndDate)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";
        try {
            $fuelLog = FuelLogMain::where('ysnActive', 1)
                ->whereBetween('dteDate', [$startDate, $endDate])
                ->with('details')
                ->orderBy('intID', 'desc')
                ->get();
            return $fuelLog;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function fuelLogStore(Request $request)
    {
        // add multiple in VoyageGasNChemical
        if (count($request->logLists) == 0) {
            return "No Item Given";
        }
        try {

            $intFuelLogId = FuelLogMain::create([
                'intLighterId' => $request->intLighterId,
                'strLighterName' => $request->strLighterName,
                'dteDate' => $request->dteDate,
                'strDetails' => $request->strDetails,
                'intVoyageId' => $request->intVoyageId,
                'intVoyageNo' => (int)$request->intVoyageNo,
                'ysnActive' => $request->ysnActive,
                'intCreatedBy' => $request->intCreatedBy,
            ]);
            $i = 1;

            foreach ($request->logLists as $logList) {
                // Check if already an entry in VoyageActivityBoilerMain table by this date
                // $lighter = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->first();

                $logDetails = FuelLogDetails::create([
                    // 'intLighterId'=> $fuelLog->intID,
                    'intFuelLogId' => $intFuelLogId->intID,
                    'intFuelTypeId' => $logList['intFuelTypeId'],
                    'strFuelTypeName' => $logList['strFuelTypeName'],
                    'decFuelPrice' => $logList['decFuelPrice'],
                    'decFuelQty' => $logList['decFuelQty'],
                ]);
                $i++;
            }
            return $logDetails;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function fuelLogUpdate(Request $request, $id)
    {
        try {
            FuelLogMain::where('intID', $request->intId)
                ->update([
                    'intLighterId' => $request->intLighterId,
                    'strLighterName' => $request->strLighterName,
                    'dteDate' => $request->dteDate,
                    'strDetails' => $request->strDetails,
                    'intVoyageId' => $request->intVoyageId,
                    'intVoyageNo' => (int)$request->intVoyageNo,
                    'ysnActive' => $request->ysnActive,
                    'intCreatedBy' => $request->intCreatedBy,
                ]);

            $i = 1;

            foreach ($request->logLists as $logList) {
                // Check if already an entry in FuelLogMain table
                // $lighter = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->first();

                $lighterDetails = FuelLogDetails::where('intLighterId', $request->intLighterId)
                    ->update([
                        // 'intLighterId'=> $fuelLog->intID,
                        // 'intFuelLogId' => $intFuelLogId->intID,
                        'intFuelTypeId' => $logList['intFuelTypeId'],
                        'strFuelTypeName' => $logList['strFuelTypeName'],
                        'decFuelPrice' => $logList['decFuelPrice'],
                        'decFuelQty' => $logList['decFuelQty'],
                    ]);
                $i++;
            }
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
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
            $lighterUpdate = FuelLogMain::find($id);
            return $lighterUpdate;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Voyage Lighter Not Found !');
        }
    }
}
