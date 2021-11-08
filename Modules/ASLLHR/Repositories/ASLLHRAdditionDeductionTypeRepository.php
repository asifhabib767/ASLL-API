<?php

namespace Modules\ASLLHR\Repositories;

// use App\Helpers\ImageUploadHelper;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AsllEmployee;

class ASLLHRAdditionDeductionTypeRepository
{

    public function getAdditionDeductionTypeList()
    {
        try {
            $additionDeduction = DB::table(config('constants.DB_ASLL') . ".tblAdditionDeductionType")
            ->where('ysnActive',true)
            ->orderBy('priority','asc')
                ->select(
                    'intID',
                    'strTypeName',
                    'ysnAddition',
                    'intUnitId'
                )
                ->get();
            return $additionDeduction;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeePersonal($request)
    {
        // if (!isset($request->image)) {
        $fileName = Base64Encoder::uploadBase64AsImage($request->image, "/assets/images/asllEmployee/", $request->strName, 'profile');
        // $fileName = null;
        // }
        try {
            DB::beginTransaction();
            $employees = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
                ->insertGetId(
                    [
                        'strName' => $request->strName,
                        'image' => $fileName,
                        'strBirthdate' => $request->strBirthdate,
                        'strHomeTelephone' => $request->strHomeTelephone,
                        'strRank' => $request->strRank,
                        'strAvailabilityDate' => $request->strAvailabilityDate,
                        'strEmail' => $request->strEmail,
                        'strHeight' => $request->strHeight,
                        'strWeight' => $request->strWeight,
                        'strNationality' => $request->strNationality,
                        'strEmgrPersonalTel' => $request->strEmgrPersonalTel,
                        'strEmgrPersonName' => $request->strEmgrPersonName,
                        'strEmgrPersonRelation' => $request->strEmgrPersonRelation,
                        'strEmgrPersonAddress' => $request->strEmgrPersonAddress,
                        'strTradingArea' => $request->strTradingArea,
                        'strCargoCarried' => $request->strCargoCarried,
                        'strNearestAirport' => $request->strNearestAirport,
                        'strCurrency' => $request->strCurrency,
                        'strAmount' => $request->strAmount,
                        'strBoilersuit' => $request->strBoilersuit,
                        'strSafetyShoes' => $request->strSafetyShoes,
                        'strUniformShirt' => $request->strUniformShirt,
                        'strUniformTrouser' => $request->strUniformTrouser,
                        'strWinterJacket' => $request->strWinterJacket,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]
                );
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function updateEmployeePersonal($request)
    {
        if (!$request->intID) {
            throw new \Exception('Id Not Found !');
        }

        $image = null;
        $employees = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
            ->where('intID', $request->intID)
            ->first();

        if (!is_null($request->image)) {
            $image = ImageUploadHelper::update('image', $request->image, $request->strName . '-' . time(), 'assets/images/asllEmployeeEducation', $request->image);
        }



        try {
            DB::beginTransaction();
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strName' => $request->strName,
                        'image' => $image,
                        'strBirthdate' => $request->strBirthdate,
                        'strHomeTelephone' => $request->strHomeTelephone,
                        'strRank' => $request->strRank,
                        'strAvailabilityDate' => $request->strAvailabilityDate,
                        'strEmail' => $request->strEmail,
                        'strHeight' => $request->strHeight,
                        'strWeight' => $request->strWeight,
                        'strNationality' => $request->strNationality,
                        'strEmgrPersonalTel' => $request->strEmgrPersonalTel,
                        'strEmgrPersonName' => $request->strEmgrPersonName,
                        'strEmgrPersonRelation' => $request->strEmgrPersonRelation,
                        'strEmgrPersonAddress' => $request->strEmgrPersonAddress,
                        'strTradingArea' => $request->strTradingArea,
                        'strCargoCarried' => $request->strCargoCarried,
                        'strNearestAirport' => $request->strNearestAirport,
                        'strBoilersuit' => $request->strBoilersuit,
                        'strSafetyShoes' => $request->strSafetyShoes,
                        'strUniformShirt' => $request->strUniformShirt,
                        'strUniformTrouser' => $request->strUniformTrouser,
                        'strWinterJacket' => $request->strWinterJacket,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]
                );
            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
