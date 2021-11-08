<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\VoyageActivityEngine;

class VoyageActivityEngineRepository
{
    public function getVoyageActivityEngine()
    {
        try {
            $voyageActivityEngine = VoyageActivityEngine::where('ysnActive', 1)
                ->get();
            return $voyageActivityEngine;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new VoyageActivityEngine to VoyageActivityEngine
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function store(Request $request)
    {
        $intEmployeeId = 1;
        try {
            // Create Voyage Activity
            DB::beginTransaction();

            $voyageActivityRepo = new VoyageActivityRepository();
            $voyageActivity = $voyageActivityRepo->store($request);

            $voyageActivityEngine = VoyageActivityEngine::create([
                'intVoyageActivityID'=> $voyageActivity->intID,
                'intShipEngineID'=> $voyageActivity->intID,
                'strShipEngineName'=> $voyageActivity->intID,

                'dceJacketTemp1'=> (float) $request->dceJacketTemp1,
                'dceJacketTemp2'=> (float) $request->dceJacketTemp2,
                'dcePistonTemp1'=> (float) $request->dcePistonTemp1,
                'dcePistonTemp2'=> (float) $request->dcePistonTemp2,
                'dceExhtTemp1'=> (float) $request->dceExhtTemp1,
                'dceExhtTemp2'=> (float) $request->dceExhtTemp2,
                'dceScavTemp1'=> (float) $request->dceScavTemp1,
                'dceScavTemp2'=> (float) $request->dceScavTemp2,
                'dceTurboCharger1Temp1'=> (float) $request->dceTurboCharger1Temp1,
                'dceTurboCharger1Temp2'=> (float) $request->dceTurboCharger1Temp2,
                'dceEngineLoad'=> (float) $request->dceEngineLoad,
                'dceJacketCoolingTemp1'=> (float) $request->dceJacketCoolingTemp1,
                'dcePistonCoolingTemp1'=> (float) $request->dcePistonCoolingTemp1,
                'dceLubOilCoolingTemp1'=> (float) $request->dceLubOilCoolingTemp1,
                'dceFuelCoolingTemp1'=> (float) $request->dceFuelCoolingTemp1,
                'dceScavCoolingTemp1'=> (float) $request->dceScavCoolingTemp1,
                'strRemarks' => $request->strRemarks,
                'intCreatedBy'=> $intEmployeeId,
            ]);
            DB::commit();
            return $voyageActivityEngine;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
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

            VoyageActivityEngine::where('intID', $id)
            ->update([
                'intVoyageActivityID'=> $voyageActivity->intID,
                'intShipEngineID'=> $voyageActivity->intID,
                'strShipEngineName'=> $voyageActivity->intID,

                'dceJacketTemp1'=> (float) $request->dceJacketTemp1,
                'dceJacketTemp2'=> (float) $request->dceJacketTemp2,
                'dcePistonTemp1'=> (float) $request->dcePistonTemp1,
                'dcePistonTemp2'=> (float) $request->dcePistonTemp2,
                'dceExhtTemp1'=> (float) $request->dceExhtTemp1,
                'dceExhtTemp2'=> (float) $request->dceExhtTemp2,
                'dceScavTemp1'=> (float) $request->dceScavTemp1,
                'dceScavTemp2'=> (float) $request->dceScavTemp2,
                'dceTurboCharger1Temp1'=> (float) $request->dceTurboCharger1Temp1,
                'dceTurboCharger1Temp2'=> (float) $request->dceTurboCharger1Temp2,
                'dceEngineLoad'=> (float) $request->dceEngineLoad,
                'dceJacketCoolingTemp1'=> (float) $request->dceJacketCoolingTemp1,
                'dcePistonCoolingTemp1'=> (float) $request->dcePistonCoolingTemp1,
                'dceLubOilCoolingTemp1'=> (float) $request->dceLubOilCoolingTemp1,
                'dceFuelCoolingTemp1'=> (float) $request->dceFuelCoolingTemp1,
                'dceScavCoolingTemp1'=> (float) $request->dceScavCoolingTemp1,
                'strRemarks' => $request->strRemarks,
                'intCreatedBy'=> $intEmployeeId,
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
            $voyageActivityEngine = VoyageActivityEngine::findOrFail($id);
            return $voyageActivityEngine;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, VoyageActivityEngine Not Found !');
        }
    }

}
