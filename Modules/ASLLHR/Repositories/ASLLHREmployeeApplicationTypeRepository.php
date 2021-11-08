<?php

namespace Modules\ASLLHR\Repositories;

use App\Helpers\Base64Encoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\ASLLHR\Entities\AsllEmployeeApplicationType;

class ASLLHREmployeeApplicationTypeRepository
{

    public function getEmployeeApplicationTypeList()
    {
        try {
            $employeeApplicationType = AsllEmployeeApplicationType::select('*')
                ->orderBy('intID', 'desc')
                ->get();
            return $employeeApplicationType;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * POST ASLL Employee Application Type
     *
     *
     * @param Request $request
     * @return void
     */
    public function createEmployeeApplicationType($request)
    {
        if (!$request) {
            throw new \Exception('No Item Found !');
        }

        try {
            DB::beginTransaction();
            $employeeApplicationTypes = DB::table(config('constants.DB_ASLL') . ".tblApplicationType")
                ->insert(
                    [
                        'strTypeName' => $request->strTypeName,
                        'ysnCRReport' => $request->ysnCRReport,
                        'created_at' => Carbon::now(),

                    ]
                );
            DB::commit();
            return $employeeApplicationTypes;
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
    public function updateEmployeeApplicationType($request)
    {
        if (!$request) {
            throw new \Exception('No Item Found !');
        }

        try {
            DB::beginTransaction();
            $employeeApplicationTypes = DB::table(config('constants.DB_ASLL') . ".tblApplicationType")
                ->where('intID', $request->intID)
                ->update(
                    [
                        'strTypeName' => $request->strTypeName,
                        'ysnCRReport' => $request->ysnCRReport,
                        'updated_at' => Carbon::now(),

                    ]
                );
            DB::commit();
            return $employeeApplicationTypes;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * deleteEmployeeApplicationType
     *
     * @param integer $intID
     * @return void
     */
    public function deleteEmployeeApplicationType($intID)
    {
        try {
            $data = DB::table(config('constants.DB_ASLL') . ".tblApplicationType")
                ->where('intID', $intID)
                ->delete();

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getEmployeeApplicationTypeSearch(Request $request)
    {
        $query = AsllEmployeeApplicationType::select('*');

        if (!is_null($request->strTypeName)) {
            $query->where('strTypeName', 'like', '%' . $request->strTypeName . '%');
        }

        $data = $query->distinct()
            ->get();
        return $data;
    }
}
