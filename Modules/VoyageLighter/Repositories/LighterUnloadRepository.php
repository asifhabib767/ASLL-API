<?php

namespace Modules\VoyageLighter\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\VoyageLighter\Entities\LighterLoadingPoint;
use Modules\VoyageLighter\Entities\LighterUnload;
use Modules\VoyageLighter\Entities\LighterUnloadCategory;
use Modules\VoyageLighter\Entities\LighterUnloadDetails;

class LighterUnloadRepository
{
    public function getVesselTypeOrPointType($intVesselTypeOrPointTypeID = null)
    {
        if (is_null($intVesselTypeOrPointTypeID)) {
            return LighterLoadingPoint::all();
        }

        $loadingpointList = LighterLoadingPoint::where('intVesselTypeOrPointTypeID', $intVesselTypeOrPointTypeID)
            ->get();
        return $loadingpointList;
    }

    public function postlighterVoyageUnloadNStockQntStore(Request $request)
    {
        try {
            $decTotal = 0;
            foreach ($request->unloadData as $ud) {
                $decTotal += $ud['decQnt'];
            }
            $lighterUnload = LighterUnload::create([
                'dteDate' => $request->dteDate,
                'dteInsertDate' => Carbon::now(),
                'intTypeID' => $request->intTypeID,
                'strTypeName' => $request->strTypeName,
                'intCategoryId' => $request->intCategoryId,
                'strCategoryName' => $request->strCategoryName,
                'GrandTotal' => $decTotal,
                'intInsertBy' => $request->intInsertBy,
                'ysnActive' => 1,
            ]);

            foreach ($request->unloadData as $voyageLighter) {
                // Check if already an entry in VoyageLighterMain table
                // $lighter = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->first();

                $lighterUnloadDetails = LighterUnloadDetails::create([
                    'intUnloadNStandByQntPKId' => $lighterUnload->intID,
                    'intItemID' => $voyageLighter['intItemID'],
                    'strItemName' => $voyageLighter['strItemName'],
                    'decQnt' => $voyageLighter['decQnt'],
                    'intTypeId' => $voyageLighter['intTypeId']
                ]);
            }
            return $lighterUnloadDetails;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getLighterUnloadCategory()
    {
        $unloadCatgList = LighterUnloadCategory::where('ysnActive', 1)
            ->get();
        return $unloadCatgList;
    }
    public function getLighterUnload($dteStartDate, $dteEndDate)
    {
        try {
            $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(7) :  $dteStartDate;
            $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate;

            $lighterUnload = LighterUnload::whereBetween('dteDate', [$startDate, $endDate])
                ->select(
                    DB::raw('SUM(GrandTotal) as GrandTotal'),
                    'dteDate'
                )
                ->orderBy('dteDate', 'desc')
                ->groupBy('dteDate')
                ->get();
            $data = [];
            foreach ($lighterUnload as $singleData) {
                $singleDataNew = [[
                    'dteDate' => $singleData->dteDate,
                    'GrandTotal' => (float) $singleData->GrandTotal,
                    'decUnloadingGrandTotal' => (float) $this->getGrandTotalByDateAndCategory($singleData->dteDate, 1),
                    'decStandByGrandTotal' => (float) $this->getGrandTotalByDateAndCategory($singleData->dteDate, 2),
                    'decStockGrandTotal' => (float) $this->getGrandTotalByDateAndCategory($singleData->dteDate, 3),
                ]];
                array_push($data, $singleDataNew[0]);
            }
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getGrandTotalByDateAndCategory($date, $category)
    {
        return LighterUnload::where('dteDate', $date)
            ->where('intCategoryId', $category)
            ->value('GrandTotal');
    }
}
