<?php

namespace Modules\PurchaseRequisition\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemRepository
{
    public function getItemsByItemByUnitId($intUnitID)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblItemList");
        $output = $query->select(
            [
                'intItemID',
                'strItemName',
                'strDescription',
                'strCategory',
                'strSubCategory',
                'intCategoryID',
                'intWH'
            ]
        )
            ->where('tblItemList.ysnActive', true)
            ->where('tblItemList.intUnitID', $intUnitID)
            ->get();

        return $output;
    }

    public function getItemAll()
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblItemList");
        $output = $query->select(
            [
                'intItemID',
                'strItemName',
                'strDescription',
                'strCategory',
                'strSubCategory',
                'intCategoryID',
                'intWH'
            ]
        )
            ->where('tblItemList.ysnActive', true)
            ->get();

        return $output;
    }
}
