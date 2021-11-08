<?php

namespace Modules\Distribution\Repositories;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class ShipmentPlanningRepository
{

    public function getShipmentPlanningList($intUnitId, $intCreatedBy = null, $dteStartDate=null, $dteEndDate=null)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(5) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";
        
        $query =  DB::table(config('constants.DB_Apps') . ".tblShipmentPlanning")
        ->leftJoin(config('constants.DB_Logistic') . ".tblVehicleSupplier", 'tblShipmentPlanning.intProviderId', '=', 'tblVehicleSupplier.intId')
        ->leftJoin(config('constants.DB_Logistic') . ".tblVehicle", 'tblShipmentPlanning.intVehicleId', '=', 'tblVehicle.intID')
        ->select(
            "tblShipmentPlanning.intShipmentId",
            "tblShipmentPlanning.strShipmentNo",
            "tblShipmentPlanning.dteScheduledTime",
            "tblShipmentPlanning.dteSheduledDate",
            "tblShipmentPlanning.dteInsertTime",
            "tblShipmentPlanning.intInsertBy",
            "tblShipmentPlanning.strVechicleProviderType",
            "tblShipmentPlanning.strVehicleCapacity",
            "tblShipmentPlanning.strLastDestination",
            "tblShipmentPlanning.decTotalQty",
            "tblShipmentPlanning.intProviderId",
            "tblShipmentPlanning.intVehicleId",
            "tblShipmentPlanning.intDriverId",
            "tblShipmentPlanning.ysnConfirmed",
            "tblShipmentPlanning.intTerritoryID",
            "tblShipmentPlanning.intAssignSupplierID",
            'tblVehicleSupplier.strName as supplierName',
            'tblVehicle.strRegNo as vehicleNo'
        )
        ->where('tblShipmentPlanning.intUnitID', $intUnitId)
        ->whereBetween('tblShipmentPlanning.dteScheduledTime', [$startDate, $endDate]);

        if(!is_null($intCreatedBy)){
            $data = $query->where('tblShipmentPlanning.intInsertBy', $intCreatedBy)->get();
        }else{
            $data =  $query->get();
        }
        
