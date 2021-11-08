<?php

namespace Modules\PurchaseRequisition\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitRepository
{
    public function getUnitList($intEmployeeId)
    {

        if (!is_null($intEmployeeId)) {
            $employeeId = DB::table(config('constants.DB_HR') . ".tblUserInfo")
                ->where('intUserID', $intEmployeeId)
                ->first();
            if ($employeeId != null || $employeeId != 'undefined') {
                $employeeId = true;
            } else {
                $employeeId = false;
            }
        }



        if ($employeeId) {
            $unitList = DB::select(DB::RAW("SELECT strUnit, intUnitID FROM ERP_HR.dbo.tblUnit 
            Where intUnitID IN (SELECT intUnitId FROM ERP_HR.dbo.tblUnitByUser Where intUserId = $intEmployeeId) OR
                  intUnitID IN (SELECT intUnitID FROM ERP_HR.dbo.tblEmployee Where intEmployeeID = $intEmployeeId) 
           GROUP BY strUnit, intUnitID Order By strUnit ASC"));
        }

        return $unitList;
    }

    public function getWareHouseInformation($intWHID)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouse");
        $output = $query->select(
            [
                'intWHID',
                'strWareHoseName',
                'intParentID',
                'intUnitID',
                'ysnActive',
                'strShortName',
                'intJobStationId',
                'ysnIndent',
                'dteOpeningBalanceDate',
                'strBINNo',
                'strAddress',
                'intWHType',
                'ysnQC',
                'intMainDistributionWH'
            ]
        )
            ->where('tblWearHouse.intWHID', $intWHID)
            ->where('tblWearHouse.ysnActive', true)
            ->get();

        return $output;
    }

    /**
     * Get Wearehouse List By Employee Permission For Store
     *
     * @param integer $intEmployeeId
     * @return void
     */
    public function getWearehouseListByEmployeePermissionForStore($intEmployeeId)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseOperator")
            ->join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouseOperator.intWHID', '=', 'tblWearHouse.intWHID');

        $output = $query->select(
            [
                'tblWearHouseOperator.intWHID',
                'tblWearHouse.strWareHoseName',
                'tblWearHouse.intJobStationId'
            ]
        )
            ->where('tblWearHouseOperator.intEnrollment', $intEmployeeId)
            ->where('tblWearHouseOperator.ysnStoreUser', true)
            ->get();

        return $output;
    }


    /**
     * Get Wearehouse List By Employee Permission For RequisitionApproval
     *
     * @param integer $intEmployeeId
     * @return void
     */
    public function getWearehouseListByEmployeePermissionForRequisitionApproval($intEmployeeId)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseOperator")
            ->join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouseOperator.intWHID', '=', 'tblWearHouse.intWHID');

        $output = $query->select(
            [
                'tblWearHouseOperator.intWHID',
                'tblWearHouse.strWareHoseName'
            ]
        )
            ->where('tblWearHouseOperator.intEnrollment', $intEmployeeId)
            ->where('tblWearHouseOperator.ysnRequisitionApproval', true)
            ->get();

        return $output;
    }

    /**
     * Get Wearehouse List By Employee Permission For Indent Approval
     *
     * @param integer $intEmployeeId
     * @return void
     */
    public function getWearehouseListByEmployeePermissionForIndentApproval($intEmployeeId)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseOperator")
            ->join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouseOperator.intWHID', '=', 'tblWearHouse.intWHID');

        $output = $query->select(
            [
                'tblWearHouseOperator.intWHID',
                'tblWearHouse.strWareHoseName'
            ]
        )
            ->where('tblWearHouseOperator.intEnrollment', $intEmployeeId)
            ->where('tblWearHouseOperator.ysnIndentApproval', true)
            ->get();

        return $output;
    }


    /**
     * Get Wearehouse List By Employee Permission For Requisition
     *
     * @param integer $intEmployeeId
     * @return void
     */
    public function getWearehouseListByEmployeePermissionForRequisition($intEmployeeId)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseOperator")
            ->join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouseOperator.intWHID', '=', 'tblWearHouse.intWHID');

        $output = $query->select(
            [
                'tblWearHouseOperator.intWHID',
                'tblWearHouse.strWareHoseName'
            ]
        )
            ->where('tblWearHouseOperator.intEnrollment', $intEmployeeId)
            ->where('tblWearHouseOperator.ysnRequisition', true)
            ->get();

        return $output;
    }

    /**
     * Get Wearehouse List By Employee Permission For Indent
     *
     * @param integer $intEmployeeId
     * @return void
     */
    public function getWearehouseListByEmployeePermissionForIndent($intEmployeeId)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseOperator")
            ->join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouseOperator.intWHID', '=', 'tblWearHouse.intWHID');

        $output = $query->select(
            [
                'tblWearHouseOperator.intWHID',
                'tblWearHouse.strWareHoseName'
            ]
        )
            ->where('tblWearHouseOperator.intEnrollment', $intEmployeeId)
            ->where('tblWearHouseOperator.ysnIndent', true)
            ->get();

        return $output;
    }

    /**
     * Get Wearehouse List By Employee Permission For PO
     *
     * @param integer $intEmployeeId
     * @return void
     */
    public function getWearehouseListByEmployeePermissionForPO($intEmployeeId)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseOperator")
            ->join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouseOperator.intWHID', '=', 'tblWearHouse.intWHID');

        $output = $query->select(
            [
                'tblWearHouseOperator.intWHID',
                'tblWearHouse.strWareHoseName'
            ]
        )
            ->where('tblWearHouseOperator.intEnrollment', $intEmployeeId)
            ->where('tblWearHouseOperator.ysnPO', true)
            ->get();

        return $output;
    }


    /**
     * Get Wearehouse List By Employee Permission
     *
     * @param integer $intEmployeeId
     * @return void
     */
    public function getInventoryPermissionByEmployee($intEmployeeId)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseOperator")
            ->join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouseOperator.intWHID', '=', 'tblWearHouse.intWHID');

        $output = $query->select(
            [
                'strWareHoseName',
                'tblWearHouseOperator.*'
            ]
        )
            ->where('tblWearHouse.intEnrollment', $intEmployeeId)
            ->where('tblWearHouse.ysnActive', true)
            ->get();
        return $output;
    }
}
