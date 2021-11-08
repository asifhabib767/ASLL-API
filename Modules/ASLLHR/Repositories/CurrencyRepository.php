<?php

namespace Modules\ASLLHR\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\ASLLHR\Entities\Currency;
use Modules\ASLLHR\Entities\CurrencyConversion;

class CurrencyRepository
{
    public function getCurrency()
    {
        $currency = Currency::where('ysnActive', true)
            ->select('intCurrencyID', 'strCurrencyName')
            ->get();
        return $currency;
    }

        /**
     * currencyConversionPost
     *
     * @param Request $request
     * @return object Currency object which is created
     */
    public function currencyConversionPost(Request $request)
    {

        try {
            $currencyConversion = CurrencyConversion::create([
                'intConvertedFromId' => $request->intConvertedFromId,
                'intConvertedToId' => $request->intConvertedToId,
                'decUSDAmount' => $request->decUSDAmount,
                'decBDTAmount' => $request->decBDTAmount,
                'created_at' => Carbon::now()
            ]);
            return $currencyConversion;
        } catch (\Exception $e) {
            return false;
        }
    }

}
