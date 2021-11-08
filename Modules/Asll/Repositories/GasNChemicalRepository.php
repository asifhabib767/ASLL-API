<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\GasNChemical;

use Carbon\Carbon;

class GasNChemicalRepository
{
    public function getGasNChemical()
    {
        try {
            $gasNChemical = GasNChemical::select(
                'intId',
                'strName'
            )
            ->where('ysnActive', 1)
            ->get();
            return $gasNChemical;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function storeGasNChemicalLists(Request $request)
    {
        try {
            DB::beginTransaction();
            $gasNChemical = GasNChemical::create([
                'strName'=> $request->strName,
                'dteCreatedAt'=> Carbon::now(),
                'intCreatedBy'=> $request->intCreatedBy
            ]);
        DB::commit();
        return $gasNChemical;
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

            GasNChemical::where('intID', $id)
                ->update([
                    'intVoyageActivityID'=> $voyageActivity->intID,

                    'intId'=> (float) $request->intId,
                    'dteCreatedAt'=> (float) $request->dteCreatedAt,
                    'strName'=> (float) $request->strName,

                    'intCreatedBy'=> $intEmployeeId,
                ]);

            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show voyege activity gas N Chemical by id
     *
     * @param integer $id
     * @return object voyage activity gas N Chemical object
     */
    public function show($id)
    {
        $id = (int) $id;
        try {
            $gasNChemical = GasNChemical::findOrFail($id);
            return $gasNChemical;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, GasNChemical Not Found !');
        }
    }
}
