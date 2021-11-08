<?php

namespace Modules\Item\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Asll\Entities\Vessel;
use Carbon\Carbon;

class ProductPriceRepository
{

    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function productPriceInsert($request)
    {

        try {
            DB::beginTransaction();

            DB::table(config('constants.DB_Apps') . ".tblItemPriceChangeECommerce")
                ->where('intProductId', $request->intProductId)
                ->where('intThanaID', $request->intThanaID)
                ->update([
                    'ysnActivated' => false
                ]);

            $prices = DB::table(config('constants.DB_Apps') . ".tblItemPriceChangeECommerce")
                ->insertGetId(
                    [
                        'strBatchCode' => 'cc',
                        'intProductId' => $request->intProductId,
                        'monPrice' => $request->monPrice,
                        'intInsertedBy' => 1272,
                        'dteInsertionTime' => Carbon::now(),
                        'ysnApproved1' => null,
                        'intDecession1By' => null,
                        'dteDecession1Time' => Carbon::now(),
                        'ysnApproved2' => null,
                        'intDecession2By' => null,
                        'dteDecession2Time' => Carbon::now(),
                        'dteStartTime' => Carbon::now(),
                        'intPriceCatagory' => null,
                        'dteEndTime' => null,
                        'ysnActivated' => 1,
                        'intThanaID' => $request->intThanaID,
                        'intUOMId' => 12,
                        'intCurrency' => 1,
                        'intSalesType' => 12,
                        'decMinQnt' => $request->decMinQnt,

                    ]
                );
            DB::commit();
            return $prices;
        } catch (\Exception $e) {
            return false;
        }
    }
}
