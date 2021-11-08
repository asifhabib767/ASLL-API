<?php

namespace Modules\Asll\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\VoyageActivityBoiler;
use Modules\Asll\Entities\VoyageActivityBoilerMain;

class VoyageActivityBoilerRepository
{
    public function getVoyageActivityBoiler()
    {
        try {
            $voyageActivityBoiler = VoyageActivityBoiler::where('ysnActive', 1)
                ->get();
            return $voyageActivityBoiler;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function storeBoilerLists(Request $request)
    {
        // add multiple in VoyageActivityBoiler
        if (count($request->boilerlists) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();
            $voyageActivityRepo = new VoyageActivityRepository();
            $voyageActivity = $voyageActivityRepo->store($request);
            // return $voyageActivity;


            $i = 1;
            foreach ($request->boilerlists as $boilerlists) {
                if ($i == 1) {
                    // Check if already an entry in VoyageActivityBoilerMain table by this date
                    $boilerMan = VoyageActivityBoilerMain::where('dteCreatedAt', $boilerlists['dteCreatedAt'])
                        ->first();

                    if (is_null($boilerMan)) {
                        $boilerMan = VoyageActivityBoilerMain::create([
                            'intVoyageActivityID' => $voyageActivity->intID,
                            'intCreatedBy' => $boilerlists['intCreatedBy'],
                            'dteCreatedAt' => $boilerlists['dteCreatedAt'],
                            'intUnitId' => $request->intUnitId,
                            'strRemarks' => $request->strRemarks,
                        ]);
                    } else {
                        VoyageActivityBoilerMain::where('intVoyageActivityID', $voyageActivity->intID)->update([
                            'intCreatedBy' => $boilerlists['intCreatedBy'],
                            'dteCreatedAt' => $boilerlists['dteCreatedAt'],
                            'intUnitId' => $request->intUnitId,
                            'strRemarks' => $request->strRemarks,
                        ]);
                        $voyageActivityBoilerMain = VoyageActivityBoilerMain::where('intVoyageActivityID', $voyageActivity->intID)->first();
                    }
                }

                $voyageActivityBoiler = VoyageActivityBoiler::create([
                    'intVoyageActivityID' => $voyageActivity->intID,
                    'intVoyageActivityBoilerMainID' => $boilerMan->intID,
                    'intUnitId' => $request->intUnitId,
                    'decWorkingPressure' => $boilerlists['decWorkingPressure'],
                    'dteCreatedAt' => $boilerlists['dteCreatedAt'],
                    'decPhValue' => $boilerlists['decPhValue'],
                    'decChloride' => $boilerlists['decChloride'],
                    'decAlkalinity' => $boilerlists['decAlkalinity'],
                    'intCreatedBy' => $boilerlists['intCreatedBy']
                ]);
                $i++;
            }
            DB::commit();
            return $boilerMan;
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

            VoyageActivityBoiler::where('intID', $id)
                ->update([
                    'intVoyageActivityID' => $voyageActivity->intID,

                    'decWorkingPressure' => (float) $request->decWorkingPressure,
                    'dteCreatedAt' => (float) $request->dteCreatedAt,
                    'decPhValue' => (float) $request->decPhValue,
                    'decChloride' => (float) $request->decChloride,
                    'decAlkalinity' => (float) $request->decAlkalinity,
                    'strRemarks' => $request->strRemarks,

                    'intCreatedBy' => $intEmployeeId,
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
            $voyageActivityBoiler = VoyageActivityBoiler::findOrFail($id);
            return $voyageActivityBoiler;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, VoyageActivityBoiler Not Found !');
        }
    }
}
