<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\Base64Encoder;
use App\Helpers\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AsllEmployee;
use stdClass;

class ASLLHREmployeeBankDetailsRepository
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
        // return $request;
        if (count($request) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();
            foreach ($request as $document) {
                // if (!is_null($document['imageFile'])) {
                //     $fileName = Base64Encoder::uploadBase64AsImage($document['imageFile'], "/assets/images/asllEmployeeBankDetails/", $document['strAccountHolderName'], 'document');
                // }

                if (isset($document['imageFile']) && !is_null($document['imageFile']) && $document['imageFile'] !== "") {
                    $fileName = Base64Encoder::uploadBase64File($document['imageFile'], "/assets/images/asllEmployeeBankDetails/", $document['strAccountHolderName'], 'document');
                } else {
                    $fileName = null;
                }
                $data = null;

                // Set All other Accounts as defaultAccounts to false
                if($document['ysnDefaultAccount']){
                    DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeBankDetails")
                    ->where('intEmployeeId', $document['intEmployeeId'])
                    ->update([
                        'ysnDefaultAccount' => false
                    ]);
                }

                $data =  DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeBankDetails")
                ->insert(
                    [
                        // Required Fields
                        "strAccountHolderName" => $document['strAccountHolderName'],
                        "strAccountNumber" => $document['strAccountNumber'],
                        "strBankName" => $document['strBankName'],
                        "strBankAddress" => $document['strBankAddress'],
                        // "image" => $fileName,
                        "image" => $fileName,
                        "strSwiftCode" => $document['strSwiftCode'],
                        "intUnitId" => $document['intUnitId'],
                        "intEmployeeId" => $document['intEmployeeId'],
                        "strRoutingNumber" => $document['strRoutingNumber'],
                        "strPaidCurrencyName" => $document['strPaidCurrencyName'],
                        "intPaidCurrencyID" => $document['intPaidCurrencyID'],
                        "ysnDefaultAccount" => $document['ysnDefaultAccount'],
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
     * POST ASLL Employee Document
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function updateEmployeeBankDetails($request)
    {
        if (!$request->intID) {
            throw new \Exception('Id Not Found !');
        }


        $image = null;
        $employee = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeBankDetails")
            ->where('intID', $request->intID)
            ->first();


        if (!is_null($request->image)) {
            // $image = Base64Encoder::uploadBase64AsImage($request->image, "/assets/images/asllEmployeeBankDeatails/", $request->strName, 'profile');
            $image = Base64Encoder::uploadBase64File($request->image, "/assets/images/asllEmployeeBankDeatails/", $request->strName, 'profile');
        } else {
            $image = $employee->image;
        }

        try {
            DB::beginTransaction();

            $data = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeBankDetails")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strAccountHolderName' => $request->strAccountHolderName,
                        'strAccountNumber' => $request->strAccountNumber,
                        'image' => !is_null($image) ? $image : $employee->image,
                        'strBankName' => $request->strBankName,
                        'strBankAddress' => $request->strBankAddress,
                        'strSwiftCode' => $request->strSwiftCode,
                        'intEmployeeId' => $request->intEmployeeId,
                        'strRoutingNumber' => $request->strRoutingNumber,
                        'ysnDefaultAccount' => $request->ysnDefaultAccount,
                        'intPaidCurrencyID' => $request->intPaidCurrencyID,
                        'strPaidCurrencyName' => $request->strPaidCurrencyName,
                        'intUnitId' => $request->intUnitId,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]
                );


            DB::commit();
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Delete ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function deleteEmployee($id)
    {
        if (!$id) {
            throw new \Exception('Id Not Found !');
        }

        try {
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeBankDetails")
                ->where('intID', $id)
                ->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
