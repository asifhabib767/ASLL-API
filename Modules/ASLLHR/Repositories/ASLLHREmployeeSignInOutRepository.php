<?php

namespace Modules\ASLLHR\Repositories;

// use App\Helpers\ImageUploadHelper;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AsllEmployee;
use Modules\ASLLHR\Entities\EmployeeSignInOut;

class ASLLHREmployeeSignInOutRepository
{

    public function getEmployeeSignInOutList()
    {
        try {
            $query = EmployeeSignInOut::join(config('constants.DB_ASLL') . ".tblASLLEmployee", 'tblASLLEmployee.intID', '=', 'tblEmployeeSignInOut.intEmployeeId')
                ->join(config('constants.DB_ASLL') . ".tblVessel", 'tblVessel.intID', '=', 'tblEmployeeSignInOut.intVesselId')
                ->join(config('constants.DB_ASLL') . ".tblRank", 'tblASLLEmployee.intRankId', '=', 'tblRank.intID')
                ->orderBy('tblRank.priority', 'asc')
                ->select(
                    'tblEmployeeSignInOut.intID',
                    'tblEmployeeSignInOut.dteActionDate',
                    'tblEmployeeSignInOut.ysnSignIn',
                    'tblEmployeeSignInOut.strRemarks',
                    'tblASLLEmployee.strName',
                    'tblASLLEmployee.strRank',
                    'tblASLLEmployee.intID as intEmployeeId',
                    'tblVessel.strVesselName',
                    'tblVessel.intID as intVesselId',
                );
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

    // public function getEmployeeSignInOutList()
    // {
    //     try {
    //         $employee = EmployeeSignInOut::
    //             ->get();
    //         return $employee;
    //     } catch (\Exception $e) {
    //         return false;
    //     }
    // }


    /**
     * POST ASLL Employee
     *
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeSignInOut($request)
    {
        if (!$request) {
            throw new \Exception('No Item Found !');
        }

        if ($request->ysnSignIn == 2) {
            $request->ysnSignIn = 0;
        }
        $lastData = DB::table(config('constants.DB_ASLL') . ".tblEmployeeSignInOut")
            ->where('intEmployeeId', $request->intEmployeeId)
            ->orderBy('dteActionDate', 'desc')
            ->first();

        if ($request->ysnSignIn == 1) {
            if (!is_null($lastData)) {
                $intLastVesselId = $lastData->intVesselId;
            } else {
                $intLastVesselId = null;
            }
        } else {
            $intLastVesselId = $request->intVesselId;
        }

        try {
            DB::beginTransaction();
            $vessel = AsllEmployee::find($request->intEmployeeId);
            if ($request->ysnSignIn == 1) {
                $vessel->intVesselID = $request->intVesselId;
            } else if ($request->ysnSignIn == 0) {
                $vessel->intVesselID = null;
                // $vessel->intVesselID=v;
            }

            $vessel->save();
            $employees = DB::table(config('constants.DB_ASLL') . ".tblEmployeeSignInOut")
                ->insertGetId(
                    [
                        'intEmployeeId' => $request->intEmployeeId,
                        'intVesselId' => $request->intVesselId,
                        'dteActionDate' => $request->dteActionDate,
                        'ysnSignIn' => $request->ysnSignIn,
                        'strRemarks' => $request->strRemarks,
                        'intLastVesselId' => $intLastVesselId,
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
     *
     * @param Request $request
     * @return void
     */
    public function updateEmployeeSignInOut($request)
    {
        // return $request->all();
        if (!$request) {
            throw new \Exception('No Item Found !');
        }

        if ($request->ysnSignIn) {
            $request->ysnSignIn = 1;
        } else {
            $request->ysnSignIn = 0;
        }

        $lastData = DB::table(config('constants.DB_ASLL') . ".tblEmployeeSignInOut")
            ->where('intEmployeeId', $request->intEmployeeId)
            ->orderBy('dteActionDate', 'desc')
            ->first();

        if ($request->ysnSignIn) {
            if (!is_null($lastData)) {
                $intLastVesselId = $lastData->intVesselId;
            } else {
                $intLastVesselId = $request->intVesselId;
            }
        } else {
            $intLastVesselId = $request->intVesselId;
        }
        // return $request->all();
        try {
            DB::beginTransaction();
            $employees = DB::table(config('constants.DB_ASLL') . ".tblEmployeeSignInOut")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'intEmployeeId' => $request->intEmployeeId,
                        'intVesselId' => $request->intVesselId,
                        'dteActionDate' => $request->dteActionDate,
                        'ysnSignIn' => $request->ysnSignIn,
                        'strRemarks' => $request->strRemarks,
                        'intLastVesselId' => $intLastVesselId,
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
     * deleteEmployeeSignInOut
     *
     * @param integer $intID
     * @return void
     */
    public function deleteEmployeeSignInOut($intID)
    {
        try {
            $data = DB::table(config('constants.DB_ASLL') . ".tblEmployeeSignInOut")
                ->where('intID', $intID)
                ->delete();

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getemployeeSigningSearch(Request $request)
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
            'tblASLLEmployee.strName',
            'tblASLLEmployee.intID as intEmployeeId',
            'tblEmployeeSignInOut.*',
            'tblVessel.strVesselName',
            'tblVessel.intID as intVesselId',
            'tblASLLEmployee.strRank'
        );
        $data = $query->distinct()
            ->get();
        return $data;
    }
}
