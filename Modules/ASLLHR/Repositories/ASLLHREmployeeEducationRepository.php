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

class ASLLHREmployeeEducationRepository
{


    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeEducation($request)
    {
        if (count($request) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();

            foreach ($request as $education) {
                // $fileName = UploadHelper::upload('imageFiles', $education['imageFiles'], time(), '/assets/images/asllEmployeeEducation/');
                // $fileName = Base64Encoder::uploadBase64File($education['imageFiles'], "/assets/images/asllEmployeeEducation/", $education['strCertification'], 'education');
                if (isset($education['imageFiles']) && !is_null($education['imageFiles']) && $education['imageFiles'] !== "") {
                    // $fileName = Base64Encoder::uploadBase64AsImage($education['imageFiles'], "/assets/images/asllEmployeeEducation/", $education['strCertification'], 'education');
                    $fileName = Base64Encoder::uploadBase64File($education['imageFiles'], "/assets/images/asllEmployeeEducation/", $education['strCertification'], 'education');
                } else {
                    $fileName = null;
                }
                $data = null;
                $data =  DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeEducation")->insert(
                    [
                        // Required Fields
                        "strCertification" => $education['strCertification'],
                        "strInstitution" => $education['strInstitution'],
                        "strYear" => $education['strYear'],
                        "strResult" => $education['strResult'],
                        "image" => $fileName,
                        "intEmployeeId" => $education['intEmployeeId'],
                        "intUnitId" => $education['intUnitId'],
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
    public function updateEmployeeEducation($request)
    {
        if (!$request->intID) {
            throw new \Exception('Id Not Found !');
        }
        $image = null;
        $employee = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeEducation")
            ->where('intID', $request->intID)
            ->first();


        if (!is_null($request->image)) {
            // $image = Base64Encoder::uploadBase64AsImage($request->image, "/assets/images/asllEmployee/", $request->strName, 'profile');
            $image = Base64Encoder::uploadBase64File($request->image, "/assets/images/asllEmployee/", $request->strName, 'profile');
        } else {
            $image = null;
        }

        try {
            DB::beginTransaction();

            $data = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeEducation")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strCertification' => $request->strCertification,
                        'image' => !is_null($image) ? $image : $employee->image,
                        'strInstitution' => $request->strInstitution,
                        'strYear' => $request->strYear,
                        'strResult' => $request->strResult,
                        'intEmployeeId' => $request->intEmployeeId,
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
}
