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

class ASLLHREmployeeReferenceRepository
{


    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeReference($request)
    {
        if (count($request) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();

            foreach ($request as $reference) {
                // return $reference;
                // $fileName = Base64Encoder::uploadBase64AsImage($reference['imageFile'], "/assets/images/asllEmployeeReference/", $reference['strCompanyName'], 'profile');
                if (isset($reference['imageFile']) && !is_null($reference['imageFile']) && $reference['imageFile'] !== "") {
                    $fileName = Base64Encoder::uploadBase64File($reference['imageFile'], "/assets/images/asllEmployeeReference/", $reference['strCompanyName'], 'profile');
                } else {
                    $fileName = null;
                }
                $data = null;
                $data =  DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeReference")->insert(
                    [
                        // Required Fields
                        "strCompanyName" => $reference['strCompanyName'],
                        "image" => $fileName,
                        "strCountry" => $reference['strCountry'],
                        "strEmail" => $reference['strEmail'],
                        "strPersonName" => $reference['strPersonName'],
                        "strTelephone" => $reference['strTelephone'],
                        "strAddress" => $reference['strAddress'],
                        "isVisa" => $reference['isVisa'],
                        "maritimeAccident" => $reference['maritimeAccident'],
                        "intUnitId" => $reference['intUnitId'],
                        "intEmployeeId" => $reference['intEmployeeId'],
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
    public function updateEmployeeReference($request)
    {
        if (!$request->intID) {
            throw new \Exception('Id Not Found !');
        }

        $image = null;
        $employees = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeReference")
            ->where('intID', $request->intID)
            ->first();

        if (!is_null($request->image)) {
            // $image = ImageUploadHelper::update('image', $request->image, $request->strName . '-' . time(), 'assets/images/asllEmployee', $request->image);
            $image = Base64Encoder::uploadBase64File($request->image, "/assets/images/asllEmployeeReference/", $request->strName, 'profile');
        } else {
            $image = null;
        }

        try {
            DB::beginTransaction();
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeReference")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strCompanyName' => $request->strCompanyName,
                        'image' => !is_null($image) ? $image : $employees->image,
                        'strCountry' => $request->strCountry,
                        'strEmail' => $request->strEmail,
                        'strPersonName' => $request->strPersonName,
                        'strTelephone' => $request->strTelephone,
                        'strAddress' => $request->strAddress,
                        'isVisa' => $request->isVisa,
                        'maritimeAccident' => $request->maritimeAccident,
                        'intEmployeeId' => $request->intEmployeeId,
                        'intUnitId' => $request->intUnitId,
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
