<?php

namespace Modules\Supplier\Repositories;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SupplierRepository
{

    public function getSupplierList($intUnitId, $strName)
    {
        $ItemList = DB::select(
            DB::raw("SELECT  intId,intUnitId,strName,intCOAid FROM ERP_Logistic.dbo.tblVehicleSupplier
            where intUnitId=$intUnitId and ysnEnable=1
            and strName like '%$strName%'
            order by strName asc
                ")
        );
        return $ItemList;
    }

    public function getSupplierListForBridgeToTerritory($intUnitId)
    {
        $ItemList = DB::select(
            DB::raw("select * from ERP_Logistic.dbo.tblVehicleSupplier where intUnitId=$intUnitId and ysnEnable=1
            and intid not in (select intSupplierID from ERP_Logistic.dbo.tblVehicleSupplierNTerritoryBridge where intUnitID=$intUnitId )
           ")
        );
        return $ItemList;
    }




    public function getVehicleAcceptStatus($ysnConfirmed, $fromdate, $todate)
    {

        // return $ysnConfirmed;
        //return $fromdate;
        //return $todate;

        $ItemList = DB::select(
            DB::raw("SELECT pl.intShipmentId,spd.strSalesOrderCode,decTotalQty,so.strAddress,c.strName,dteScheduledTime,DATEDIFF(second, getdate(), DATEADD(HOUR,DATEPART(HOUR, HourFromFactory),dteScheduledTime)) / 3600.0 as RemainingHOUR
            ,convert(varchar(10), (DATEDIFF(SECOND,GETDATE(),DATEADD(HOUR,DATEPART(HOUR, HourFromFactory),dteScheduledTime))/86$intunit00)) + ':' + 
            convert(varchar(10), ((DATEDIFF(SECOND,GETDATE(),DATEADD(HOUR,DATEPART(HOUR, HourFromFactory),dteScheduledTime))%86400)/3600)) + ':'+
            convert(varchar(10), (((DATEDIFF(SECOND,GETDATE(),DATEADD(HOUR,DATEPART(HOUR, HourFromFactory),dteScheduledTime))%86400)%3600)/60)) + ':'+
            convert(varchar(10), (((DATEDIFF(SECOND,GETDATE(),DATEADD(HOUR,DATEPART(HOUR, HourFromFactory),dteScheduledTime))%86400)%3600)%60)) as RemaingTime
            ,dteInsertTime,e.strEmployeeName,strVechicleProviderType,strVehicleCapacity,strLastDestination,vh.strRegNo
            ,case when strPickingPointName is null then 'Factory' else strPickingPointName end as strPickingPointName
            ,case when ysnOpenVehicle is null then 'OpenVehicle' else 'CoverdVehicle' end as ysnOpenVehicle,pm.HourFromFactory
            ,pl.intUnitId ,HourFromGhat,intRequestId,pl.intInsertBy,intVehicleId,intDriverId
            ,vt.strVheicleParentName,vs.strName as SupplierName
            FROM ERP_APPS.dbo.tblShipmentPlanning pl 
            join ERP_APPS.dbo.tblShipmentPlanningDetails spd on pl.intShipmentId=spd.intShipmentId 
             join erp_sad.dbo.tblsalesorder so on so.intId=spd.intSalesOrderId
              join erp_sad.dbo.tblItemPriceManager pm on pm.intID=so.intPriceVarId
              JOIN ERP_HR.DBO.TBLEMPLOYEE e on e.intEmployeeID=pl.intInsertBy
             join ERP_Logistic.dbo.tblVehicle vh on vh.intID=pl.intVehicleId
             join ERP_Logistic.dbo.TblVehicleType vt on vt.intTypeId=vh.intTypeId
              join erp_sad.dbo.tblcustomer c on c.intCusID=so.intCustomerId
             join erp_logistic.dbo.tblVehicleSupplier vs on vs.intId=pl.intProviderId
            WHERE ysnConfirmed = $ysnConfirmed 
            ORDER BY intShipmentId desc")
        );
        return $ItemList;
    }

    public function getPoMrrInvoiceStatus($intunit, $intSupplier, $fromdate, $todate)
    {

        // return $intSupplier;
        // return $fromdate;
        // return $todate;

        $data = [
            [
                'POCount' => 0,
                'POAmount' => 0,
                'mrrCount' => 0,
                'mrrAmount' => 0,
                'billCount' => 0,
                'BilledAmount' => 0,
                'paidCount' => 0,
                'PaidAmount' => 0,
            ]
        ];

        // Business Logic

        // PO Count By from date, to date by this Supplier from tblPurchaseOrderMain

        // select count(IndenQty)IndenQty,sum(IndenQty*monRate) as indenttotal
        // ,count(numPOQty)numPOQty,sum(numPOQty*monRate) as pototal
        // ,count(numReceiveQty)numReceiveQty,sum(numReceiveQty *monRate) as mrrtotal
        // from ERP_Inventory.dbo.qryIndentPoMRR
        // where intSupplierID=4735
        // and dteIndentDate between '2020-01-01' and '2020-12-01'

        $POMRRData = DB::select(
            DB::raw("select count(IndenQty)IndenQty,sum(IndenQty*monRate) as indenttotal
            ,count(numPOQty)numPOQty,sum(numPOQty*monRate) as pototal
            ,count(numReceiveQty)numReceiveQty,sum(numReceiveQty *monRate) as mrrtotal
            from ERP_Inventory.dbo.qryIndentPoMRR
            where intSupplierID=$intSupplier
            and dteIndentDate between '$fromdate' and '$todate'")
        );
        // return $POMRRData;









        // $POCount = DB::table(config('constants.DB_Inventory') . ".tblPurchaseOrderMain as pom")
        //     // ->leftJoin(config('constants.DB_Inventory') . ".tblPaymentSchedule as ps", 'pom.intSupplierID', '=', 'ps.intSupplierID')
        //     ->select(DB::raw('COUNT(pom.intPOID) as totalPO'))
        //     ->whereBetween('pom.dtePODate', [date($fromdate), date($todate)])
        //     ->where('pom.intSupplierID', $intSupplier)
        //     ->get();


        // $POCount = DB::table(config('constants.DB_Inventory') . ".tblPurchaseOrderMain as pom")
        //     // ->leftJoin(config('constants.DB_Inventory') . ".tblPaymentSchedule as ps", 'pom.intSupplierID', '=', 'ps.intSupplierID')
        //     ->select(DB::raw('COUNT(pom.intPOID) as totalPO'))
        //     ->whereBetween('pom.dtePODate', [date($fromdate), date($todate)])
        //     ->where('pom.intSupplierID', $intSupplier)
        //     ->get();





        // $POAmount = DB::table(config('constants.DB_Inventory') . ".tblPaymentSchedule as ps")
        //     ->select(DB::raw('SUM(ps.monAmount) as totalPOAmount'))
        //     ->whereBetween('ps.dteProposePayDate', [date($fromdate), date($todate)])
        //     ->where('ps.intSupplierID', $intSupplier)
        //     ->get();

        $data[0]['POCount'] = (int)  $POMRRData[0]->numPOQty;
        $data[0]['POAmount'] = (float) $POMRRData[0]->pototal;

        // MRR Count By from date, to date by this Supplier from tblPurchaseOrderMain


        // $mrrCount = DB::table(config('constants.DB_Inventory') . ".tblPaymentSchedule as ps")
        //     ->Join(config('constants.DB_Inventory') . ".tblFactoryReceiveMRRItemDetail as mrrd", 'ps.intPOID', '=', 'mrrd.intPOID')
        //     ->Join(config('constants.DB_Inventory') . ".tblFactoryReceiveMRR as mrr", 'mrrd.intMRRID', '=', 'mrr.intMRRID')
        //     ->select(DB::raw('COUNT(DISTINCT(mrrd.intMRRID)) as totalMrrCount'))
        //     ->where('mrr.intUnitID', $intunit)
        //     ->whereBetween(DB::raw('CAST(mrr.dteLastActionTime AS DATE)'), [$fromdate, $todate])
        //     ->where('ps.intSupplierID', $intSupplier)
        //     ->get();


        // $mrrAmount = DB::table(config('constants.DB_Inventory') . ".tblPaymentSchedule as ps")
        //     ->Join(config('constants.DB_Inventory') . ".tblFactoryReceiveMRRItemDetail as mrrd", 'ps.intPOID', '=', 'mrrd.intPOID')
        //     ->Join(config('constants.DB_Inventory') . ".tblFactoryReceiveMRR as mrr", 'mrrd.intMRRID', '=', 'mrr.intMRRID')
        //     ->select(DB::raw('ISNULL(SUM(mrrd.monBDTTotal),0) as totalMRRAmount'))
        //     ->where('mrr.intUnitID', $intunit)
        //     ->whereBetween(DB::raw('CAST(mrr.dteLastActionTime AS DATE)'), [$fromdate, $todate])
        //     ->where('ps.intSupplierID', $intSupplier)
        //     ->get();


        $data[0]['mrrCount'] = (int)  $POMRRData[0]->numReceiveQty;
        $data[0]['mrrAmount'] = (float)  $POMRRData[0]->mrrtotal;

        // SELECT intPartyID, COUNT(intBillID)billCount, ISNULL(SUM(monBillAmount),0)monBilled FROM ERP_Payment.dbo.tblBillRegister 
        // WHERE intUnitID=4 AND intPartyTypeID=1 AND intPartyID IS NOT NULL AND dteBillRcvDate BETWEEN '2010-10-01' and '2020-11-25'
        // GROUP BY intPartyID












        $billCount = DB::table(config('constants.DB_Payment') . ".tblBillRegister")

            ->select(DB::raw('COUNT(intBillID) as totalbillCount'))
            ->where('intUnitID', $intunit)
            ->whereBetween(DB::raw('CAST(dteBillRcvDate AS DATE)'), [$fromdate, $todate])
            ->where('intPartyID', $intSupplier)
            ->get();




        $BilledAmount = DB::table(config('constants.DB_Payment') . ".tblBillRegister")

            ->select(DB::raw('ISNULL(SUM(monBillAmount),0) as totalBilledAmount'))
            ->where('intUnitID', $intunit)
            ->whereBetween(DB::raw('CAST(dteBillRcvDate AS DATE)'), [$fromdate, $todate])
            ->where('intPartyID', $intSupplier)
            ->get();
        $data[0]['billCount'] = (int) $billCount[0]->totalbillCount;
        $data[0]['BilledAmount'] = (int) $BilledAmount[0]->totalBilledAmount;


        //     SELECT br.intPartyID, COUNT(pr.intRequestID)paidCount, ISNULL(SUM(pr.monApporveAmount),0)monPaid,ISNULL(SUM(pr.monApporveAmount*-1),0) monBalance
        // FROM ERP_Payment.dbo.tblBillRegister br JOIN ERP_Payment.dbo.tblPaymentRequest pr ON br.intBillID=pr.intBillID
        // WHERE br.intUnitID=4 AND br.intPartyTypeID=1 AND br.intPartyID IS NOT NULL AND CAST(pr.dtePayTime AS DATE) BETWEEN '2010-10-01' and '2020-11-25'
        // GROUP BY br.intPartyID




        $paidCount = DB::table(config('constants.DB_Payment') . ".tblBillRegister as br")
            ->Join(config('constants.DB_Payment') . ".tblPaymentRequest as pr", 'br.intBillID', '=', 'pr.intBillID')

            ->select(DB::raw('isnull(COUNT(pr.intRequestID),0) as totalpaidCount'))
            ->where('br.intUnitID', $intunit)
            ->whereBetween(DB::raw('CAST(pr.dtePayTime AS DATE)'), [$fromdate, $todate])
            ->where('br.intPartyID', $intSupplier)
            ->get();

        $PaidAmount = DB::table(config('constants.DB_Payment') . ".tblBillRegister as br")
            ->Join(config('constants.DB_Payment') . ".tblPaymentRequest as pr", 'br.intBillID', '=', 'pr.intBillID')

            ->select(DB::raw('ISNULL(SUM(pr.monApporveAmount),0) as  totalPaidAmount'))
            ->where('br.intUnitID', $intunit)
            ->whereBetween(DB::raw('CAST(pr.dtePayTime AS DATE)'), [$fromdate, $todate])
            ->where('br.intPartyID', $intSupplier)
            ->get();

        $data[0]['paidCount'] = (int) $paidCount[0]->totalpaidCount;

        $data[0]['PaidAmount'] = (int) $PaidAmount[0]->totalPaidAmount;

        return $data[0];
    }


    public function getSupplierBalance($intunit, $intSupplier)
    {
        // return $intunit;
        // return $intSupplier;



        // $ItemList = DB::select(
        //     DB::raw("declare @Balance money
        //     set @Balance=isnull((Select ((isnull(coa.monOpeningBalance,0.00)  + sum(isnull(slgr.monAmount,0.00)))*-1) 
        //     From ERP_Inventory.dbo.tblSupplier sup 
        //     inner join erp_Accounts.dbo.tblAccountsChartOfAcc coa on sup.intCOAid=coa.intAccID
        //     inner join ERP_Accounts.dbo.tblAccountsSubLedger slgr on sup.intCOAid=slgr.intCOAAccountID and sup.intUnitID=$intunit and sup.intSupplierID=$intSupplier 
        //     and slgr.dteTransactionDate <= getdate() Group by sup.monCreditLimit, coa.monOpeningBalance),0)
        //     select @Balance")
        // );
        // return $ItemList;


        $data = [[
            'balance' => 0
        ]];

        $balance = DB::table(config('constants.DB_Inventory') . ".tblSupplier as sup")
            ->Join(config('constants.DB_Accounts') . ".tblAccountsChartOfAcc as coa", 'sup.intCOAid', '=', 'coa.intAccID')
            ->Join(config('constants.DB_Accounts') . ".tblAccountsSubLedger as slgr", 'sup.intCOAid', '=', 'slgr.intCOAAccountID')
            ->select(DB::raw('((isnull(coa.monOpeningBalance,0)  + sum(isnull(slgr.monAmount,0)))*-1)  as totalbalance'))
            ->where('sup.intUnitID', $intunit)
            ->where('sup.intSupplierID', $intSupplier)
            ->groupBy('coa.monOpeningBalance')
            ->get();

        if (count($balance) > 0) {
            $data[0]['balance'] = (float) $balance[0]->totalbalance;
        }
        return $data[0];
    }

    public function getUnitForSupplier($intSuppMasterID)
    {
        // return $intunit;
        // return $intSuppMasterID;





        $ItemList  = DB::table(config('constants.DB_Inventory') . ".tblSupplier as sup")
            ->Join(config('constants.DB_HR') . ".tblunit as u", 'sup.intunitid', '=', 'u.intunitid')
            ->select('intSupplierID', 'intSuppMasterID', 'strSupplierName', 'sup.intUnitID', 'u.strUnit')
            ->where('sup.intSuppMasterID', $intSuppMasterID)

            ->get();


        return   $ItemList;
    }
}
