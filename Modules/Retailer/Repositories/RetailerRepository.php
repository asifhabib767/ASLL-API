<?php

namespace Modules\Retailer\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Retailer\Entities\Retailer;

class RetailerRepository
{

    public function getRetailerByUnitId(Request $request){
        try {
            $retailers = Retailer::where('intUnitId', $request->intUnitId)->get();
            return $retailers;
        }   catch (\Exception $e) {
            return false;
        }
    }

    public function getRetailerByCustomer(Request $request)
    {
        try {
            $retailers = Retailer::where('intCustomerId', $request->intCustomerId)->get();
            return $retailers;
        }   catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new Retailer to Retailer
     *
     * @param Request $request
     * @return object Retailer object which is created
     */
    public function storeRetailer(Request $request)
    {
        try {
            $retailerStore = Retailer::create([
            'intUnitId'=>$request->intUnitId,
            'strName'=>$request->strName,
            'strAddress'=>$request->strAddress,
            'strContactPerson'=>$request->strContactPerson,
            'strContactNo'=>$request->strContactNo,
            'intCustomerId'=>$request->intCustomerId,
            'intPriceCatagory'=>$request->intPriceCatagory,
            'intLogisticCatagory'=>$request->intLogisticCatagory,
            'ysnEnable'=>$request->ysnEnable,
            'intFuelRouteID'=>$request->intFuelRouteID,
            'dteInsertionDate'=>$request->dteInsertionDate,
            'ysnLocationTag'=>$request->ysnLocationTag,
            'ysnImageTag'=>$request->ysnImageTag,
            'decLatitude'=>$request->decLatitude,
            'decLongitude'=>$request->decLongitude,
            'intZAxis'=>$request->intZAxis,
            'strGoogleMapName'=>$request->strGoogleMapName,
            'dteUpdateAt'=>$request->dteUpdateAt
            ]);
            return $retailerStore;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * update Retailer list by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated Retailer list object
     */
    public function updateRetailer(Request $request, $id)
    {
        try {
            Retailer::where('intDisPointId', $id)
            ->update([
                'intUnitId'=>$request->intUnitId,
                'strName'=>$request->strName,
                'strAddress'=>$request->strAddress,
                'strContactPerson'=>$request->strContactPerson,
                'strContactNo'=>$request->strContactNo,
                'intCustomerId'=>$request->intCustomerId,
                'intPriceCatagory'=>$request->intPriceCatagory,
                'intLogisticCatagory'=>$request->intLogisticCatagory,
                'ysnEnable'=>$request->ysnEnable,
                'intFuelRouteID'=>$request->intFuelRouteID,
                'dteInsertionDate'=>$request->dteInsertionDate,
                'ysnLocationTag'=>$request->ysnLocationTag,
                'ysnImageTag'=>$request->ysnImageTag,
                'decLatitude'=>$request->decLatitude,
                'decLongitude'=>$request->decLongitude,
                'intZAxis'=>$request->intZAxis,
                'strGoogleMapName'=>$request->strGoogleMapName,
                'dteUpdateAt'=>$request->dteUpdateAt
            ]);
            return $this->show($id);
    }   catch (\Exception $e) {
        return false;
    }
}

    /**
     * show Retailer list boiler by id
     *
     * @param integer $id
     * @return object Retailer List boiler object
     */
    public function show($id)
    {
        try {
            $retailerList = Retailer::find($id);
            return $retailerList;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Retailer List Not Found !');
        }
    }

    /**
     * delete Retailer List by id
     *
     * @param integer $id
     * @return object Deleted Retailer List Object
     */
    public function deleteRetailer($id)
    {
        try {
            $retailerList = $this->show($id);
            $retailerList->delete();
            return $retailerList;
        } catch (\Exception $e) {
            return false;
        }
    }
}
