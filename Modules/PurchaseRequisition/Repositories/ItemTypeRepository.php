<?php

namespace Modules\PurchaseRequisition\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemTypeRepository
{
    public function getItemTypesAll()
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblItemType");
        $output = $query->select(
            [
                'intItemTypeID',
                'strItemTypeName'
            ]
        )
            ->where('tblItemType.ysnActive', true)
            ->get();

        return $output;
    }
}
