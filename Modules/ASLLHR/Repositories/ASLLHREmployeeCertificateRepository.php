<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\Certificates;

class ASLLHREmployeeCertificateRepository
{


    /**
     * Get Employee Certificate List
     */


    public function getEmployeeCertificateList()
    {
        try {
            $employee = Certificates::orderBy('intID', 'desc')->get();
            return $employee;
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
    public function createEmployeeCertificate($request)
    {
        if (count($request) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();

            foreach ($request as $document) {

                // $fileName = Base64Encoder::uploadBase64AsImage($document['imageFile'], "/assets/images/asllEmployeeCertificate/", $document['strCourseName'], 'document');
                if (isset($document['imageFile']) && !is_null($document['imageFile']) && $document['imageFile'] !== "") {
                    $fileName = Base64Encoder::uploadBase64File($document['imageFile'], "/assets/images/asllEmployeeCertificate/", $document['strCourseName'], 'document');
                } else {
                    $fileName = null;
                }

                $data = null;
                $data =  DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeCertificate")->insert(
                    [
                        // Required Fields
                        "strCourseName" => $document['strCourseName'],
                        "strIssueBy" => $document['strIssueBy'],
                        "strNumber" => $document['strNumber'],
                        "strIssueDate" => $document['strIssueDate'],
                        "image" => $fileName,
                        "strExpiryDate" => $document['strExpiryDate'],
                        "intEmployeeId" => $document['intEmployeeId'],
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
     * POST ASLL Employee Document
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function updateEmployeeCertificate($request)
    {

        if (!$request->intID) {
            throw new \Exception('Id Not Found !');
        }


        $image = null;
        $employee = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeCertificate")
            ->where('intID', $request->intID)
            ->first();


        if (!is_null($request->image)) {
            // $image = Base64Encoder::uploadBase64AsImage($request->image, "/assets/images/asllEmployeeCertificate/", $request->strName, 'profile');
            $image = Base64Encoder::uploadBase64File($request->image, "/assets/images/asllEmployeeCertificate/", $request->strName, 'profile');
        } else {
            $image = null;
        }

        try {
            DB::beginTransaction();

            $data = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeCertificate")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strIssueBy' => $request->strIssueBy,
                        'strNumber' => $request->strNumber,
                        'strCourseName' => $request->strCourseName,
                        'intCourseId' => $request->intCourseId,
                        'image' => !is_null($image) ? $image : $employee->image,
                        'strIssueDate' => $request->strIssueDate,
                        'strExpiryDate' => $request->strExpiryDate,
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
