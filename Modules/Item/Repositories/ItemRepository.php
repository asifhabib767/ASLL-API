<?php

namespace Modules\Item\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Item\Entities\Item;

class ItemRepository
{
    public function getFuelItems($intUnitID, $intCategoryID, $search)
    {
        $query = Item::where('intUnitID', $intUnitID)
        // ->select(
        //     'strItemName',
        //     'strDescription',
        //     'strUoM',
        //     'intCategoryID',
        //     'strCategory',
        //     'strSubCategory',
        //     'strItemFullName',
        //     'Quantity',
        //     'strShortDescription'
        // )
        ;
        if(strlen($search) > 0){
            $query->where('strItemName', 'like', '%'.$search.'%');
        }
        if(!is_null($intCategoryID)){
            $query->where('intCategoryID',  $intCategoryID);
        }
        $items = $query->get();

        $itemsArray = [];
        foreach ($items as $item) {
            if($item->strItemName == 'Octen' || $item->strItemName == 'Diesel' || $item->strItemName == 'CNG' || $item->strItemName == 'FUEL & LUBRICANT'){
                $item->strImageLink = "https://i.ibb.co/s6qyp2w/gas.png";
            }
            array_push($itemsArray, $item);
        }
        return $itemsArray;
    }
}
