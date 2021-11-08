<?php

namespace Modules\ASLLHR\Repositories;

use Modules\ASLLHR\Entities\VesselAccount;
use Illuminate\Http\Request;
use Modules\ASLLHR\Entities\AdditionDeductionDetails;

class AsllVesselAccountRepository
{


    public function getVesselAccountInfo($intVesselId)
    {
        try {
            $data = VesselAccount::where('intVesselId', (int)$intVesselId)
                ->orderby('intID', 'desc')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getVesselAccountTransaction($intVesselId = null)
    {
        try {
            $query = AdditionDeductionDetails::orderby('intID', 'desc');
            if (!is_null($intVesselId)) {
                $query->where('intVesselId', (int)$intVesselId);
            }

            $data = $query->where('intYear', date('Y'))
                ->where('intMonthId', date('m'))
                // ->orWhere('intMonthId', date('m') - 1)
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update Vassel Account Information by intVesselId
     *
     * @param Request $request
     * @param integer $intVesselId
     * @return object Update Vassel Account Information object
     */
    public function updateVesselAccountInfo(Request $request, $intVesselId)
    {
        try {
            $vasselAccountInfo = VesselAccount::where('intVesselId', $intVesselId)
                ->update([
                    'strVesselName' => $request->strVesselName,
                    'decBondAccountBalance' => $request->decBondAccountBalance,
                    'decCashAccountBalance' => $request->decCashAccountBalance,
                    'intCreatedBy' => $request->intCreatedBy
                ]);
            return $vasselAccountInfo;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function IncOrDecVesselAccountInfo($intVesselId, $amount, $isIncrement, $typeId)
    {
        try {
            $vac = VesselAccount::where('intVesselId', $intVesselId)->first();
            if (!is_null($vac)) {
                if($typeId == 4){
                    if($isIncrement){
                        $finalBalance = $vac->decCashAccountBalance + $amount;
                    }else{
                        $finalBalance = $vac->decCashAccountBalance - $amount;
                    }
                    $vac->decCashAccountBalance = $finalBalance;
                }else if($typeId == 1){
                    if($isIncrement){
                        $finalBalance = $vac->decBondAccountBalance + $amount;
                    }else{
                        $finalBalance = $vac->decBondAccountBalance - $amount;
                    }
                    $vac->decBondAccountBalance = $finalBalance;
                }
                $vac->save();
            }
            return $vac;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
