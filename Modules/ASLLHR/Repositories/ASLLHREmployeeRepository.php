<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\ImageUploadHelper;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AsllEmployee;

class ASLLHREmployeeRepository
{

    public function getEmployeePersonal()

    {
        try {
            $query = AsllEmployee::with('status')
                ->orderBy('intID', 'asc');
            if (request()->intVesselId) {
                $query->where('intVesselID', request()->intVesselId);
            }
            $employees = $query->get();
            return $employees;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Employee List for DropDown lists
     */

    public function getEmployeeDropdownList()

    {
        try {
            $query = AsllEmployee::orderBy('intID', 'asc')
                // ->where('intVesselId','!=',null)
                ->select('intID','strName','intVesselID','strCDCNo');
            if (request()->intVesselId) {
                $query->where('intVesselID', request()->intVesselId);
            }
            $employees = $query->get();
            return $employees;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * POST ASLL Employee
     *
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeePersonal($request)
    {
        if (!is_null($request->image)) {
            $fileName = Base64Encoder::uploadBase64AsImage($request->image, "/assets/images/asllEmployee/", $request->strName, 'profile');
        } else {
            $fileName = null;
        }
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
                        'intRankId' => $request->intRankId,
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
                        'strCDCNo' => $request->strCDCNo,
                        'strCurrency' => $request->strCurrency,
                        'strAmount' => $request->strAmount,
                        'strBoilersuit' => $request->strBoilersuit,
                        'strSafetyShoes' => $request->strSafetyShoes,
                        'strUniformShirt' => $request->strUniformShirt,
                        'strUniformTrouser' => $request->strUniformTrouser,
                        'strWinterJacket' => $request->strWinterJacket,
                        'strRemarks' => $request->strRemarks,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]
                );
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            if ($e->getCode() == 2300) {
                throw new \Exception("Duplicate");
            } else {
                return false;
            }
        }
    }


    /**
     * hello
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
        $employee = DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
            ->where('intID', $request->intID)
            ->first();
        if (!is_null($request->image)) {
            $image = Base64Encoder::uploadBase64AsImage($request->image, "/assets/images/asllEmployee/", $request->strName, 'profile');
        } else {
            $image = null;
        }

        try {
            DB::beginTransaction();
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strName' => $request->strName,
                        'image' => !is_null($image) ? $image : $employee->image,
                        'strBirthdate' => $request->strBirthdate,
                        'strHomeTelephone' => $request->strHomeTelephone,
                        'strRank' => $request->strRank,
                        'intRankId' => $request->intRankId,
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
                        'intAirportId' => $request->intAirportId,
                        'strCDCNo' => $request->strCDCNo,
                        'strCurrency' => $request->strCurrency,
                        'intCurrencyId' => $request->intCurrencyId,
                        'strAmount' => $request->strAmount,
                        'strBoilersuit' => $request->strBoilersuit,
                        'strSafetyShoes' => $request->strSafetyShoes,
                        'strUniformShirt' => $request->strUniformShirt,
                        'strUniformTrouser' => $request->strUniformTrouser,
                        'strWinterJacket' => $request->strWinterJacket,
                        'strRemarks' => $request->strRemarks,
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

    public function getEmployeePersonalDetails($intID)
    {
        try {
            $employee = AsllEmployee::where('intID', $intID)
                ->with('certificates', 'documents', 'bankdetails', 'educations', 'records', 'references', 'vessel')
                ->first();

            return $employee;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Single Employee Details
     */

    public function getEmployeeDetails($intID)
    {
        try {
            $employee = AsllEmployee::where('intID', $intID)
                ->first();

            return $employee;
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
            DB::beginTransaction();
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployee")
                ->where('intID', $id)
                ->delete();

            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeEducation")
                ->where('intEmployeeId', $id)
                ->delete();

            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeRecord")
                ->where('intEmployeeId', $id)
                ->delete();

            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeDocument")
                ->where('intEmployeeId', $id)
                ->delete();
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeCertificate")
                ->where('intEmployeeId', $id)
                ->delete();
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeBankDetails")
                ->where('intEmployeeId', $id)
                ->delete();
            DB::table(config('constants.DB_ASLL') . ".tblASLLEmployeeReference")
                ->where('intEmployeeId', $id)
                ->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getemployeeSearch(Request $request)
    {
        $query = AsllEmployee::rightJoin(config('constants.DB_ASLL') . ".tblEmployeeSignInOut", 'tblEmployeeSignInOut.intEmployeeId', '=', 'tblASLLEmployee.intID')
            ->rightJoin(config('constants.DB_ASLL') . ".tblVessel", 'tblEmployeeSignInOut.intVesselId', '=', 'tblVessel.intID');


        if (!is_null($request->vesselId) && $request->vesselId > 0) {
            $query->where('tblEmployeeSignInOut.intVesselId', $request->vesselId);
        }
        if (!is_null($request->employeeName)) {
            $query->where('tblASLLEmployee.strName', 'like', '%' . $request->employeeName . '%')
                ->orWhere('tblVessel.strVesselName', 'like', '%' . $request->employeeName . '%')
                ->orWhere('tblVessel.strEngineName', 'like', '%' . $request->employeeName . '%')
                ->orWhere('tblASLLEmployee.strHomeTelephone', 'like', '%' . $request->employeeName . '%')
                ->orWhere('tblASLLEmployee.strEmail', 'like', '%' . $request->employeeName . '%')
                ->orWhere('tblVessel.strYardCountryName', 'like', '%' . $request->employeeName . '%')
                ->orWhere('tblASLLEmployee.strRank', 'like', '%' . $request->employeeName . '%')
                ->orWhere('tblASLLEmployee.strCDCNo', 'like', '%' . $request->employeeName . '%');
        }
        $query->select(
            'tblASLLEmployee.*',
        );

        $query->with('status');

        if (request()->intVesselId) {
            $query->where('tblasllemployee.intVesselID', request()->intVesselId);
        }

        $data = $query->distinct()
            ->get();
        return $data;
    }


    /**
     * getLastVesselId
     *
     * @param integer $intEmployeeId
     * @return object
     */
    public function getLastVesselIdByEmployeeId($intEmployeeId)
    {
        $data = DB::table(config('constants.DB_ASLL') . ".tblEmployeeSignInOut")
            ->where('intEmployeeId', $intEmployeeId)
            ->orderBy('dteActionDate', 'desc')
            ->first();
        return  $data;
    }
}
