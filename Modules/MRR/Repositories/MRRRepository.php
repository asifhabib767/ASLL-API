<?php

namespace Modules\MRR\Repositories;

use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Modules\MRR\Entities\Trip;
use Carbon\Carbon;

class MRRRepository
{

    public function getPOType()
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblPOType");


        $output = $query->select(
            [
                'tblPOType.intID',
                'tblPOType.strPOType'
            ]
        )
            ->where('tblPOType.ysnActive', true)
            ->get();

        return $output;
    }

    public function storeMRR(Request $request)
    {
        // Add Single Entry in tblPurchaseIndent table
        // and multiple in tblPurchaseIndentDetail
        if (count($request->requisitions) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $i = 1;
            $intMRRID = null;

            // Filtering the requested data
            $ItemArray = [];
            foreach ($request->requisitions as $item) {

                // Check If Duplicate Item Arise
                if (!in_array($item['intItemID'], $ItemArray)) {
                    $ItemArray[] = $item['intItemID'];
                } else {
                    throw new \Exception('Duplicate Item Found !');
                }

                // Check If Supplier Exist
                if (is_null($this->getSupplierExistence($item['intSupplierID']))) {
                    throw new \Exception('Supplier Not Found !');
                }

                // Check If PO is exist

            }


            foreach ($request->requisitions as $requisition) {
                if ($i == 1) {
                    $intMRRID = DB::table(config('constants.DB_Inventory') . ".tblFactoryReceiveMRR")->insertGetId(
                        [

                            // intPOID,intSupplierID,intShipmentSL,intLastActionBy,dteLastActionTime,
                            // intUnitID,strExtnlReff,dteChallanDate,intWHID,strVatChallan,monTotaVAT,monTotalAIT
                            //,ysnInventory,intShipmentID

                            // // Required Fields
                            'intPOID' => $requisition['intPOID'],
                            'intSupplierID' => $requisition['intSupplierID'],
                            'intShipmentSL' => $requisition['intShipment'],
                            'intLastActionBy' => $requisition['poIssueBy'],
                            'dteLastActionTime' => Carbon::now(),
                            'dteChallanDate' => Carbon::now(),


                            // Other fields
                            'intUnitID' => 4,
                            'strExtnlReff' => null,
                            'intWHID' => 276,
                            'strVatChallan' => '1112',
                            'monTotaVAT' => 123,
                            'monTotalAIT' => 456,
                            'ysnInventory' => true,
                            'intShipmentID' => 99,

                        ]
                    );
                }

                // intMRRID,intItemID,numPOQty,numReceiveQty,monFCRate,monFCTotal,monBDTTotal
                //,intLocationID,intPOID,monVATAmount
                // , monAITAmount, strReceiveRemarks,strBatchNo,dteMFGdate,dteExpireDate




                if ($intMRRID > 0) {
                    DB::table(config('constants.DB_Inventory') . ".tblFactoryReceiveMRRItemDetail")->insertGetId(
                        [
                            'intMRRID' => $intMRRID,
                            'intItemID' => $requisition['intItemID'],
                            'numPOQty' => $requisition['numPOQty'],
                            'numReceiveQty' => $requisition['numRcvQty'],
                            'monFCRate' => $requisition['monRate'],
                            'monBDTTotal' => 44,
                            'intLocationID' => $requisition['locationId'],
                            'intPOID' => $requisition['intPOID'],
                            'monVATAmount' => $requisition['monVatAmount'],
                            'monAITAmount' => 0,
                            'strReceiveRemarks' => $requisition['remarks'],
                            'strBatchNo' => $requisition['batchNo'],
                            'dteMFGdate' => $requisition['manufactureDate'],
                            'dteExpireDate' => $requisition['expireDates'],

                        ]
                    );
                }
                $i++;
            }
            DB::commit();
            return $intMRRID;
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function getOthersInfo($intPOID)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblPurchaseOrderMain");


        $output = $query->select(
            [
                'tblPurchaseOrderMain.intWHID',
                'tblPurchaseOrderMain.intSupplierID',
                'tblPurchaseOrderMain.intUnitID',
            ]
        )
            ->where('tblPurchaseOrderMain.intPOID', $intPOID)
            ->first();

        return $output;
    }


    public function getSupplierExistence($intSupplierID)
    {
        $query = DB::table(config('constants.DB_Inventory') . ".tblSupplier");
        $output = $query->select(
            [
                'tblSupplier.intSupplierID',
                'tblSupplier.strSupplierName',
            ]
        )
            ->where('tblSupplier.intSupplierID', $intSupplierID)
            ->where('tblSupplier.ysnActive', true)
            ->first();
        return $output;
    }

    public function getPOList($intWHID, $strPoFor)
    {

        // return $intWHID;
        // return $strPoFor;

        $query = DB::table(config('constants.DB_Inventory') . ".tblPurchaseOrderMain")
            ->leftJoin(config('constants.DB_Inventory') . ".tblSupplier", 'tblPurchaseOrderMain.intSupplierID', '=', 'tblSupplier.intSupplierID');


        $output = $query->select(
            [
                'tblPurchaseOrderMain.intPOID',
                'tblSupplier.strSupplierName',

                // (DB::raw("CONCAT('intPOID','strSupplierName') AS ID"))
                // DB::raw('CONCAT(tblPurchaseOrderMain.intPOID, ", ", tblSupplier.strSupplierName) AS ID'),
                DB::raw("CONCAT(intPOID, ',', strSupplierName) AS FullID"), 'tblSupplier.intSupplierID',

            ]
        )
            ->where('tblPurchaseOrderMain.intWHID', $intWHID,)
            ->where('tblPurchaseOrderMain.strPoFor', $strPoFor)
            ->where('tblPurchaseOrderMain.ysnComplete', false)
            ->where('tblPurchaseOrderMain.ysnApprove', true)
            ->where('tblPurchaseOrderMain.ysnActive', true)
            ->get();
        return $output;
    }

    public function getPOVsWHNExchangrRate($intPOID)
    {

        // return $intWHID;
        // return $strPoFor;

        $query = DB::table(config('constants.DB_Inventory') . ".tblPurchaseOrderMain")
            ->leftJoin(config('constants.DB_Inventory') . ".tblCurrencyConversion", 'tblPurchaseOrderMain.intCurrencyID', '=', 'tblCurrencyConversion.intCurrencyID');


        $output = $query->select(
            [
                'tblPurchaseOrderMain.intWHID',
                'tblCurrencyConversion.monBDTConversion',


            ]
        )
            ->where('tblPurchaseOrderMain.intPOID', $intPOID)

            ->get();
        return $output;
    }
    public function getPOVSItemDet($intPOID, $intWHId)
    {
        $ItemDetailsByPO = DB::select(
            DB::raw("select pod.intItemID,SUM(pod.numQty) as numQty, SUM(pod.monAmount) as monAmount, SUM(pod.monAmount)/SUM(pod.numQty) as monRate
            , SUM(ISNULL(pod.monVAT,0)*pod.numQty)/SUM(pod.numQty) as monVat, mrd.numPrRcv
            ,isnull(numMIRQty,0)numMIRQty,intLocationID,itemname
            FROM ERP_Inventory.dbo.tblPurchaseOrderShipmentItemDetail pod

            left join(
            SELECT mt.intItemID, ISNULL(SUM(mt.numReceiveQty),0) AS numPrRcv,mt.intPOID,it.strItemName as itemname
            FROM ERP_Inventory.dbo.tblFactoryReceiveMRRItemDetail mt
            join ERP_Inventory.dbo.tblItemList it on it.intItemID=mt.intItemID

            WHERE mt.intPOID=$intPOID GROUP BY mt.intItemID,mt.intPOID,it.strItemName
            )mrd on mrd.intItemID=pod.intItemID and mrd.intPOID=pod.intPOID

            left join
            (
            select sum(isnull(mird.numMIRQty,0))numMIRQty,intPOID,intItemID from ERP_Inventory.dbo.tblMIR m
            join ERP_Inventory.dbo.tblMIRDetail mird on m.intMIRID=mird.intMIRID
            where m.intPOID=$intPOID
            group by intPOID,intItemID
            ) mirq on mirq.intPOID=pod.intPOID and mirq.intItemID=pod.intItemID

            left join
            (
            SELECT TOP (100) il.intLocationID,il.intItemID
            FROM ERP_Inventory.dbo.tblInventory il
            join ERP_Inventory.dbo.tblPurchaseOrderShipmentItemDetail sd on il.intItemID= sd.intItemID
            WHERE  intWHID= $intWHId order by il.intAutoID desc
            ) il on il.intItemID=pod.intItemID

        where pod.intPOID=$intPOID
            GROUP BY pod.intItemID, mrd.numPrRcv, pod.intPOID,numMIRQty,intLocationID,itemname
                ")
        );
        return $ItemDetailsByPO;
    }

    public function getPOVSItemDetForExport($intPOID, $intWHId)
    {
        $ItemDetailsByPO = DB::select(
            DB::raw("select pod.intItemID,SUM(pod.numQty) as numQty, SUM(pod.monAmount) as monAmount, SUM(pod.monAmount)/SUM(pod.numQty) as monRate
                        , SUM(ISNULL(pod.monVAT,0)*pod.numQty)/SUM(pod.numQty) as monVat, mrd.numPrRcv
                        ,isnull(numMIRQty,0)numMIRQty,intLocationID
                        FROM ERP_Inventory.dbo.tblPurchaseOrderShipmentItemDetail pod

                        left join(
                        SELECT mt.intItemID, ISNULL(SUM(mt.numReceiveQty),0) AS numPrRcv,mt.intPOID
                        FROM ERP_Inventory.dbo.tblFactoryReceiveMRRItemDetail mt
                        WHERE mt.intPOID=$intWHId GROUP BY mt.intItemID,mt.intPOID
                        )mrd on mrd.intItemID=pod.intItemID and mrd.intPOID=pod.intPOID

                        left join
                        (
                        select sum(isnull(mird.numMIRQty,0))numMIRQty,intPOID,intItemID from ERP_Inventory.dbo.tblMIR m
                        join ERP_Inventory.dbo.tblMIRDetail mird on m.intMIRID=mird.intMIRID
                        where m.intPOID=$intPOID
                        group by intPOID,intItemID
                        ) mirq on mirq.intPOID=pod.intPOID and mirq.intItemID=pod.intItemID

                        left join
                        (
                        SELECT TOP (100) il.intLocationID,il.intItemID
                        FROM ERP_Inventory.dbo.tblInventory il
                        join ERP_Inventory.dbo.tblPurchaseOrderShipmentItemDetail sd on il.intItemID= sd.intItemID
                        WHERE  intWHID=$intWHId order by il.intAutoID desc
                        ) il on il.intItemID=pod.intItemID

                    where pod.intPOID=$intPOID
                        GROUP BY pod.intItemID, mrd.numPrRcv, pod.intPOID,numMIRQty,intLocationID
                ")
        );
        return $ItemDetailsByPO;
    }

    public function getwhStoreLocation($intWHID)
    {

        $query = DB::table(config('constants.DB_Inventory') . ".tblWearHouseStoreLocation");


        $output = $query->select(
            [
                'tblWearHouseStoreLocation.intStoreLocationID',
                'tblWearHouseStoreLocation.strLocationName',


            ]
        )
            ->where('tblWearHouseStoreLocation.intWHID', $intWHID)
            ->where('tblWearHouseStoreLocation.ysnActive', true)
            ->where('tblWearHouseStoreLocation.ysnNew', true)
            // ->where('tblWearHouseStoreLocation.intLocationType', true)
            ->get();
        return $output;
    }

    // public function getwhItemList($intWHID, $strItemFullName)
    // {

    //     return $strItemFullName;

    //     $query = DB::table(config('constants.DB_Inventory') . ".tblInventoryRunningBalance")
    //         ->leftJoin(config('constants.DB_Inventory') . ".tblItemList", 'tblInventoryRunningBalance.intItemID', '=', 'tblItemList.intItemID');

    //     $output = $query->select(
    //         [
    //             'tblItemList.strItemFullName',
    //             'tblInventoryRunningBalance.intItemID',
    //             'tblItemList.strUoM',
    //             'tblInventoryRunningBalance.numQuantity',
    //             'tblInventoryRunningBalance.monValue'


    //         ]
    //     )
    //         ->where('tblInventoryRunningBalance.intWHID', $intWHID)
    //         ->where('tblItemList.ysnActive', true)
    //         ->where('tblItemList.strItemFullName', 'LIKE', '%' . $strItemFullName . '%')
    //         // ->where("tblItemList.strItemFullName", "LIKE", "\\" .  $strItemFullName . "%")
    //         ->get();
    //     return $output;
    // }

    public function getwhItemList($intWHID, $strItemFullName)
    {
        $ItemList = DB::select(
            DB::raw("SELECT i.strItemFullName,rb.intItemID,i.strUoM ,rb.numQuantity as monStock,rb.monValue
                    FROM ERP_Inventory.dbo.tblInventoryRunningBalance rb
                    join ERP_Inventory.dbo.tblItemList i on i.intItemID=rb.intItemID
                    where intWHID=$intWHID  and strItemFullName like '%$strItemFullName%'
                    and i.ysnActive=1
            ")
        );
        return $ItemList;
    }

    public function getItemListByWearhouseAndBalance($intWHID)
    {
        $ItemList = DB::select(
            DB::raw("SELECT i.strItemFullName,rb.intItemID,i.strUoM ,rb.numQuantity as monStock,rb.monValue
                    FROM ERP_Inventory.dbo.tblInventoryRunningBalance rb
                    join ERP_Inventory.dbo.tblItemList i on i.intItemID=rb.intItemID
                    where intWHID=$intWHID
                    and i.ysnActive=1
            ")
        );
        return $ItemList;
    }


    // and (cast(req.dteReqDate as date) between  $startDate and $endDate)
    public function GetPendingDataforDeptHeadAprvdetails($intReqID)
    {



        $ItemList = DB::select(
            DB::raw("  Select dtl.intReqID, re.strCode, dtl.intItemID, itm.strItem+'[Category:'+ case when cls.strCluster is null then 'Please set Category' else cls.strCluster end +']', dteDueDate,
            strRemarks,numReqQty, numApproveQty,isnull(numDeptHeadApproveQty,0),u.strDescription,u.intUnitID
            from ERP_Inventory.dbo.tblRequisitionDetail dtl inner join ERP_Inventory.dbo.qryItemList itm on dtl.intItemID=itm.intItemID
            inner join ERP_Inventory.dbo.tblRequisition re on dtl.intReqID=re.intReqID
            inner join ERP_HR.dbo.tblUnit u on re.intUnitID=u.intUnitID
            left join ERP_Inventory.dbo.tblItemMasterCluster cls on itm.intMasterCluster=cls.intCluster
            where dtl.intReqID =$intReqID and isnull(ysnSupervisorApprove,0)=1
            and dtl.intDeptHeadApproveBy is null
            and re.ysnActive=1	 order by re.intReqID desc
                ")
        );
        return $ItemList;
    }

    public function Getrequisitionwhichareunapproved($intEnrollment, $dteStartDate = null, $dteEndDate = null)
    {
        // and (cast(req.dteReqDate as date)
        // return $intEnrollment;
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";




        $ItemList = DB::select(
            DB::raw("Select distinct req.intReqID, dteReqDate , strCode, strSection, strWareHoseName, strDepatrment
            From ERP_Inventory.dbo.tblRequisition req inner join
            ERP_Inventory.dbo.tblWearHouse wh on req.intWHID=wh.intWHID inner join
            ERP_hr.dbo.tblDepartment dpt on req.intDeptID=dpt.intDepartmentID
            left join
            (select intReqID,intApproveBy from
            ERP_Inventory.dbo.tblRequisitionDetail dtl
            where isnull(dtl.intApproveBy, 0) = 0
            )dtl on dtl.intReqID=req.intReqID

            join
            (select intEnrollment,intWHID from ERP_Inventory.dbo.tblWearHouseOperator
            where intEnrollment=$intEnrollment )op on op.intWHID=req.intWHID
            where req.dteReqDate  between  '2020-01-01' and '2020-09-01'  order by req.intReqID desc")
        );
        return $ItemList;
    }

    public function GetrequisitionDetailswhichareunapproved($intReqID)
    {



        $ItemList = DB::select(
            DB::raw("Select dtl.intReqID, re.strCode, dtl.intItemID, itm.strItem+'[Category:'+ case when cls.strCluster is null then 'Please set Category' else cls.strCluster end +']', dteDueDate,
            strRemarks, numReqQty,u.strDescription,u.intUnitID,dtl.numapproveqty
            from ERP_Inventory.dbo.tblRequisitionDetail dtl inner join ERP_Inventory.dbo.qryItemList itm on dtl.intItemID=itm.intItemID
            inner join ERP_Inventory.dbo.tblRequisition re on dtl.intReqID=re.intReqID
            inner join ERP_HR.dbo.tblUnit u on re.intUnitID=u.intUnitID
            left join ERP_Inventory.dbo.tblItemMasterCluster cls on itm.intMasterCluster=cls.intCluster
            where dtl.intReqID = $intReqID and dtl.intApproveBy is null and re.ysnActive=1	 order by re.intReqID desc")
        );
        return $ItemList;
    }
}
