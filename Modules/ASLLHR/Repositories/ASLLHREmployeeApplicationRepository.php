<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AsllEmployeeApplication;

class ASLLHREmployeeApplicationRepository
{

    public function getEmployeeApplicationList()
    {
        try {
            $query = AsllEmployeeApplication::leftJoin('tblApplicationType', 'tblApplicationType.intID', 'tblApplication.intApplicationTypeId')
                ->leftJoin('tblasllemployee', 'tblasllemployee.intID', 'tblApplication.intEmployeeId')
                ->leftJoin('tblRank', 'tblRank.intID', 'tblApplication.intRankId')
                ->leftJoin('tblVessel', 'tblVessel.intID', 'tblApplication.intVesselId')
                ->select('tblApplication.*', 'tblApplicationType.strTypeName as strTypeName', 'tblasllemployee.strName as strEmployeeName', 'tblRank.strRankName as strRankName', 'tblVessel.strVesselName as strVesselName')
                ->orderBy('tblApplication.intID', 'desc');
            $data = [];
            if (request()->isPaginated) {
                $paginateNo = request()->paginateNo ? request()->paginateNo : 20;
                $data = $query->paginate($paginateNo);
            } else {
                $data = $query->get();
            }
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * POST ASLL Employee Application
     *
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeApplication($request)
    {
        if (!$request) {
            throw new \Exception('No Item Found !');
        }

        try {
            DB::beginTransaction();
            $employeeApplications = DB::table(config('constants.DB_ASLL') . ".tblApplication")
                ->insertGetId(
                    [
                        'intApplicationTypeId' => $request->intApplicationTypeId,
                        'intEmployeeId' => $request->intEmployeeId,
                        'intRankId' => $request->intRankId,
                        'intVesselId' => $request->intVesselId,
                        'strReceiverName' => $request->strReceiverName,
                        'dteFromDate' => $request->dteFromDate,
                        'strPortName' => $request->strPortName,
                        'strApplicationBody' => $request->strApplicationBody,
                        'strCommencementTenure' => $request->strCommencementTenure,
                        'dteDateOfCompletion' => $request->dteDateOfCompletion,
                        'dteExtensionRequested' => $request->dteExtensionRequested,
                        'dteRejoiningDate' => $request->dteRejoiningDate,
                        'strRemarks' => $request->strRemarks,
                        'strApplicationSubject' => $request->strApplicationSubject,
                        'created_at' => Carbon::now(),

                    ]
                );
            DB::commit();
            return $employeeApplications;
        } catch (\Exception $e) {

            return false;
        }
    }


    /**
     * Update ASLL Employee Application
     *
     *
     * @param Request $request
     * @return void
     */
    public function updateEmployeeApplication($request)
    {
        if (!$request) {
            throw new \Exception('No Item Found !');
        }

        try {
            DB::beginTransaction();
            $employeeApplications = DB::table(config('constants.DB_ASLL') . ".tblApplication")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'intApplicationTypeId' => $request->intApplicationTypeId,
                        'intEmployeeId' => $request->intEmployeeId,
                        'intRankId' => $request->intRankId,
                        'intVesselId' => $request->intVesselId,
                        'strReceiverName' => $request->strReceiverName,
                        'dteFromDate' => $request->dteFromDate,
                        'strPortName' => $request->strPortName,
                        'strApplicationBody' => $request->strApplicationBody,
                        'strCommencementTenure' => $request->strCommencementTenure,
                        'dteDateOfCompletion' => $request->dteDateOfCompletion,
                        'dteExtensionRequested' => $request->dteExtensionRequested,
                        'dteRejoiningDate' => $request->dteRejoiningDate,
                        'strRemarks' => $request->strRemarks,
                        'strApplicationSubject' => $request->strApplicationSubject,
                        'updated_at' => Carbon::now(),


                    ]
                );
            DB::commit();
            return $employeeApplications;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * deleteEmployeeApplication
     *
     * @param integer $intID
     * @return void
     */
    public function deleteEmployeeApplication($intID)
    {
        try {
            $data = DB::table(config('constants.DB_ASLL') . ".tblApplication")
                ->where('intID', $intID)
                ->delete();

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getEmployeeApplicationSearch(Request $request)
    {
        $query = AsllEmployeeApplication::select('*');

        if (!is_null($request->strReceiverName)) {
            $query->where('strReceiverName', 'like', '%' . $request->strReceiverName . '%');
        }

        if (!is_null($request->intApplicationTypeId)) {
            $query->where('intApplicationTypeId', '=', $request->intApplicationTypeId);
        }

        if (!is_null($request->intEmployeeId)) {
            $query->where('intEmployeeId', '=', $request->intEmployeeId);
        }

        $data = $query->distinct()
            ->get();
        return $data;
    }

    public function getById($intEmployeeApplicationId)
    {
        // $intEmployeeApplicationId = Crypt::decryptString($intEmployeeApplicationId);
        return AsllEmployeeApplication::find($intEmployeeApplicationId);
    }
}
