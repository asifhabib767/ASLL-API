<?php

namespace Modules\Accounts\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostCenterRepository
{
    public function getCostCenterByUnitId($intUnitID)
    {
        $query = DB::table(config('constants.DB_Accounts') . ".tblCostCenter");
        $output = $query->select(
            [
                'intCostCenterID',
                'intCCGroupID',
                'intParentID',
                'intCCCode',
                'strCCName',
                'intGLCode',
                'ysnActive',
                'ysnTransHead',
                'intLastActionBy',
                'dteLastActionTime',
                'intWHID',
                'intProfitCenterId'
            ]
        )
            ->where('tblCostCenter.ysnActive', true)
            ->where('tblCostCenter.intUnitID', $intUnitID)
            ->get();

        return $output;
    }
}
