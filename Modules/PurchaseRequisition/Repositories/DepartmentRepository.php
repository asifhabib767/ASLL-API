<?php

namespace Modules\PurchaseRequisition\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentRepository
{
    public function getDepartmentAll()
    {
        $query = DB::table(config('constants.DB_HR') . ".tblDepartment");
        $output = $query->select(
            [
                'intDepartmentID as intDeptID',
                'strDepatrment as strDepartmentName'
            ]
        )
            ->get();

        return $output;
    }
}
