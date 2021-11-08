<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\ImageUploadHelper;
use Modules\ASLLHR\Http\Requests\UploadRequest;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AsllEmployee;
use Modules\ASLLHR\Entities\AsllEmployeePromotion;
use Modules\ASLLHR\Entities\Rank;

class ASLLEmployeePromotionRepository
{

    /**
     * add Employee promotion data
     *
     * @param $request $request
     * @return void
     */
    public function addEmployeePromotion($request)
    {
        try {
            DB::beginTransaction();
            $employee = AsllEmployee::find($request->intEmployeeID);
            $rank = Rank::find($request->intPromotedDesignationID);
            $promotionData = null;
            if (!is_null($employee)) {
                $promotionData = AsllEmployeePromotion::create(
                    [
                        'intEmployeeID' => $request->intEmployeeID,
                        'monPreviousSalary' => $employee->strAmount,
                        'monPromotedSalary' => $request->monPromotedSalary,
                        'intPreviousDesignationID' => !is_null($employee->intRankId) ? $employee->intRankId : $request->intPromotedDesignationID,
                        'intVesselId' => (int)$employee->intVesselID,
                        'intPromotedDesignationID' => $request->intPromotedDesignationID,
                        'dteEffectiveFromDate' => $request->dteEffectiveFromDate,
                        'intCurrencyId' => 1,
                        'strCurrency' => 'USD',
                        'intInsertBy' => $request->intInsertBy,
                        'dteInsertDate' => Carbon::now(),
                    ]
                );
                $employee->strAmount = $request->monPromotedSalary;
                $employee->intRankId = $request->intPromotedDesignationID;
                $employee->strRank = $request->intPromotedDesignationName;
                $employee->save();
            }

            return $promotionData;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function updateEmployeePromotion(Request $request)
    {
        try {
            $promotionData = AsllEmployeePromotion::find($request->intID);

            if (!is_null($promotionData)) {
                $promotionData = AsllEmployeePromotion::where('intID', $request->intID)
                    ->update(
                        [
                            'monPromotedSalary' => $request->monPromotedSalary,
                            'intPromotedDesignationID' => $request->intPromotedDesignationID,
                            'dteEffectiveFromDate' => $request->dteEffectiveFromDate,
                        ]
                    );
            }
            $promotionData = AsllEmployeePromotion::find($request->intID);
            return $promotionData;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteEmployeePromotion($intID)
    {
        try {
            $details = AsllEmployeePromotion::find($intID);
            if (!is_null($details)) {
                $details->delete();
            }
            return $details;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getEmployeePromotionList($intEmployeeID)
    {
        try {
            $data = AsllEmployeePromotion::where('intEmployeeID', $intEmployeeID)
                ->leftJoin('tblRank', 'tblRank.intID', '=', 'tblEmployePromotion.intPromotedDesignationID')
                ->leftJoin('tblRank as t2', 't2.intID', '=', 'tblEmployePromotion.intPreviousDesignationID')
                ->select(
                    'tblEmployePromotion.*',
                    'tblRank.strRankName as strPromotedDesignation',
                    't2.strRankName as strPreviousDesignation'
                )
                ->orderby('intID', 'desc')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
