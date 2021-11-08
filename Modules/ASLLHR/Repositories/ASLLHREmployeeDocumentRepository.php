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

class ASLLHREmployeeDocumentRepository
{


    /**
     * POST ASLL Employee
     *
     * QUERY:
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeDocument($request)
    {
        if (count($request) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();

            foreach ($request as $document) {
                $data = null;
                if (isset($document['imageFiles']) && !is_null($document['imageFiles']) && $document['imageFiles'] !== "") {
                    // $fileName = Base64Encoder::uploadBase64AsImage($document['imageFiles'], "/assets/images/asllEmployeeDocument/", $document['strType'], 'document');
                    $fileName = Base64Encoder::uploadBase64File($document['imageFiles'], "/assets/images/asllEmployeeDocument/", $document['strType'], 'document');
                } else {
                    $fileName = null;
                }

                $data =  DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeDocument")->insert(
                    [
                        // Required Fields
                        "strType" => $document['strType'],
                        "strIssueBy" => $document['strIssueBy'],
                        "strNumber" => $document['strNumber'],
                        "strIssueDate" => $document['strIssueDate'],
                        "image" => $fileName,
                        "strExpiryDate" => $document['strExpiryDate'],
                        // "strCDCNo" => $document['strCDCNo'],
                        // "strSID" => $document['strSID'],
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
    public function updateEmployeeDocument($request)
    {
        if (!$request->intID) {
            throw new \Exception('Id Not Found !');
        }


        $image = null;
        $employee = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeDocument")
            ->where('intID', $request->intID)
            ->first();


        if (!is_null($request->image)) {
            // $image = Base64Encoder::uploadBase64AsImage($request->image, "/assets/images/asllEmployeeDocument/", $request->strName, 'profile');
            $image = Base64Encoder::uploadBase64File($request->image, "/assets/images/asllEmployeeDocument/", $request->strName, 'profile');
        } else {
            $image = null;
        }

        try {
            DB::beginTransaction();

            $data = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeDocument")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strType' => $request->strType,
                        'strIssueBy' => $request->strIssueBy,
                        'strNumber' => $request->strNumber,
                        'image' => !is_null($image) ? $image : $employee->image,
                        'strIssueDate' => $request->strIssueDate,
                        'strExpiryDate' => $request->strExpiryDate,
                        'intEmployeeId' => $request->intEmployeeId,
                        'intUnitId' => $request->intUnitId,
                        // 'strCDCNo' => $request->strCDCNo,
                        // 'strSID' => $request->strSID,
                        'intTypeId' => $request->intTypeId,
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
