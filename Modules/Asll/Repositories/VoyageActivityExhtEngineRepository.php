<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\VoyageActivityExhtEngine;

class VoyageActivityExhtEngineRepository
{
    public function getVoyageActivityExhtEngine()
    {
        try {
            $voyageActivityExhtEngine = VoyageActivityExhtEngine::where('ysnActive', 1)
                ->get();
            return $voyageActivityExhtEngine;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new VoyageActivityExhtEngine to VoyageActivityExhtEngine
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
            // return $voyageActivity;

            $i = 1;


            // Check if already an entry in VoyageActivityExhtEngine table by this date
            $voyageActivityExhtEngine = VoyageActivityExhtEngine::where('intVoyageActivityID', $voyageActivity->intID)
                ->where('intShipEngineID', $request->intShipEngineID)
                ->first();

            if (!is_null($request->intShipEngineID == 2 && $request->intVoyageActivityID)) {
                $voyageActivityExhtEngine = VoyageActivityExhtEngine::create([
                    'intVoyageActivityID' => $voyageActivity->intID,
                    'intShipEngineID' => $request->intShipEngineID,
                    'strShipEngineName' => $voyageActivity->intID,
                    'dceMainEngineFuelRPM' => (float) $request->dceMainEngineFuelRPM,
                    'dceRH' => (float) $request->dceRH,
                    'dceLoad' => (float) $request->dceLoad,
                    'dceExhtTemp1' => (float) $request->dceExhtTemp1,
                    'dceExhtTemp2' => (float) $request->dceExhtTemp2,
                    'dceJacketTemp' => (float) $request->dceJacketTemp,
                    'dceScavTemp' => (float) $request->dceScavTemp,
                    'dceLubOilTemp' => (float) $request->dceLubOilTemp,
                    'dceTCRPM' => (float) $request->dceTCRPM,
                    'dceJacketPressure' => (float) $request->dceJacketPressure,
                    'dceScavPressure' => (float) $request->dceScavPressure,
                    'dceLubOilPressure' => (float) $request->dceLubOilPressure,
                    'strRemarks' => $request->strRemarks,
                    'intCreatedBy' => $intEmployeeId,
                ]);
            } else {
                VoyageActivityExhtEngine::where('intVoyageActivityID', $voyageActivity->intID)->update([
                    'intVoyageActivityID' => $voyageActivity->intID,
                    'intShipEngineID' => $request->intShipEngineID,
                    'strShipEngineName' => $voyageActivity->strShipEngineName,
                    'dceMainEngineFuelRPM' => (float) $request->dceMainEngineFuelRPM,
                    'dceRH' => (float) $request->dceRH,
                    'dceLoad' => (float) $request->dceLoad,
                    'dceExhtTemp1' => (float) $request->dceExhtTemp1,
                    'dceExhtTemp2' => (float) $request->dceExhtTemp2,
                    'dceJacketTemp' => (float) $request->dceJacketTemp,
                    'dceScavTemp' => (float) $request->dceScavTemp,
                    'dceLubOilTemp' => (float) $request->dceLubOilTemp,
                    'dceTCRPM' => (float) $request->dceTCRPM,
                    'dceJacketPressure' => (float) $request->dceJacketPressure,
                    'dceScavPressure' => (float) $request->dceScavPressure,
                    'strRemarks' => $request->strRemarks,
                    'dceLubOilPressure' => $request->dceLubOilPressure,
                    'intCreatedBy' => $intEmployeeId,
                ]);
            }
            DB::commit();
            return $voyageActivityExhtEngine;
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

            $voyageActivityRepo = new VoyageActivityRepository();
            $voyageActivity = $voyageActivityRepo->store($request);

            VoyageActivityExhtEngine::where('intID', $id)
                ->update([
                    'intVoyageActivityID' => $voyageActivity->intID,
                    'intShipEngineID' => $voyageActivity->intID,
                    'strShipEngineName' => $voyageActivity->intID,

                    'dceMainEngineFuelRPM' => (float) $request->dceMainEngineFuelRPM,
                    'dceRH' => (float) $request->dceRH,
                    'dceLoad' => (float) $request->dceLoad,
                    'dceExhtTemp1' => (float) $request->dceExhtTemp1,
                    'dceExhtTemp2' => (float) $request->dceExhtTemp2,
                    'dceJacketTemp' => (float) $request->dceJacketTemp,
                    'dceScavTemp' => (float) $request->dceScavTemp,
                    'dceLubOilTemp' => (float) $request->dceLubOilTemp,
                    'dceTCRPM' => (float) $request->dceTCRPM,
                    'dceJacketPressure' => (float) $request->dceJacketPressure,
                    'dceScavPressure' => (float) $request->dceScavPressure,
                    'strRemarks' => $request->strRemarks,
                    'dceLubOilPressure' => (float) $request->dceLubOilPressure,
                    'intCreatedBy' => $intEmployeeId,
                ]);
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show voyege activity exht by id
     *
     * @param integer $id
     * @return object voyage activity exht object
     */
    public function show($id)
    {
        $id = (int) $id;
        try {
            $voyageActivityExhtEngine = VoyageActivityExhtEngine::findOrFail($id);
            return $voyageActivityExhtEngine;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, VoyageActivityExhtEngine Not Found !');
        }
    }
}
