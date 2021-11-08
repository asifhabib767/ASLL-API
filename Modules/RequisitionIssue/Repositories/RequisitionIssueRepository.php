<?php

namespace Modules\RequisitionIssue\Repositories;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\RequisitionIssue\Entities\FuelRequistion;
use Modules\RequisitionIssue\Entities\RequisitionDet;

class RequisitionIssueRepository
{
    public function storeRequisitionIssue(Request $request)
    {
        // Add Single Entry in tblStoreIssue table
        // and multiple in tblStoreIssueByItem
        if (count($request->requisitions) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $i = 1;
            $intIndentID = null;

            foreach ($request->requisitions as $requisition) {

                if ($i == 1) {
                    $intIndentID = DB::table(config('constants.DB_Inventory') . ".tblStoreIssue")->insertGetId(
                        [
                            'intUnitID' => $requisition['intUnitID'],
                            'intWHID' => $requisition['intWHID'],
                            'dteIssueDate' => Carbon::now(),
                            'intSRID' => $requisition['intSRID'],
                            'strSrNo' => $requisition['strSrNo'],
                            'dteSrDate' => $requisition['dteSrDate'],
                            'strReceivedBy' => $requisition['strRecieveEmployeeName'],
                            'intLastActionBy' => $requisition['intEmployeeId'],
                            'dteLastActionTime' => Carbon::now(),
                            'intCostCenter' => $requisition['intCostCenter'],
                        ]
                    );
                }


                if ($intIndentID > 0) {
                    DB::table(config('constants.DB_Inventory') . ".tblStoreIssueByItem")->insertGetId(
                        [
                            'intIssueID' => $intIndentID,
                            'intItemID' => $requisition['intItemID'],
                            'intUnitID' => $requisition['intUnitID'],
                            'intWHID' => $requisition['intWHID'],
                            'intDept' => $requisition['intDept'],
                            'intSection' =>  $requisition['intSection'],
                            'strUseFor' =>  $requisition['strUseFor'],
                            'intLocation' =>  $requisition['intLocation'],
                            'numQty' =>  $requisition['numQty'],
                            'monValue' => $requisition['monValue'],
                            'strSection' => $requisition['strSection'],
                            'intCostCenter' => $requisition['intCostCenter'],
                            'strRemarks' => $requisition['strRemarks']
                        ]
                    );
                }
                $i++;
            }
            DB::commit();
            return $intIndentID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getStoreIssueList($intUnitId, $dteStartDate = null, $dteEndDate = null)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        $query = DB::table(config('constants.DB_Inventory') . ".tblStoreIssue ");

        $output = $query->select(
            [
                'intIssueID',
                'intUnitID',
                'intWHID',
                'dteIssueDate',
                'intSRID',
                'strSrNo',
                'dteSrDate',
                'strReceivedBy',
                'intLastActionBy',
                'dteLastActionTime',
                'intCostCenter',
            ]
        )
            ->where('tblStoreIssue.intUnitId', $intUnitId)
            ->whereBetween('tblStoreIssue.dteIssueDate', [$startDate, $endDate])
            ->orderBy('tblStoreIssue.intIssueID', 'desc')
            ->get();
        return $output;
    }


    public function getStoreIssueListByWareHouseId($intWHID, $startDate, $endDate)
    {

        // return $endDate;

        // // return $intWHID;
        // $startDate = is_null($startDate) ? Carbon::now()->subDays(30) :  $startDate . "00:00:00.000";
        // $endDate = is_null($endDate) ? Carbon::now()->addDays(1) :  $endDate . "23:59:59.000";

        // return  $startDate;
        $ItemList = DB::select(
            DB::raw("SELECT intReqID , ISNULL(strCode,'') as ReqCode, dteReqDate, strDepartmentName, strSectionName, intSectionID,intDeptID,strReqBy, strApproveBy
            FROM ERP_Inventory.dbo.qryRequisitionSummary
            WHERE  ysnActive=1 AND intApproveBy IS NOT NULL AND
            intProdOrderID IS NULL AND
            intWHID=$intWHID and dteReqDate between '2020-07-01' and  '2020-08-01'
            GROUP BY intReqID, strCode, dteReqDate, strReqBy, strDepartmentName, strSectionName, intWHID, strApproveBy,intSectionID,intDeptID HAVING SUM(numRemainToIssueQty) > 0 ORDER BY dteReqDate")
        );
        return $ItemList;
    }

    public function getStoreIssueRequisitionDetaills($intWHID)
    {


        $ItemList = DB::select(
            DB::raw("SELECT summ.strItem AS strItem, summ.intItemID, summ.strUoM,summ.numReqQty,numIssueQty,numApproveQty ,numRemainToIssueQty,
            isnull(rb.numQuantity,0) as monStock, isnull(rb.monValue,0) as monValue,0 as Id,'' as strLocation,strRemarks
            FROM ERP_Inventory.dbo.qryRequisitionSummary summ
            LEFT JOIN ERP_Inventory.dbo.tblInventoryRunningBalance rb on summ.intItemID=rb.intItemID
            where summ.intReqID=$intWHID and summ.intWHID=rb.intWHID")
        );
        return $ItemList;
    }

    public function getDataExistOrNotExistInInventory($intInOutReffID,  $intItemID, $numTransactionQty)
    {


        $query = DB::table(config('constants.DB_Inventory') . ".tblInventory ");

        $output = $query->select(
            [
                'intInOutReffID',
                'intItemID',
                'numTransactionQty',

            ]
        )
            ->where('tblInventory.intInOutReffID', $intInOutReffID)
            ->where('tblInventory.intItemID', $intItemID)
            ->where('tblInventory.numTransactionQty', $numTransactionQty)
            ->get();
        return $output;
    }

    public function getDataExistencyInInventoryRunningBalance($intItemID, $intWHID)
    {


        $query = DB::table(config('constants.DB_Inventory') . ".tblInventoryRunningBalance ");

        $output = $query->select(
            ['intItemID']
        )
            ->where('tblInventoryRunningBalance.intItemID', $intItemID)
            ->where('tblInventoryRunningBalance.intWHID', $intWHID)
            ->get()
            ->count('intItemID');
        return $output;
    }

    public function storeIssueTblInventoryRunningBalance(Request $request)
    {

        try {
            DB::beginTransaction();

            $runningBalanceID = null; // intItemID, intWHID, strName, strUOM, numQuantity, monValue
            $runningBalanceID = DB::table(config('constants.DB_Inventory') . ".tblInventoryRunningBalance")->insertGetId(
                [
                    'intItemID' => $request['intItemID'],
                    'intWHID' => $request['intWHID'],
                    'strName' => $request['strName'],
                    'strUOM' => $request['strUOM'],
                    'numQuantity' => $request['numQuantity'],
                    'monValue' => $request['monValue'],

                ]
            );

            DB::commit();
            return $runningBalanceID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getCustomerLoadingProfile($intCusID)
    {

        // return $intCusID;
        $query = DB::table(config('constants.DB_SAD') . ".tblcustomer")
            ->leftJoin(config('constants.DB_SAD') . ".tblCustomerType", 'tblcustomer.intCusType', '=', 'tblCustomerType.intTypeID')
            ->leftJoin(config('constants.DB_SAD') . ".tblSalesOffice", 'tblSalesOffice.intId', '=', 'tblcustomer.intSalesOffId')
            ->leftJoin(config('constants.DB_SAD') . ".tblItemPriceManager", 'tblItemPriceManager.intId', '=', 'tblcustomer.intPriceCatagory');

        $output = $query->select(
            [
                'intCusID',
                'tblcustomer.strName as customername',
                'strAddress',
                'strPhone',
                'strPropitor',
                'monCreditLimit',
                'intCusType',
                'strTypeName',
                'intSalesOffId',
                'tblSalesOffice.strName as salesofficename',
                'tblItemPriceManager.intID as terid ',
                'strText',
                'strCustomerCode',
                'ysnDiscountApply',
            ]
        )
            ->where('tblcustomer.intCusID', $intCusID)
            ->first();
        return $output;
    }

    public function getItemVsDamage($intID, $intUnitID)
    {
        $query = DB::table(config('constants.DB_SAD') . ".tblItem");
        $output = $query->select(
            'strProductName',
            'intUnitID',
            'decDiscountallow',
            'monDamage',
            'monSpecialOffer',
            'monSRSubsidiary',
            'monSupplierVheicle',
            'monCustomerVheicle',
            'monCompanyVheicle'
        )
            ->where('tblItem.intID', $intID)
            ->where('tblItem.intUnitID', $intUnitID)
            ->first();
        return $output;
    }

    public function getSalesOfficeVsDiscount($intId, $intUnitId)
    {
        $query = DB::table(config('constants.DB_SAD') . ".tblSalesOffice");

        $output = $query->select(
            'ysnDiscountApply',
            'intId',
            'strName',
            'intUnitId'
        )
            ->where('tblSalesOffice.intId', $intId)
            ->where('tblSalesOffice.intUnitId', $intUnitId)
            ->first();
        return $output;
    }

    public function fuelRequisitionEntry(Request $request){
        // add multiple in VoyageGasNChemical

        if (count($request->requisitions) == 0) {
           return "No Item Given";
       }

       try {

           $intFuelLogId = FuelRequistion::create([
               'intUnitID' => $request->intUnitID,
               'intSupplierID' => $request->intSupplierID,
               'strSupplierName' => $request->strSupplierName,
               'dteRequisitionDate' => $request->dteRequisitionDate,
               'intEnrol' => $request->intEnrol,
               'strIssueRemarks' => $request->strIssueRemarks,
               'intUseFor' => $request->intUseFor,
           ]);

           $i = 1;

           foreach ($request->requisitions as $fuelRequisition) {
               // Check if already an entry in VoyageActivityBoilerMain table by this date
               // $lighter = VoyageActivityGasNChemicalMain::where('intVoyageActivityID', $voyageActivity->intID)->first();

               $logDetails = RequisitionDet::create([
                   // 'intLighterId'=> $fuelLog->intID,
                   'intReqID' => $intFuelLogId->intID,
                   'intItemID' => $fuelRequisition['intItemID'],
                   'strItemName' => $fuelRequisition['strItemName'],
                   'numReqQty' => $fuelRequisition['numReqQty'],
                   'numIssueQty' => $fuelRequisition['numIssueQty'],
                   'strIssueRemarks' => $fuelRequisition['strIssueRemarks'],
               ]);
               $i++;
           }
           return $logDetails;
       } catch (\Exception $e) {
           return $e->getMessage();
       }
       return true;
   }

    public function DeliveryRequisition(Request $request)
    {

        //return $request->requisitions[0]['intBagType'];

        // Add Single Entry in tblStoreIssue table
        // and multiple in tblStoreIssueByItem
        if (count($request->requisitions) == 0) {
            return "No Requisition Given";
        }
        try {
            DB::beginTransaction();
            $intShipmentRequestID = null;

            $decTotalQty = 0;
            foreach ($request->requisitions as $requisition2) {
                $decTotalQty += (float) $requisition2['decQty'];
            }

            $intShipmentRequestID = DB::table(config('constants.DB_Apps') . ".tblShipmentRequest")->insertGetId(
                [
                    'strRequestNo' => $request->strRequestNo,
                    'dteRequestDateTime' => $request->dteRequestDateTime,
                    'dteInsertTime' => Carbon::now(),
                    'intInsertBy' => $request->intInsertBy,
                    'strVehicleProviderType' => $request->strVehicleProviderType,
                    'strVehicleType' => $request->strVehicleType,
                    'intUnitId' => $request->intUnitId,
                    'strLastDestination' => $request->strLastDestination,
                    'strVehicleCapacity' => $request->strVehicleCapacity,
                    'ysnScheduleId' => $request->ysnScheduleId,
                    'decTotalQty' => $decTotalQty,
                    'strDeliveryMode' => $request->strDeliveryMode,
                ]
            );

            $intRequestId = null;

            foreach ($request->requisitions as $requisition) {
                if ($intShipmentRequestID > 0) {
                    $intRequestId = DB::table(config('constants.DB_Apps') . ".tblShipmentRequestDetails")->insertGetId(
                        [
                            'intRequestId' => $intShipmentRequestID,
                            'intSalesOrderId' => $requisition['intSalesOrderId'],
                            'strSalesOrderCode' => $requisition['strSalesOrderCode'],
                            'intCustomerId' => $requisition['intCustomerId'],
                            'intDistPointId' => $requisition['intDistPointId'],
                            'strDestinationAddress' =>  $requisition['strDestinationAddress'],
                            'intBagType' =>  $requisition['intBagType'],
                            'strBagType' =>  $requisition['strBagType'],
                            'decQty' => (float) $requisition['decQty'],
                            'dteInsertTime' =>  Carbon::now()
                        ]
                    );
                }
            }

            // Find Picking Point and Update also in tblShipmentRequest
            $pickingPoint = DB::table(config('constants.DB_Apps') . ".tblShipmentRequestDetails as dt")
                ->leftJoin(config('constants.DB_SAD') . ".tblSalesOrder as so", 'so.intId', '=', 'dt.intSalesOrderId')
                ->leftJoin(config('constants.DB_SAD') . ".tblShippingPoint as sp", 'so.intShipPointId', '=', 'sp.intId')
                ->first();

            if (!is_null($pickingPoint)) {
                DB::table(config('constants.DB_Apps') . ".tblShipmentRequest")
                    ->where('intShipmentRequestID', $intShipmentRequestID)
                    ->update(
                        [
                            'strPickingPointName' => $pickingPoint->strAddress,
                        ]
                    );
            }

            DB::commit();
            return $intShipmentRequestID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }
}
