<?php

namespace Modules\Sales\Repositories;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesOrderRepository
{
    public function getSalesOrderListByTerritory($intUnitId, $dteStartDate, $dteEndDate)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        $query = DB::table(config('constants.DB_SAD') . ".tblSalesOrder")
            ->leftJoin(config('constants.DB_SAD') . ".tblSalesOrderDetails", 'tblSalesOrderDetails.intSOId', '=', 'tblSalesOrder.intId')
            ->leftJoin(config('constants.DB_SAD') . ".tblDisPoint", 'tblDisPoint.intDisPointId', '=', 'tblSalesOrder.intDisPointId')
            ->leftJoin(config('constants.DB_SAD') . ".tblCustomer", 'tblCustomer.intCusID', '=', 'tblSalesOrder.intCustomerId')
            ->leftJoin(config('constants.DB_SAD') . ".tblItemPriceManager", 'tblItemPriceManager.intID', '=', 'tblSalesOrder.intId');

        $output = $query->select(
            [
                'tblSalesOrder.strCode as DONumber',
                'tblSalesOrder.dteDate as dodate',
                'tblcustomer.strName',
                'tblDisPoint.strName as shopname',
                'tblDisPoint.intDisPointId as shopid',
                'tblSalesOrderDetails.numApprQuantity',
                'tblSalesOrder.numRestPieces as restqnt',
                'tblSalesOrder.ysnEnable as ysnenable',
                'tblSalesOrder.ysnCompleted as ysndocompletestatus',
                'tblSalesOrder.intUnitId as intunitid',
                'tblSalesOrder.intPriceVarId',
                'tblItemPriceManager.strEmailAddress',
            ]
        )
            ->where('tblSalesOrder.intUnitId', $intUnitId)
            // ->where('tblItemPriceManager.strEmailAddress', $strEmailAddress)
            ->whereBetween('tblSalesOrder.dteDate', [$startDate, $endDate])
            ->where('tblSalesOrder.ysnEnable', true)
            ->where('tblSalesOrder.ysnDOCompleted', true)
            ->orderBy('tblSalesOrder.intId', 'desc')
            ->get();
        return $output;
    }
}
