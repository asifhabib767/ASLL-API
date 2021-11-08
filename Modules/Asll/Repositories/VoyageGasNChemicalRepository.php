<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\VoyageGasNChemical;
use Modules\Asll\Entities\VoyageActivityGasNChemicalMain;
use Modules\Asll\Repositories\GasNChemicalRepository;

class VoyageGasNChemicalRepository
{
    public function getVoyageGasNChemical()
    {
        try {
            $voyageGasNChemical = VoyageGasNChemical::where('ysnActive', 1)
                ->get();
            return $voyageGasNChemical;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function voyageGasNChemicalStore(Request $request)
    {
        // add multiple in VoyageGasNChemical
        if (count($request->voyageGasNChemical) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $voyageActivityRepo = new VoyageActivityRepository();
            $voyageActivity = $voyageActivityRepo->store($request);

            $i = 1;

            foreach ($request->voyageGasNChemical as $voyageGasNChemical) {
                if($i == 1){
                    // Check if already an entry in VoyageActivityBoilerMain table by this date
                    $gasMain = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)
                    ->where('dteCreatedAt', date('Y-m-d'))
                    ->first();
                    if(is_null($gasMain)){
                        $gasMain = VoyageActivityGasNChemicalMain::create([
                            'intVoyageActivityID'=> $voyageActivity->intID,
                            'intCreatedBy' => $voyageGasNChemical['intCreatedBy'],
                            'dteCreatedAt' => $voyageActivity->dteCreatedAt,
                            'strRemarks' => $voyageActivity->strRemarks,
                        ]);
                    }
                    else{
                        VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->update([
                            'intCreatedBy' => $voyageGasNChemical['intCreatedBy'],
                            'dteCreatedAt' => $voyageActivity->dteCreatedAt,
                            'strRemarks' => $voyageActivity->strRemarks,
                        ]);
                    }
                }

                // $voyageGasNChemical = null;
                if($voyageGasNChemical['intGasNChemicalId'] == 0){
                    // Create New GasNChemical Entry
                    $gasNChemicalRepo = new GasNChemicalRepository();
                    $request->strGasNChemicalName = $voyageGasNChemical['strGasNChemicalName'];
                    $request->intCreatedBy = $voyageGasNChemical['intCreatedBy'];
                    $intGasNChemicalId = $gasNChemicalRepo->storeGasNChemicalLists($request)->intId;
                }else{
                    $intGasNChemicalId = $voyageGasNChemical['intGasNChemicalId'];
                }

                $voyageGasNChemical = VoyageGasNChemical::create([
                    'intUnitId'=> $voyageActivity->intUnitId,
                    'intVoyageActivityID'=> $voyageActivity->intID,
                    'intShipPositionID'=>$voyageActivity->intShipPositionID,
                    'intShipConditionTypeID'=>$voyageActivity->intShipConditionTypeID,
                    'dteCreatedAt'=>$voyageActivity->dteCreatedAt,
                    'strRPM'=>$voyageActivity->strRPM,
                    'decEngineSpeed'=>$voyageActivity->decEngineSpeed,
                    'decSlip'=>$voyageActivity->decSlip,
                    'intVoyageID'=> $voyageActivity->intVoyageID,

                    'intGasNChemicalId'=> $intGasNChemicalId,
                    'intVoyageActivityGasNChemicalMainID'=> $gasMain->intID,
                    'strGasNChemicalName'=>$voyageGasNChemical['strGasNChemicalName'],
                    'decBFWD'=> $voyageGasNChemical['decBFWD'],
                    'decRecv'=> $voyageGasNChemical['decRecv'],
                    'decCons'=> $voyageGasNChemical['decCons'],
                    'dectotal'=> $voyageGasNChemical['dectotal'],
                    'intCreatedBy'=> $voyageGasNChemical['intCreatedBy'],
                ]
            );
        }
        DB::commit();
        return $voyageGasNChemical;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
    return true;
}

    /**
     * update voyage by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated voyage object
     */
    public function update(Request $request, $id)
    {
        $intEmployeeId = 1;
        try {
            DB::beginTransaction();
            $voyageActivityRepo = new VoyageActivityRepository();
            $voyageActivity = $voyageActivityRepo->store($request);

            VoyageGasNChemical::where('intID', $id)
                ->update([

                    'intUnitId'=>(float) $request->intUnitId,
                    'intShipPositionID'=>(float) $request->intShipPositionID,
                    'intShipConditionTypeID'=>(float) $request->intShipConditionTypeID,
                    'dteCreatedAt'=>(float) $request->dteCreatedAt,
                    'strRPM'=>(float) $request->strRPM,
                    'decEngineSpeed'=>(float) $request->decEngineSpeed,
                    'decSlip'=>(float) $request->decSlip,
                    'intId'=>(float) $request->intId,
                    'intVoyageID'=>(float) $voyageActivity->intVoyageID,
                    'intGasNChemicalId'=> (float) $request->intGasNChemicalId,
                    'strGasNChemicalName'=>(float) $request->strGasNChemicalName,
                    'decBFWD'=> (float) $request->decBFWD,
                    'dteCreatedAt'=> (float) $request->dteCreatedAt,
                    'decRecv'=> (float) $request->decRecv,
                    'decCons'=> (float) $request->decCons,
                    'dectotal'=> (float) $request->dectotal,
                    'strRemarks'=> $request->strRemarks,
                    'intCreatedBy'=> $intEmployeeId,
                    'intUpdatedBy'=> $intEmployeeId,
                    'intDeletedBy'=> $intEmployeeId,
                ]);

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
        $id = (int) $id;
        try {
            $voyageGasNChemical = VoyageGasNChemical::findOrFail($id);
            return $voyageGasNChemical;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, VoyageGasNChemical Not Found !');
        }
    }

}
