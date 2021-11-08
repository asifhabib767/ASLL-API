<?php

namespace Modules\VoyageLighter\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\VoyageLighter\Entities\FuelLogDetails;
use Modules\VoyageLighter\Entities\FuelLogMain;
use Modules\VoyageLighter\Entities\LighterVoyageMain;
use Modules\VoyageLighter\Entities\VoyageLighterDetails;
use Modules\VoyageLighter\Entities\VoyageLighterMain;

class VoyageLighterMainRepository
{
    public function getAll()
    {
        $query = LighterVoyageMain::with('details')
            ->orderBy('intID', 'desc');

        if (request()->intLighterId) {
            $query->where('intLighterId', (int)request()->intLighterId);
        }

        $voyageLighter = $query->first();

        $fuelLogMain = FuelLogMain::with('details')
            // ->where('intVoyageId', 30148)
            ->where('intVoyageId', $voyageLighter->intID)
            ->orderBy('intID', 'desc')
            ->first();

        $voyageLighter->oilStatements = $fuelLogMain;

        return $voyageLighter;
    }

    public function show($id)
    {
        $id = (int) $id;
        try {
            $lighterList = LighterVoyageMain::leftJoin('tblFuelLogMain', 'tblVoyageLighterMain.intID', 'tblFuelLogMain.intVoyageId')->where('intID', $id)
                ->with('details', 'oilStatements');
            return $lighterList;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Lighter List Not Found !');
        }
    }

    public function lighterUpdate(Request $request, $id)
    {
        try {
            $lighter = VoyageLighterMain::where('intID', $id)
                ->update([
                    'intLoadingPointId' => $request->intLoadingPointId,
                    'strLoadingPointName' => $request->strLoadingPointName,
                    'intDischargePortID' => $request->intDischargePortID,
                    'strDischargePortName' => $request->strDischargePortName,
                    'intLighterId' => $request->intLighterId,
                    'strLighterName' => $request->strLighterName,
                    'dteVoyageCommencedDate' => $request->dteVoyageCommencedDate,
                    'dteVoyageCompletionDate' => $request->dteVoyageCompletionDate,
                    'monTotalExpense' => $request->monTotalExpense,
                ]);

            foreach ($request->voyageLighters as $voyageLighter) {
                if (VoyageLighterDetails::where('intID', $voyageLighter['intID'])->exists()) {
                    $lighterDetails = VoyageLighterDetails::where('intID', $voyageLighter['intID'])
                        ->update([
                            'intVoyageLighterId' => (int) $id,
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
                            'strPartyName' => $voyageLighter['strPartyName'],
                            'intPartyID' => $voyageLighter['intPartyID'],
                            'decFreightRate' => $voyageLighter['decFreightRate'],
                        ]);
                } else {
                    $lighterDetails = VoyageLighterDetails::create([
                        'intVoyageLighterId' => (int) $id,
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
                        'strPartyName' => $voyageLighter['strPartyName'],
                        'intPartyID' => $voyageLighter['intPartyID'],
                        'decFreightRate' => $voyageLighter['decFreightRate'],
                        'ysnActive' => true,
                        'synced' => true,
                    ]);
                }
            }

            foreach ($request->oilStatements as $oilStatement) {

                if (FuelLogDetails::where('intID', $oilStatement['intID'])->exists()) {
                    // $oilStateMain = FuelLogMain::where('intID', $oilStatement['intID'])
                    //     ->update([
                    //         'intLighterId' => (int) $id,
                    //         'strLighterName' => $oilStatement['strLighterName'],
                    //         'strDetails' => $oilStatement['strDetails'],
                    //         'intVoyageId' => $oilStatement['intVoyageId'],
                    //         'intVoyageNo' => $oilStatement['intVoyageNo'],
                    //         'intUpdatedBy' => $oilStatement['intUpdatedBy'],
                    //         'ysnActive' => true,
                    //     ]);
                    $oilStateDetails = FuelLogDetails::where('intID', $oilStatement['intID'])
                        ->update([
                            'intFuelLogId' => $oilStatement['intFuelLogId'],
                            'intFuelTypeId' => $oilStatement['intFuelTypeId'],
                            'strFuelTypeName' => $oilStatement['strFuelTypeName'],
                            'decFuelPrice' => $oilStatement['decFuelPrice'],
                            'decFuelQty' => $oilStatement['decFuelQty'],
                            'updated_at' => Carbon::now(),
                        ]);
                } else {
                    // $oilStateMain = FuelLogMain::create([
                    //     'strLighterName' => $oilStatement['strLighterName'],
                    //     'strDetails' => $oilStatement['strDetails'],
                    //     'intVoyageId' => $oilStatement['intVoyageId'],
                    //     'intVoyageNo' => $oilStatement['intVoyageNo'],
                    //     'intUpdatedBy' => $oilStatement['intUpdatedBy'],
                    //     'ysnActive' => true,
                    // ]);
                    $oilStateDetails = FuelLogDetails::create([
                        'intFuelLogId' => $oilStatement['intFuelLogId'],
                        'intFuelTypeId' => $oilStatement['intFuelTypeId'],
                        'strFuelTypeName' => $oilStatement['strFuelTypeName'],
                        'decFuelPrice' => $oilStatement['decFuelPrice'],
                        'decFuelQty' => $oilStatement['decFuelQty'],
                        'ysnActive' => true,
                        'created_at' => Carbon::now(),
                    ]);
                }
            }
        }
        catch (\Exception $e) {
            return false;
        }
    }
}