        $outputArray = [];
        foreach ($data as $planning) {
            $dataWithDetails = new stdClass();
            $dataWithDetails->main = $planning;
            $dataWithDetails->details = $this->getShipmentPlanningDetailsData($planning->intShipmentId);
            array_push($outputArray, $dataWithDetails);
        }
        return $outputArray;
    }

    public function getShipmentPlanningDetailsData($intShipmentId)
    {
        $details =  DB::table(config('constants.DB_Apps') . ".tblShipmentPlanningDetails")
        ->select(
            'tblShipmentPlanningDetails.*'
        )
        ->where('tblShipmentPlanningDetails.intShipmentId', $intShipmentId)
        ->get();

        return $details;
    }

    public function editShipmentPlanning(Request $request)
    {
        if (count($request->requisitions) == 0) {
            return "No Item Given";
        }

        try {
            // DB::beginTransaction();
            $intShipmentID = $request->intShipmentId;

            $total = 0;
            foreach ($request->requisitions as $r) {
                $total += $r['decQty'];
            }

            // Update Shipment Table Data
            DB::table(config('constants.DB_Apps') . ".tblShipmentPlanning")
            ->where('intShipmentId', $intShipmentID)
            ->update(
                [
                    'dteScheduledTime' => $request->dteScheduledTime,
                    'strVechicleProviderType' => $request->strVechicleProviderType,
                    'strVehicleCapacity' => $request->strVehicleCapacity,
                    'strLastDestination' => $request->strLastDestination,
                    'intProviderId' => $request->intProviderId,
                    'decTotalQty' => $total,
                    'intVehicleId' => $request->intVehicleId,
                    'intDriverId' => $request->intDriverId,
                    'dteSheduledDate' => $request->dteSheduledDate,
                    'intUpdateBy' => $request->intUpdateBy,
                    'dteUpdateDate' => Carbon::now(),
                    'intAssignSupplierID' => $request->intAssignSupplierID
                ]
            );

            // Delete old Data [Un comment this when on live]
            // DB::table(config('constants.DB_Apps') . ".tblShipmentPlanningDetails")
            // ->where('intShipmentId', $intShipmentID)
            // ->delete();


            foreach ($request->requisitions as $requisition) {
                DB::table(config('constants.DB_Apps') . ".tblShipmentPlanningDetails")
                ->insertGetId(
                    [
                        'intShipmentId' => $intShipmentID,
                        'intRequestId' => $requisition['intRequestId'],
                        'intReqDetailsId' => $requisition['intReqDetailsId'],
                        'intSalesOrderId' => $requisition['intSalesOrderId'],
                        'strSalesOrderCode' => $requisition['strSalesOrderCode'],
                        'intCustomerId' => $requisition['intCustomerId'],
                        'intDistPointId' => $requisition['intDistPointId'],
                        'strDestinationAddress' => $requisition['strDestinationAddress'],
                        'decQty' => $requisition['decQty'],
                        'dteDroppingDateTime' => $requisition['dteDroppingDateTime'],
                        'monLogisticRate' => $requisition['monLogisticRate'],
                        'monTotalLogistic' => $requisition['monTotalLogistic'],
                        'intTerritoryID' => $requisition['intTerritoryID'],
                    ]
                );
            }
            // DB::commit();
            return $intShipmentID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function addShipmentPlanning(Request $request)
    {
        if (count($request->requisitions) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();
            $intPKID = null;

            $total = 0;
            foreach ($request->requisitions as $r) {
                $total += $r['decQty'];
            }

            // Add Shipment Planning Table Data
            $intPKID = DB::table(config('constants.DB_Apps') . ".tblShipmentPlanning")
            ->insertGetId(
                [
                    'intUnitId' => $request->intUnitId,
                    'dteScheduledTime' => $request->dteScheduledTime,
                    'dteInsertTime' => Carbon::now(),
                    'strVechicleProviderType' => $request->strVechicleProviderType,
                    'strVehicleCapacity' => $request->strVehicleCapacity,
                    'strLastDestination' => $request->strLastDestination,
                    'intProviderId' => $request->intProviderId,
                    'decTotalQty' => $total,
                    'intVehicleId' => $request->intVehicleId,
                    'intDriverId' => $request->intDriverId,
                    'intTerritoryID' => $request->intTerritoryID,
                    'dteSheduledDate' => $request->dteSheduledDate,
                    'intInsertBy' => $request->intInsertBy,
                    // 'dteUpdateDate' => Carbon::now(),
                    'intAssignSupplierID' => $request->intAssignSupplierID
                ]
            );

            foreach ($request->requisitions as $requisition) {
                if ($intPKID > 0) {

                $salesOrderId = (int)$requisition['intSalesOrderId'];

                // Fetch data from sales order table
                $salesOrder =  DB::table(config('constants.DB_SAD') . ".tblSalesOrder")
                ->select(
                    'intId',
                    'intCustomerId',
                    'intDisPointId',
                    'strAddress',
                    'intPriceVarId'
                )
                ->where('intId', $salesOrderId)
                ->first();

                if($salesOrderId != null){
                    // Fetch data from sales entry table
                    $salesEntry =  DB::table(config('constants.DB_SAD') . ".tblSalesEntry")
                    ->select(
                        'intId',
                        'intSalesOrderId',
                        'numVehicleVarCharge',
                    )
                    ->where('intSalesOrderId', $salesOrderId)
                    ->first();

                    if(!is_null($salesEntry)){
                        $monLogisticRate = $salesEntry->numVehicleVarCharge;
                        $monTotalLogistic = $salesEntry->numVehicleVarCharge * $requisition['decQty'];
                    }else{
                        $monLogisticRate = 0;
                        $monTotalLogistic = 0;
                    }
                }else{
                    $monLogisticRate = 0;
                    $monTotalLogistic = 0;
                }

                // Insert data in shipment planning details table
                $SPDetailsPkId = DB::table(config('constants.DB_Apps') . ".tblShipmentPlanningDetails")
                    ->insertGetId(
                        [
                            'intShipmentId' => $intPKID,
                            'intRequestId' => $requisition['intRequestId'],
                            'intReqDetailsId' => $requisition['intShipmentRequestDetails'],
                            'intSalesOrderId' => $requisition['intSalesOrderId'],
                            'strSalesOrderCode' => $requisition['strSalesOrderCode'],
                            'intCustomerId' => $salesOrder->intCustomerId,
                            'intDistPointId' => $salesOrder->intDisPointId,
                            'strDestinationAddress' => $salesOrder->strAddress,
                            'decQty' => $requisition['decQty'],
                            'dteDroppingDateTime' => null,
                            'monLogisticRate' => $monLogisticRate,
                            'monTotalLogistic' => $monTotalLogistic,
                            'intTerritoryID' => $request->intTerritoryID,
                        ]
                    );

                    // Update ysnScheduleId to true in tblShipmentRequest table
                    if($SPDetailsPkId > 0){
                        DB::table(config('constants.DB_Apps') . ".tblShipmentRequest")
                        ->where('intShipmentRequestID', $requisition['intRequestId'])
                        ->update(
                            [
                                'ysnScheduleId' => true,
                                'intShipmentPlanningId' => $intPKID,
                                'dteSheduledDate' => $request->dteSheduledDate
                            ]
                        );
                    }
                }
            }
            DB::commit();
            return $intPKID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getSupplierList()
    {        
        $query =  DB::table(config('constants.DB_Apps') . ".tblAppsUserIDNPasswd")
        ->select(
            'intId',
            'strName',
            'ysnEnable',
            'intInsertby',
            'dteInsertDate',
            'strPhone',
            'strPasswd',
            'strUserName',
            'intSupplierID',
            'intUserTypeID'
        )
        ->where('intUserTypeID', 2);

        $data =  $query->orderBy('intId', 'desc')->get();
        
        return $data;
    }

}
