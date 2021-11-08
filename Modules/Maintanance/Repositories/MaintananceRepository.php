<?php

namespace Modules\Maintanance\Repositories;

use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaintananceRepository
{

    public function getAssetListByJobstation($intJobStationID)
    {
        // return $intJobStationID;
        $query = DB::table(config('constants.DB_Asset') . ".tblFixedAssetRegister");
        $output = $query->select(
            [
                'tblFixedAssetRegister.intID',
                'tblFixedAssetRegister.strAssetID',
                'tblFixedAssetRegister.strNameOfAsset',
                'tblFixedAssetRegister.strDescriptionAsset',
                DB::raw("CONCAT(strNameOfAsset, ' [', strAssetID, ']') AS strNameOfAssetFull")

            ]
        )

            ->where('tblFixedAssetRegister.intJobStationID', $intJobStationID)
            ->where('tblFixedAssetRegister.YsnActive', true)
            // ->orderBy('tblFixedAssetRegister.strNameOfAsset', 'asc')
            ->get();

        return $output;
    }

    public function getPlannedAssetListByJobstation($intJobstationID)
    {
        // return $intJobstationID;
        $query = DB::table(config('constants.DB_Asset') . ".tblPMServiceName");
        $output = $query->select(
            [
                'tblPMServiceName.strServiceName', 'tblPMServiceName.intID'
            ]
        )

            ->where('tblPMServiceName.intJobstationID', $intJobstationID)
            // ->where('tblPMServiceName.YsnActive', true)
            // ->orderBy('tblFixedAssetRegister.strNameOfAsset', 'asc')
            ->get();

        return $output;
    }


    public function getBreakDownAssetListByJobstation($intJobstationID)
    {
        // return $intJobstationID;
        $query = DB::table(config('constants.DB_Asset') . ".tblCommonRepairsList");
        $output = $query->select(
            [
                'tblCommonRepairsList.strRepairs as strServiceName', 'tblCommonRepairsList.intID',
            ]
        )

            ->where('tblCommonRepairsList.intJobstationID', $intJobstationID)
            // ->where('tblCommonRepairsList.YsnActive', true)
            // ->orderBy('tblFixedAssetRegister.strNameOfAsset', 'asc')
            ->get();

        return $output;
    }

    public function getServiceNameListByWareHouse($intWHID)
    {

        // return $intWHID;

        $ItemList = DB::select(
            DB::raw("SELECT i.strItemFullName as strItem, i.intItemID as intItem, i.strUoM, isnull(rb.numQuantity,0) as monStock, 
            isnull(rb.monValue,0) as monValue, cast(i.intItemID as varchar(100)) as ItemNumber 
            FROM (SELECT intItemID FROM ERP_Inventory.dbo.tblInventoryLocationAndOpening il WHERE intWHID=$intWHID and intItemID>0
            UNION SELECT intItemID FROM ERP_Inventory.dbo.tblInventoryRunningBalance where intWHID=$intWHID) t 
            JOIN ERP_Inventory.dbo.tblItemList i on t.intItemID=i.intItemID 
            left JOIN (SELECT intItemID, numQuantity, monValue FROM ERP_Inventory.dbo.tblInventoryRunningBalance where intWHID=$intWHID) rb on t.intItemID=rb.intItemID  
            where i.ysnActive=1  --and ISNULL(intWHID,0) in (@WHID,0)  --and rb.intWHID = @WHID 
            ORDER BY i.strItemFullName")
        );
        return $ItemList;
    }

    public function getMaintenanceReportByReqID($intReqID)
    {
        // return $intJobstationID;
        $query = DB::table(config('constants.DB_Inventory') . ".tblRequisition")

            ->leftJoin(config('constants.DB_Inventory') . ".tblRequisitionDetail", 'tblRequisition.intReqID', '=', 'tblRequisitionDetail.intReqID')
            ->leftJoin(config('constants.DB_Inventory') . ".tblItemList", 'tblItemList.intItemID', '=', 'tblRequisitionDetail.intItemID')
            ->leftJoin(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouse.intWHID', '=', 'tblItemList.intWH');
        $output = $query->select(
            [
                'strCode', 'tblItemList.intItemID', 'tblItemList.strItemName', 'numReqQty', 'strWareHoseName'
            ]
        )

            ->where('tblRequisition.intReqID', $intReqID)
            ->orderBy('tblRequisition.intReqID', 'desc')
            ->get();


        return $output;
    }
    public function getMaintenanceReportByUnit($intUnitID)
    {
        // return $intJobstationID;
        $query = DB::table(config('constants.DB_Inventory') . ".tblRequisition")

            ->leftJoin(config('constants.DB_Inventory') . ".tblRequisitionDetail", 'tblRequisition.intReqID', '=', 'tblRequisitionDetail.intReqID')

            ->leftJoin(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouse.intWHID', '=', 'tblRequisition.intWHID');
        $output = $query->select(
            [
                'tblRequisition.intReqID',
                'tblRequisition.strCode',
                DB::raw('sum(tblRequisitionDetail.numReqQty)AS numReqQty'),
                'tblWearHouse.strWareHoseName',
                'tblRequisition.intUnitID'

            ]
        )

            ->where('tblRequisition.intUnitID', $intUnitID)
            ->orderBy('tblRequisition.intReqID', 'desc')
            ->groupBy('strCode', 'strWareHoseName', 'tblRequisition.intUnitID', 'tblRequisition.intReqID')
            ->paginate(100);


        return $output;
    }

    public function getMaintenanceJobCard($intUnitID)
    {
        // return $intUnitID;
        $query = DB::table(config('constants.DB_Asset') . ".tblAssetMaintenance")

            ->Join(config('constants.DB_Asset') . ".tblMaintenanceTask", 'tblAssetMaintenance.intMaintenanceNo', '=', 'tblMaintenanceTask.intReffMaintenance')

            ->Join(config('constants.DB_Inventory') . ".tblRequisition", 'tblRequisition.intMntPKID', '=', 'tblMaintenanceTask.intID')

            ->Join(config('constants.DB_Inventory') . ".tblRequisitionDetail", 'tblRequisitionDetail.intReqID', '=', 'tblRequisition.intReqID')
            ->Join(config('constants.DB_Inventory') . ".tblItemList", 'tblItemList.intItemID', '=', 'tblRequisitionDetail.intItemID')
            ->Join(config('constants.DB_Inventory') . ".tblWearHouse", 'tblWearHouse.intWHID', '=', 'tblRequisition.intWHID');

        $output = $query->select(
            [
                'tblAssetMaintenance.strAssignTo', 'tblMaintenanceTask.intServiceID', 'tblMaintenanceTask.monServiceCost', 'tblItemList.strItemName', 'tblRequisition.intReqID', 'tblRequisition.strCode', 'tblRequisitionDetail.numReqQty', 'tblWearHouse.strWareHoseName ', 'tblRequisition.intUnitID'

            ]
        )

            ->where('tblRequisition.intUnitID', $intUnitID)
            ->orderBy('tblRequisition.intReqID', 'desc')
            ->get();
        return $output;
    }

    public function getMaintenanceWHList()
    {
        // return $intUnitID;
        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouse");


        $output = $query->select(
            [
                'intWHID', 'strWareHoseName', 'intParentID', 'intUnitID', 'ysnActive', 'strShortName', 'intJobStationId', 'ysnIndent'

            ]
        )

            ->where('tblWearHouse.intWHType', 11)
            ->get();
        return $output;
    }
}
