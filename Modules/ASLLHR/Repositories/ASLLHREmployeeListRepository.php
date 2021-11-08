<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\Base64Encoder;
use App\Helpers\ImageUploadHelper;
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use stdClass;

class ASLLHREmployeeListRepository
{


    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeBankDetails($request)
    {
        if (count($request) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();

            foreach ($request as $document) {

                $fileName = Base64Encoder::uploadBase64AsImage($document['imageFile'], "/assets/images/asllEmployeeBankDetails/", $document['strAccountHolderName'], 'document');
                $data = null;
                $data =  DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeBankDetails")->insert(
                    [
                        // Required Fields
                        "strAccountHolderName" => $document['strAccountHolderName'],
                        "strAccountNumber" => $document['strAccountNumber'],
                        "strBankName" => $document['strBankName'],
                        "strBankAddress" => $document['strBankAddress'],
                        "image" => $fileName,
                        "strSwiftCode" => $document['strSwiftCode'],
                        "intUnitId" => $document['intUnitId'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
            DB::commit();
            return $data;
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
            $image = ImageUploadHelper::update('image', $request->image, $request->strName . '-' . time(), 'assets/images/asllEmployee', $request->image);
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
                        'strPresentAddress' => $request->strPresentAddress,
                        'strPermanentAddress' => $request->strPermanentAddress,
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
