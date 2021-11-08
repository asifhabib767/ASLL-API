<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\Voyage;
use Modules\Asll\Entities\VoyageActivity;
use Modules\Asll\Entities\VoyageActivityVlsf;

class VoyageActivityVlsfRepository
{
    public function getVoyageActivityVlsf()
    {
        try {
            $voyageActivityVlsf = VoyageActivityVlsf::where('ysnActive', 1)
                ->get();
            return $voyageActivityVlsf;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new VoyageActivityVlsf to VoyageActivityVlsf
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function store(Request $request)
    {
        $intEmployeeId = 1;
        try {
            // Create Voyage Activity Vlsfo
            DB::beginTransaction();

            // Check if this date already exist in voyage activity
            $voyageActivityRepo = new VoyageActivityRepository();
            $voyageRepo = new VoyageRepository();
            $voyageActivity = $voyageActivityRepo->store($request);

            $voyageActivityVlsf = VoyageActivityVlsf::where('intVoyageActivityID', $voyageActivity->intID)->first();
            $voyage = $voyageRepo->show($voyageActivity->intVoyageID);

            if (is_null($voyageActivityVlsf)) {
                // $voyage = Voyage::where('intID', $voyageActivity->intVoyageID)->update([
                //     'intVlsfoRob' => 100,
                //     'intLsmgRob' => 100,
                //     'intLubOilRob' => 100,
                //     'intMeccRob' => 100,
                //     'intAeccRob' => 100,
                // ]);

                $voyageActivityVlsf = VoyageActivityVlsf::create([
                    'intVoyageActivityID' => $voyageActivity->intID,
                    'decBunkerVlsfoCon' => (float) $request->decBunkerVlsfoCon,
                    'decBunkerVlsfoAdj' => (float) $request->decBunkerVlsfoAdj,
                    'decBunkerVlsfoRob' => (float) $request->decBunkerVlsfoRob,
                    'decBunkerLsmgoCon' => (float) $request->decBunkerLsmgoCon,
                    'decBunkerLsmgoAdj' => (float) $request->decBunkerLsmgoAdj,
                    'decBunkerLsmgoRob' => (float) $request->decBunkerLsmgoRob,
                    'decLubMeccCon' => (float) $request->decLubMeccCon,
                    'decLubMeccAdj' => (float) $request->decLubMeccAdj,
                    'decLubMeccRob' => (float) $request->decLubMeccRob,
                    'decLubMecylCon' => (float) $request->decLubMecylCon,
                    'decLubMecylAdj' => (float) $request->decLubMecylAdj,
                    'decLubMecylRob' => (float) $request->decLubMecylRob,
                    'decLubAeccCon' => (float) $request->decLubAeccCon,
                    'decLubAeccAdj' => (float) $request->decLubAeccAdj,
                    'decLubAeccRob' => (float) $request->decLubAeccRob,
                    'strRemarks' => $request->strRemarks,
                    'intCreatedBy' => $request->intEmployeeId ? $request->intEmployeeId : null,
                    'ysnActive' => 1,
                ]);
            } else {
                VoyageActivityVlsf::where('intVoyageActivityID', $voyageActivity->intID)->update([
                    'decBunkerVlsfoCon' => (float) $request->decBunkerVlsfoCon,
                    'decBunkerVlsfoAdj' => (float) $request->decBunkerVlsfoAdj,
                    'decBunkerVlsfoRob' => (float) $request->decBunkerVlsfoRob,
                    'decBunkerLsmgoCon' => (float) $request->decBunkerLsmgoCon,
                    'decBunkerLsmgoAdj' => (float) $request->decBunkerLsmgoAdj,
                    'decBunkerLsmgoRob' => (float) $request->decBunkerLsmgoRob,
                    'decLubMeccCon' => (float) $request->decLubMeccCon,
                    'decLubMeccAdj' => (float) $request->decLubMeccAdj,
                    'decLubMeccRob' => (float) $request->decLubMeccRob,
                    'decLubMecylCon' => (float) $request->decLubMecylCon,
                    'decLubMecylAdj' => (float) $request->decLubMecylAdj,
                    'decLubMecylRob' => (float) $request->decLubMecylRob,
                    'decLubAeccCon' => (float) $request->decLubAeccCon,
                    'decLubAeccAdj' => (float) $request->decLubAeccAdj,
                    'decLubAeccRob' => (float) $request->decLubAeccRob,
                    'strRemarks' => $request->strRemarks,
                ]);
                $voyageActivityVlsf = VoyageActivityVlsf::where('intVoyageActivityID', $voyageActivity->intID)->first();
            }

            $voyage->update([
                'intVlsfoRob' => (int)$request->decBunkerVlsfoRob,
                'intLsmgRob' => (int)$request->decBunkerLsmgoRob,
                'intLubOilRob' => (int)$request->decLubMeccRob,
                'intMeccRob' => (int)$request->decLubMecylRob,
                'intAeccRob' => (int)$request->decLubAeccRob,
            ]);

            DB::commit();
            return $voyageActivityVlsf;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * update vessel by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated vessel object
     */
    public function update(Request $request, $id)
    {
        $intEmployeeId = 1;
        try {

            DB::beginTransaction();

            $voyageActivityRepo = new VoyageActivityRepository();
            $voyageActivity = $voyageActivityRepo->store($request);

            VoyageActivityVlsf::where('intID', $id)
                ->update([
                    'intVoyageActivityID' => $voyageActivity->intID,

                    'decBunkerVlsfoCon' => (float) $request->decBunkerVlsfoCon,
                    'decBunkerVlsfoAdj' => (float) $request->decBunkerVlsfoAdj,
                    'decBunkerVlsfoRob' => (float) $request->decBunkerVlsfoRob,
                    'decBunkerLsmgoCon' => (float) $request->decBunkerLsmgoCon,
                    'decBunkerLsmgoAdj' => (float) $request->decBunkerLsmgoAdj,
                    'decBunkerLsmgoRob' => (float) $request->decBunkerLsmgoRob,
                    'decLubMeccCon' => (float) $request->decLubMeccCon,
                    'decLubMeccAdj' => (float) $request->decLubMeccAdj,
                    'decLubMeccRob' => (float) $request->decLubMeccRob,
                    'decLubMecylCon' => (float) $request->decLubMecylCon,
                    'decLubMecylAdj' => (float) $request->decLubMecylAdj,
                    'decLubMecylRob' => (float) $request->decLubMecylRob,
                    'decLubAeccCon' => (float) $request->decLubAeccCon,
                    'decLubAeccAdj' => (float) $request->decLubAeccAdj,
                    'decLubAeccRob' => (float) $request->decLubAeccRob,
                    'strRemarks' => (float) $request->strRemarks,
                    'intCreatedBy' => $request->intEmployeeId ? $request->intEmployeeId : null,
                ]);

            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show voyege activity vlsfo by id
     *
     * @param integer $id
     * @return object voyage activity vlsfo object
     */
    public function show($id)
    {
        $id = (int) $id;
        try {
            $voyageActivityVlsf = VoyageActivityVlsf::findOrFail($id);
            return $voyageActivityVlsf;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, VoyageActivityVlsf update Not Found !');
        }
    }
}
