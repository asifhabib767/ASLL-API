<?php

namespace Modules\Sales\Repositories;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\SalesOffice;

class SalesRepository
{

    public function storeSalesOrderEntry(Request $request)
    {
        // Add Single Entry in tblSalesOrder table
        // and multiple in tblSalesOrderDetails

        $queryweightUOM = DB::table(config('constants.DB_SAD') . ".tblUOMWgtVol");

        $intWeightUOM = $queryweightUOM->select(['intWeightUOMId'])

            ->where('tblUOMWgtVol.intUnitId', 4)
            ->value('intWeightUOMId');

        $VolumeUOM = $queryweightUOM->select(['intVolumeUOMId'])

            ->where('tblUOMWgtVol.intUnitId', 4)
            ->value('intVolumeUOMId');

        if (count($request->salesorders) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $i = 1;
            $intSalesOrderID = null;

            // Filtering the requested data
            $ItemArray = [];
            $monTotalQty = 0;
            $monTotalAmount = 0;
            $strNarration = "";
            $monVatPrice = 0;
            $itemwgt = 0;
            foreach ($request->salesorders as $item) {

                // Check If Duplicate Item Arise
                // if (!in_array($item['intItemID'], $ItemArray)) {
                //     $ItemArray[] = $item['intItemID'];
                // } else {
                //     throw new \Exception('Duplicate Item Found !');
                // }

                $monTotalQty += $item['qnt'];
                $monTotalAmount += ($item['qnt'] * $item['pr']);
                $strNarration = $monTotalQty . " " . "Bag";
                $monVatPrice = 15 * $monTotalQty;
                $itemwgt = (50 * $monTotalQty) / 1000;
            }

            $salesOrderCode = $this->generateSalesCode($request);
            // return $salesOrderCode;

            $intSalesOrderID = DB::table(config('constants.DB_SAD') . ".tblSalesOrder")->insertGetId(
                [
                    // // Required Fields
                    'strCode' => $salesOrderCode,
                    'dteDate' => $request->dteDate,
                    'dteReqDelivaryDate' => $request->dteDate,
                    'intUnitId' => $request->intUnitID,

                    'intCustomerId' => $request->intCustomerId,
                    'intDisPointId' => $request->intDisPointId,
                    'intSalesOffId' => $request->intSalesOffId,
                    'numConversionRate' => $request->numConvRate,
                    'intShipPointId' => $request->intShipPointId,

                    'intCustomerType' => $request->intCustomerType,
                    'strAddress' => $request->strAddress,
                    'strOtherInfo' => $request->strOther,
                    'ysnEnable' => true,
                    'ysnCompleted' => true,
                    'dteInsertionTime' => Carbon::now(),

                    'intInsertedBy' => $request->intUserID,
                    'monTotalAmount' => $monTotalAmount,
                    'numPieces' => $monTotalQty,
                    'numApprPieces' => $monTotalQty,
                    'numRestPieces' => $monTotalQty,
                    'intPriceVarId' => $request->intPriceVarId,
                    'intVehicleVarId' => $request->intVehicleVarId,
                    'monExtraAmount' => $request->monExtraAmount,

                    'strExtraCause' => $request->strExtraCause,
                    'strNarration' => $strNarration,
                    'ysnLogistic' => $request->ysnLogistic,
                    'intChargeId' => $request->intChargeId,
                    'numCharge' => $request->numCharge,
                    'intCurrencyId' => $request->intCurrencyId,
                    'intSalesTypeId' => $request->intSalesTypeId,
                    'intIncentiveId' => $request->intIncentiveId,

                    'numIncentive' => $request->numIncentive,
                    'strContactAt' => $request->strContactAt,
                    'strPhone' => $request->strPhone,
                    'monForceCredit' => 0,
                    'monFCBy' => 0,
                    'dteFCTime' => Carbon::now(),
                    'ysnSiteDelivery' => false,
                    'ysnActiveForRestQnt' => true,
                    'monPricewithoutDiscount' => 0,
                    'ysnSubmitByCustomer' => $request->ysnSubmitByCustomer ? true : false,
                    'ysnDOCompleted' => true,
                    'intDOCompletedBy' => $request->intUserID,
                    'dteDOCopmplitionTime' => Carbon::now(),

                ]
            );

            foreach ($request->salesorders as $salesorder) {



                if ($intSalesOrderID > 0) {
                    DB::table(config('constants.DB_SAD') . ".tblSalesOrderDetails")->insertGetId(
                        [
                            'intSOId' => $intSalesOrderID,
                            'intProductId' => $salesorder['intProductId'],
                            'numQuantity' => $salesorder['qnt'],
                            'numApprQuantity' => $salesorder['qnt'],
                            'monPrice' => $salesorder['pr'],
                            'intCOAAccId' => $salesorder['intCOAAccId'],
                            'strCOAAccName' => $salesorder['strCOAAccName'],
                            'monConversionRate' => $salesorder['monConversionRate'],
                            'intCurrencyID' => $salesorder['intCurrencyID'],
                            'intExtraId' => $salesorder['intExtraId'],
                            'monExtraPrice' => $salesorder['monExtraPrice'],
                            'intUom' => $salesorder['intUom'],
                            'strNarration' => $salesorder['strNarration'],
                            'intSalesType' => $salesorder['intSalesType'],


                            'intVehicleVarId' => $salesorder['intVehicleVarId'],
                            'numPromotion' => $salesorder['numPromotion'],
                            'monCommission' => $salesorder['monCommission'],
                            'intIncentiveId' => $salesorder['intIncentiveId'],
                            'numIncentive' => $salesorder['numIncentive'],
                            'monSuppTax' => $salesorder['monSuppTax'],
                            'monVAT' => 15,
                            'monVatPrice' =>    $monVatPrice,
                            'intPromItemId' => $salesorder['intPromItemId'],
                            'strPromItemName' => $salesorder['strPromItemName'],

                            'intPromUOM' => $salesorder['intPromUOM'],
                            'monPromPrice' => $salesorder['pr'],
                            'intPromItemCOAId' => $salesorder['intPromItemCOAId'],
                            'ysnEnable' => true,
                            'dteInsertionTime' => Carbon::now(),
                            'intInsertedBy' => $salesorder['intInsertedBy'],
                            'numWeight' =>  $itemwgt,
                            'numVolume' => $salesorder['numVolume'],
                            'numPromWeight' => $salesorder['numPromWeight'],
                            'numPromVolume' => $salesorder['numPromVolume'],
                            'decDiscountAmount' => $salesorder['decDiscountAmount'],
                            'decDiscountRate' => $salesorder['decDiscountRate'],
                            'numRestQuantity'  => $salesorder['qnt'],

                        ]
                    );
                }
                $i++;
            }
            DB::commit();
            //  return $intSalesOrderID;
            return $salesOrderCode;
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * generate Sales order code
     *
     * @example 110519689
     */
    public function generateSalesCode(Request $request)
    {
        // Get Current Month and year Last 2 Digit
        $month = date('m'); // '07'
        $fullYear = date('Y'); // '2020'

        // Get Prefix By Sales Office ID
        $prefixData = DB::table(config('constants.DB_SAD') . ".tblSalesOffice")
            ->where('intId', $request->intSalesOffId)
            ->first();

        $strCodeFor = null;
        $strPrefix = null;
        $ysnNeedPrefix = true;
        if (!is_null($prefixData)) {
            $strCodeFor = $prefixData->strCodeFor;
            $strPrefix = $prefixData->strPrefix;
            // $ysnNeedPrefix = $prefixData->ysnNeedPrefix;
        }
        $data = DB::table(config('constants.DB_SAD') . ".tblCodeInfo")
            ->where('intUnitID', $request->intUnitID)
            ->where('strCodeFor', $strCodeFor)
            ->where('intYear', date('Y'))
            ->where('intMonth', date('m'))
            ->first();
        $ysnNeedPrefix = $data->ysnNeedPrefix;

        $year = substr($fullYear, 2, 2);
        if (!is_null($data)) {
            $count = $data->intCount;
            $code = $strPrefix . "" . $month . "" . $year . "" . ($count + 1);
            // Update intCount
            DB::table(config('constants.DB_SAD') . ".tblCodeInfo")
                ->where('intUnitID', $request->intUnitID)
                ->where('strCodeFor', $strCodeFor)
                ->where('intYear', $fullYear)
                ->where('intMonth', $month)
                ->update([
                    'intCount' => ($count + 1)
                ]);
        } else {
            // If not return 0
            // Create an entry in tblCodeInfo
            $code = $strPrefix . "" . $month . "" . $year . "" . '1';
            DB::table(config('constants.DB_SAD') . ".tblCodeInfo")->insert(
                [
                    'intUnitID' => $request->intUnitID,
                    'strCodeFor' => $strCodeFor,
                    'intYear' => $fullYear,
                    'intMonth' => $month,
                    'intCount' => 1,
                    'ysnNeedPrefix' => $ysnNeedPrefix,
                    'strPrefix' => $strPrefix,
                ]
            );
        }
        return $code;
    }


 /**
     * generate Sales order code
     *
     * @example 110519689
     */
    public function generateSalesCodeForMultipleitem(Request $request)
    {
        // Get Current Month and year Last 2 Digit
        $month = date('m'); // '07'
        $fullYear = date('Y'); // '2020'

        // Get Prefix By Sales Office ID
        $prefixData = DB::table(config('constants.DB_SAD') . ".tblSalesOffice")
            ->where('intId', $request->intSalesOffId)
            ->first();
        $strCodeFor = null;
        $strPrefix = null;
        $ysnNeedPrefix = true;
        if (!is_null($prefixData)) {
            $strCodeFor = $prefixData->strCodeFor;
            $strPrefix = $prefixData->strPrefix;
            // $ysnNeedPrefix = $prefixData->ysnNeedPrefix;
        }

        $data = DB::table(config('constants.DB_SAD') . ".tblCodeInfo")
            ->where('intUnitID', $request->intUnitID)
            ->where('strCodeFor', $strCodeFor)
            ->where('intYear', $fullYear)
            ->where('intMonth',$month)
            ->first();
        $ysnNeedPrefix = $data->ysnNeedPrefix;

        $year = substr($fullYear, 2, 2);
        if (!is_null($data)) {
            $count = $data->intCount;
            $code = $strPrefix . "" . $month . "" . $year . "" . ($count + 1);
            // Update intCount
            DB::table(config('constants.DB_SAD') . ".tblCodeInfo")
                ->where('intUnitID', $request->intUnitID)
                ->where('strCodeFor', $strCodeFor)
                ->where('intYear', $fullYear)
                ->where('intMonth', $month)
                ->update([
                    'intCount' => ($count + 1)
                ]);
        } else {
            // If not return 0
            // Create an entry in tblCodeInfo
            $code = $strPrefix . "" . $month . "" . $year . "" . '1';
            DB::table(config('constants.DB_SAD') . ".tblCodeInfo")->insert(
                [
                    'intUnitID' => $request->intUnitID,
                    'strCodeFor' => $strCodeFor,
                    'intYear' => $fullYear,
                    'intMonth' => $month,
                    'intCount' => 1,
                    'ysnNeedPrefix' => $ysnNeedPrefix,
                    'strPrefix' => $strPrefix,
                ]
            );
        }
        return $code;
    }

    public function getDataVehicleTypeVsVehicleList($intUnitID, $intTypeId)
    {

        // return $intJobstationID;
        $query = DB::table(config('constants.DB_Logistic') . ".TblVehicle")
            ->join(config('constants.DB_Logistic') . ".TblVehicleType", 'TblVehicleType.intTypeId', '=', 'TblVehicle.intTypeId');

        $output = $query->select(
            [
                'intID as vehicleid', 'strRegNo', 'intDriverEnroll', 'strDriverName', 'ysnOwn', 'TblVehicleType.intTypeId', 'strType'
            ]
        )

            ->where('TblVehicle.intUnitID', $intUnitID)
            ->where('TblVehicleType.intTypeId', $intTypeId)
            ->where('TblVehicle.intCurrentTripId', null)
            ->where('TblVehicle.ysnEnable', true)
            ->where('TblVehicle.ysnOwn', true)
            ->get();

        return $output;
    }

    public function getTerritoryList($intunitid)
    {



        // return $intunitid;
        // return $strPoFor;

        $ItemList = DB::select(
            DB::raw("select pm.intID as Territoryid,pm.strText + ' [' + pm1.strText+' ]'       as TerritoryName
            ,pm1.strText as areaname,pm1.intID as areaid , pm2.strText as RegionName,pm2.intid as regionid
          from erp_sad.dbo.tblItemPriceManager pm
          join erp_sad.dbo.tblItemPriceManager pm1 on pm1.intID=pm.intParentID
          join erp_sad.dbo.tblItemPriceManager pm2 on pm2.intID=pm1.intParentID
          where pm.intLevel=3 and pm.intUnitID=$intunitid
          order by pm1.intid")
        );
        return $ItemList;
    }

    public function getDataVehicleInformation($intID, $intUnitID)
    {

        // return $intID;
        $query = DB::table(config('constants.DB_Logistic') . ".tblVehicle")
            ->leftjoin(config('constants.DB_HR') . ".tblemployee", 'tblemployee.intEmployeeID', '=', 'tblVehicle.intDriverEnroll')
            ->join(config('constants.DB_Logistic') . ".tblVehicleCoverStatus", 'tblVehicleCoverStatus.intID', '=', 'tblVehicle.intCoverStatusID')
            ->join(config('constants.DB_Logistic') . ".TblVehicleType", 'TblVehicleType.intTypeId', '=', 'tblVehicle.intTypeId');
        $output = $query->select(
            [
                'strRegNo', 'strEmployeeName', 'intDriverEnroll', 'intCoverStatusID', 'strCoverStatus', 'strType', 'tblVehicle.ysnEnable'
            ]
        )

            ->where('tblVehicle.intID', $intID)
            ->where('TblVehicle.intUnitID', $intUnitID)
            ->where('TblVehicle.ysnEnable', true)

            ->get();

        return $output;
    }

    public function getDataForCompanyVehicleLabourStatus($intUnitID, $intID)
    {

        // return $intID;

        $query = DB::table(config('constants.DB_SAD') . ".tblItemPriceManager");

        $output = $query->select(
            [
                'intID', 'ysnLabour', 'ysnExtraCharge', 'intLevel', 'strText', 'intUnitID', 'ysnActive', 'strEmailAddress', 'intJSOid', 'strContactNo', 'intEmployeeId', 'HourFromFactory', 'HourFromGhat', 'intDOLive'
            ]
        )

            ->where('tblItemPriceManager.intUnitID', $intUnitID)
            ->where('tblItemPriceManager.intLevel', '=', 3)
            ->where('tblItemPriceManager.intID', $intID)

            ->get();

        return $output;
    }
    public function getDataForBagType($intUnitID)
    {



        // return $intUnitID;

        $query = DB::table(config('constants.DB_SAD') . ".tblBagType");

        $output = $query->select(
            [
                'intID', 'strBagType', 'intUnitID'
            ]
        )

            ->where('tblBagType.intUnitID', $intUnitID)
            ->where('tblBagType.ysnEnable', true)
            ->get();

        return $output;
    }

    public function getDataForItemList($intSalesOffice)
    {

        // return $intSalesOffice;

        $query = DB::table(config('constants.DB_SAD') . ".tblItemNSalesOfficeGroup")
            ->join(config('constants.DB_SAD') . ".tblitem", 'tblitem.intItemNSalesOfficeGroup', '=', 'tblItemNSalesOfficeGroup.intItemNSalesOfficeGroupid')
            ->join(config('constants.DB_SAD') . ".tblUOM", 'tblUOM.intID', '=', 'tblitem.intSellingUOM');
        $output = $query->select(
            [
                'strProductName as strProductName',
                'tblitem.intId',
                'tblitem.intUnitID',
                'intSellingUOM',
                'intLevelOneID',
                'strUOM'
            ]
        )

            ->where('tblItemNSalesOfficeGroup.intSalesOffice', $intSalesOffice)
            ->where('tblitem.ysnActive', true)
            ->get();

        $arrayOutput = [];
        foreach ($output as $item) {
            $item->intId = (int) $item->intId;
            $item->intUnitID = (int) $item->intUnitID;
            $item->intSellingUOM = (int) $item->intSellingUOM;
            $item->intLevelOneID = (int) $item->intLevelOneID;
            $arrayOutput[] = $item;
        }

        return $arrayOutput;
    }


    public function getDataForShippingPointByTerritory($intID)
    {

        // return $intID;

        $query = DB::table(config('constants.DB_SAD') . ".tblShippingPointByTerritory")
            ->join(config('constants.DB_SAD') . ".tblShippingPoint", 'tblShippingPoint.intId', '=', 'tblShippingPointByTerritory.intShippingPoint');
        $output = $query->select(
            [
                'tblShippingPoint.intId', 'strName', 'intTerritoryID'
            ]
        )

            ->where('tblShippingPointByTerritory.intTerritoryID', $intID)

            ->get();

        return $output;
    }

    public function getDataForCustomerType($intUnitId)
    {

        // return $intID;

        $query = DB::table(config('constants.DB_SAD') . ".tblCustomerType");

        $output = $query->select(
            [
                'intTypeID', 'strTypeName', 'intInsertedBy', 'dteInsertedDate', 'ysnEnableInDO', 'ysnEnableInDO2', 'intCOAID', 'intUnitId', 'intAREntryCoaID'
            ]
        )
            ->where('tblCustomerType.intUnitId', $intUnitId)
            ->get();

        return $output;
    }

    public function getDataForSalesType($intUnitId)
    {

        // return $intID;

        $query = DB::table(config('constants.DB_SAD') . ".tblSalesType");

        $output = $query->select(
            [
                'intTypeID', 'strTypeName', 'intUnitID'
            ]
        )
            // ->where('tblSalesType.strTypeName', 'like', '%Local%')
            ->where('tblSalesType.intUnitId', $intUnitId)
            ->get();

        return $output;
    }

    public function getDataForECommerceItemPrice($intProductId, $intThanaID)
    {

        // return $intProductId;
        // return $intThanaID;

        $query = DB::table(config('constants.DB_Apps') . ".tblItemPriceChangeECommerce")
            ->join(config('constants.DB_Logistic') . ".tblVehiclePriceManager as  vpm", 'vpm.intID', '=', 'tblItemPriceChangeECommerce.intThanaID');

        $output = $query->select(
            [
                'intProductId',
                'monPrice',
                'intThanaID',
                'vpm.strText as thana', 'decMinQnt', 'tblItemPriceChangeECommerce.intId'
            ]
        )
            ->where('tblItemPriceChangeECommerce.intProductId', $intProductId)
            ->where('tblItemPriceChangeECommerce.intThanaID', $intThanaID)
            // ->first()
            // ->orderBy('intid', 'DESC');
            ->orderBy('tblItemPriceChangeECommerce.intid', 'desc')
            ->get();

        return $output;
    }

    public function getDataForThanaName($intUnitID, $intID)
    {

        // return $intProductId;
        // return $intThanaID;

        $query = DB::table(config('constants.DB_Logistic') . ".tblVehiclePriceManager as  vpm")
            ->join(config('constants.DB_Logistic') . ".tblVehiclePriceManager as  vpm1", 'vpm.intParentID', '=', 'vpm1.intID');
        $output = $query->select(
            [
                'vpm.strText as thana',
                'vpm.intID'
            ]
        )
            ->where('vpm.intID', '>', 14471)
            ->where('vpm.strText', '!=', "")
            ->where('vpm.strText', '!=', "ABC")
            ->where('vpm.intUnitID', $intUnitID)
            ->orderBy('vpm.strText', 'asc')
            ->get();


        return $output;
    }

    public function getDataForShippingPointConfiguredForTerritory($intUnitID,  $intShippingPoint)
    {

        // return $intProductId;
        // return $intThanaID;

        $query = DB::table(config('constants.DB_SAD') . ".tblShippingPointByTerritory as  pt")
            ->join(config('constants.DB_SAD') . ".qryRegionAreaTerritory as  rat", 'rat.intTerritoryid', '=', 'pt.intTerritoryID')
            ->join(config('constants.DB_SAD') . ".tblShippingPoint as  shp", 'shp.intId', '=', 'pt.intShippingPoint');


        $output = $query->select(
            [
                'rat.strRegion', 'rat.strArea', 'rat.strTerritory', 'shp.strName AS strShippingPoint', 'intInsertBy', 'dteInsertDate', 'rat.intTerritoryid', 'rat.intAreaid', 'rat.intRegion', 'pt.intShippingPoint', 'rat . intUnitID'
            ]
        )

            ->where('shp.intUnitId', $intUnitID)
            ->where('pt.intShippingPoint', $intShippingPoint)

            ->get();


        return $output;
    }

    public function getShippingPointListByUnit($intUnitId)
    {
        $query = DB::table(config('constants.DB_SAD') . ".tblShippingPoint");

        $output = $query->select(['*'])
            ->where('tblShippingPoint.intUnitId', $intUnitId)
            ->get();

        return $output;
    }

    public function addMultipleTerritory(Request $request)
    {
        if (count($request->territories) == 0) {
            return "No Item Given";
        }

        try {
            DB::beginTransaction();

            foreach ($request->territories as $territory) {
                $intPKID = DB::table(config('constants.DB_SAD') . ".tblShippingPointByTerritory")
                    ->insertGetId(
                        [
                            'intTerritoryID' => $territory['intTerritoryId'],
                            'intShippingPoint' => $request->intShippingPoint,
                            'intUnitID' => $request->intUnitID,
                            'ysnEnable' => $request->ysnEnable,
                            'intInsertBy' => $request->intInsertBy,
                            'dteInsertDate' => Carbon::now(),
                            'strRemarks' => $territory['strRemarks'],
                        ]
                    );
            }
            DB::commit();
            return $intPKID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }



    public function getSalesOffices($intUnitId)
    {
        return SalesOffice::where('intUnitId', $intUnitId)
            // ->where('ysnEnable',true);
            ->get();
    }


    public function getChartOfAccountData($itmid, $salestype, $intunitid)
    {

        // return $intID;

        $querySalesType = DB::table(config('constants.DB_SAD') . ".tblSalesType");

        $intModul = $querySalesType->select(['intModuleID'])
            ->where('tblSalesType.intTypeID', $salestype)
            ->where('tblSalesType.intUnitID', $intunitid)
            ->value('intModuleID');

        // return $intModul;
        $queryItem = DB::table(config('constants.DB_SAD') . ".tblItem");

        $intLevelOne = $queryItem->select(['intLevelOneID'])
            ->where('tblItem.intID', $itmid)
            ->value('intLevelOneID');


        // return  $intLevelOne;

        $query = DB::table(config('constants.DB_Accounts') . ".tblAccountsChartOfAcc");



        $output = $query->select([
            'intAccID', 'strAccName'
        ])
            ->where('intUnitID', $intunitid)
            ->where('intModulesDetailsAutoID', (int) $intLevelOne)
            ->where('intModulesAutoID', (int) $intModul)
            ->first();


        return $output;
    }
    public function getSalesOrderProducts($intUnitID)
    {
        $query = DB::table(config('constants.DB_SAD') . ".tblItem")
            ->join(config('constants.DB_SAD') . ".tblUOM", 'tblItem.intSellingUOM', '=', 'tblUOM.intID')
            ->join(config('constants.DB_SAD') . ".tblItemType", 'tblItem.intTypeID', '=', 'tblItemType.intID');


        $output = $query->select(
            [
                'strProductName', 'tblItem.intID', 'tblItem.intUnitID', 'tblItem.intSellingUOM', 'tblItem.intLevelOneID', 'tblUOM.strUOM'
            ]
        )
            ->where('tblItem.intUnitID', $intUnitID)
            ->get();


        return $output;
    }


    public function getCustomerBalanceNUndeliver($intcustomerid, $intunitid, $dteEndDate)
    {
        $user = request()->user();
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        // $ItemList = DB::select(
        //     DB::raw("SELECT  * FROM erp_sad.dbo.funCustomerBalanceNUndeliver ($intcustomerid)")
        // );

        $ItemList = DB::select(
            DB::raw("SELECT * FROM erp_sad.dbo.funCustomerStatementOnCrLimitAPI ('$endDate',$intcustomerid,$user->intEnroll,$intunitid,null)")
        );



        return $ItemList;
    }

    public function getItemWeight($intUOM, $intUOMTr, $numQnt)
    {
        $user = request()->user();

        $ItemList = DB::select(
            DB::raw("SELECT * FROM erp_sad.dbo.funItemUOMConversionApi ($intUOM,$intUOMTr,$numQnt)")
        );



        return $ItemList;
    }



    public function getSalesOrderVsEmployee($strEmailAddress, $intUnitId)
    {
        $startDate = Carbon::now()->addDays(-60);
        $endDate = Carbon::now()->addDays(1);

        $query = DB::table(config('constants.DB_SAD') . ".tblSalesOrder as so")
            ->join(config('constants.DB_SAD') . ".tblShippingPoint as sh", 'so.intShipPointId', '=', 'sh.intId')
            ->join(config('constants.DB_SAD') . ".tblDisPoint as dis", 'so.intDisPointId', '=', 'dis.intDisPointId')
            ->join(config('constants.DB_SAD') . ".tblCustomer as c", 'so.intCustomerId', '=', 'c.intCusID')
            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm", 'so.intPriceVarId', '=', 'pm.intID')
            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm1", 'pm1.intid', '=', 'pm.intParentID');
        $output = $query->select(
            [
                'so.strCode as DONumber', 'so.strNarration as narration', 'so.intDisPointId as shopid', 'dis.strName as shopname', 'so.strAddress as delvadr', 'so.strPhone as phone', 'so.strContactAt as contactat', 'so.dteDate as dodate', 'so.ysnCompleted as ysnenable', 'so.ysnActiveForRestQnt as restqnt', 'so.ysnDOCompleted as ysndocompletestatus', 'pm1.strEmailAddress as email', 'so.intUnitId as intunitid', 'so.intId as soid'
            ]
        )

            ->where('so.ysnEnable', 1)
            ->where('so.intUnitId', $intUnitId)
            ->where('pm1.strEmailAddress', $strEmailAddress)
            ->whereBetween('so.dteDate', [$startDate, $endDate])
            ->orderBy('so.intId', 'DESC')
            ->get();

        // $arrayOutput = [];
        // foreach ($output as $item) {
        //     $item->intId = (int) $item->intId;
        //     $item->intUnitID = (int) $item->intUnitID;
        //     $item->intSellingUOM = (int) $item->intSellingUOM;
        //     $item->intLevelOneID = (int) $item->intLevelOneID;
        //     $arrayOutput[] = $item;
        // }

        // return $arrayOutput;
        return $output;
    }

    public function getSalesOrderVsEmployeeforAEL($strEmailAddress, $intUnitId)
    {
        $startDate = Carbon::now()->addDays(-60);
        $endDate = Carbon::now()->addDays(1);

        $query = DB::table(config('constants.DB_SAD') . ".tblSalesOrder as so")
            ->join(config('constants.DB_SAD') . ".tblShippingPoint as sh", 'so.intShipPointId', '=', 'sh.intId')
            ->join(config('constants.DB_SAD') . ".tblDisPoint as dis", 'so.intDisPointId', '=', 'dis.intDisPointId')
            ->join(config('constants.DB_SAD') . ".tblCustomer as c", 'so.intCustomerId', '=', 'c.intCusID')
            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm", 'so.intPriceVarId', '=', 'pm.intID');

        $output = $query->select(
            [
                'so.strCode as DONumber', 'so.strNarration as narration', 'so.intDisPointId as shopid', 'dis.strName as shopname', 'so.strAddress as delvadr', 'so.strPhone as phone', 'so.strContactAt as contactat', 'so.dteDate as dodate', 'so.ysnCompleted as ysnenable', 'so.ysnActiveForRestQnt as restqnt', 'so.ysnDOCompleted as ysndocompletestatus', 'pm.strEmailAddress as email', 'so.intUnitId as intunitid', 'so.intId as soid'
            ]
        )

            ->where('so.ysnEnable', 1)
            ->where('so.intUnitId', $intUnitId)
            ->where('pm.strEmailAddress', $strEmailAddress)
            ->whereBetween('so.dteDate', [$startDate, $endDate])
            ->orderBy('so.intId', 'DESC')
            ->get();

        // $arrayOutput = [];
        // foreach ($output as $item) {
        //     $item->intId = (int) $item->intId;
        //     $item->intUnitID = (int) $item->intUnitID;
        //     $item->intSellingUOM = (int) $item->intSellingUOM;
        //     $item->intLevelOneID = (int) $item->intLevelOneID;
        //     $arrayOutput[] = $item;
        // }

        // return $arrayOutput;
        return $output;
    }

    public function getCustomersByTSO($strEmailAddress)
    {


        $query = DB::table(config('constants.DB_SAD') . ".tblCustomer as c")

            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm", 'c.IntPriceCatagory', '=', 'pm.intID');
        // ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm1", 'pm1.intID','=','pm.intParentID' );
        $output = $query->select(
            [
                'c.IntCusId as IntCusId',  'c.strAddress as StrAddress',  'c.strName as StrName', 'c.strPhone as StrPhone',  'c.monCreditLimit as MonCreditLimit',  'c.monLedgerBalance as MonLedgerBalance'
            ]
        )



            ->where('pm.strEmailAddress', $strEmailAddress)


            ->get();


        return $output;
    }

    public function getDistributorListByQuery($strEmailAddress)
    {

        $queryForTSO = DB::table(config('constants.DB_SAD') . ".tblItemPriceManager as pm")
            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm1", 'pm1.intID', '=', 'pm.intParentID')
            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm2", 'pm2.intID', '=', 'pm1.intParentID')
            ->join(config('constants.DB_SAD') . ".tblCustomer as c", 'pm.intid', '=', 'c.intPriceCatagory')
            ->join(config('constants.DB_SAD') . ".tblDisPoint as dis", 'c.intCusID', '=', 'dis.intCustomerId')
            ->join(config('constants.DB_Logistic') . ".tblVehiclePriceManager as vpm", 'dis.intLogisticCatagory', '=', 'vpm.intID');
        $output = $queryForTSO->select(
            [
                'pm.intLevel', 'dis.intDisPointId AS intshopid', 'dis.strName', 'vpm.strText as thana', 'c.strName as custname', 'c.intcusid as intcustomerid', 'pm.intUnitID', 'pm.intID AS Tid', 'pm.strCode AS tName', 'pm1.intID AS Aid', 'pm1.strCode as Aname',
                'pm2.intID as Rid', 'pm2.strCode as Rname', 'pm.strEmailAddress'
            ]
        )
            ->where('pm.strEmailAddress', $strEmailAddress)
            ->where('pm.intLevel', 3)
            ->where('dis.ysnEnable', 1);

        // ->get();


        $queryForAreaManager = DB::table(config('constants.DB_SAD') . ".tblItemPriceManager as pm")
            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm1", 'pm1.intID', '=', 'pm.intParentID')
            ->join(config('constants.DB_SAD') . ".tblItemPriceManager as pm2", 'pm2.intID', '=', 'pm1.intParentID')
            ->join(config('constants.DB_SAD') . ".tblCustomer as c", 'pm.intid', '=', 'c.intPriceCatagory')
            ->join(config('constants.DB_SAD') . ".tblDisPoint as dis", 'c.intCusID', '=', 'dis.intCustomerId')
            ->join(config('constants.DB_Logistic') . ".tblVehiclePriceManager as vpm", 'dis.intLogisticCatagory', '=', 'vpm.intID');
        $output = $queryForAreaManager->select(
            [
                'pm.intLevel', 'dis.intDisPointId AS intshopid', 'dis.strName', 'vpm.strText as thana', 'c.strName as custname', 'c.intcusid as intcustomerid', 'pm.intUnitID', 'pm.intID AS Tid', 'pm.strCode AS tName', 'pm1.intID AS Aid', 'pm1.strCode as Aname',
                'pm2.intID as Rid', 'pm2.strCode as Rname', 'pm.strEmailAddress'
            ]
        )
            ->where('pm1.strEmailAddress', $strEmailAddress)
            ->where('pm1.intLevel', 2)
            ->where('dis.ysnEnable', 1)
            ->union($queryForTSO)
            ->get();
        return $output;


        //  $querySalesType = DB::table(config('constants.DB_SAD') . ".tblSalesType");

        //  $intModul = $querySalesType->select(['intModuleID'])
        //      ->where('tblSalesType.intTypeID', $salestype)
        //      ->where('tblSalesType.intUnitID',$intunitid)
        //      ->value('intModuleID');
    }


    public function storeSalesOrderEntryByCustomer(Request $request)
    {
        // Add Single Entry in tblSalesOrder table
        // and multiple in tblSalesOrderDetails

        $queryweightUOM = DB::table(config('constants.DB_SAD') . ".tblUOMWgtVol");

        $intWeightUOM = $queryweightUOM->select(['intWeightUOMId'])

            ->where('tblUOMWgtVol.intUnitId', 4)
            ->value('intWeightUOMId');

        $VolumeUOM = $queryweightUOM->select(['intVolumeUOMId'])

            ->where('tblUOMWgtVol.intUnitId', 4)
            ->value('intVolumeUOMId');


        $queryysnDOComplete = DB::table(config('constants.DB_SAD') . ".tblSalesOffice");

        $ysnDOComplete = $queryysnDOComplete->select(['ysnDOCompleteAuto'])

            ->where('tblSalesOffice.intId', $request->intSalesOffId)
            ->value('ysnDOCompleteAuto');

        // if ($ysnDOComplete) {
        //     DB::table('tblSalesOrder')
        //         ->update(
        //             ['email' => 'john@example.com', 'name' => 'John'],
        //             ['votes' => '2']
        //         );
        // }






        if (count($request->salesorders) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $i = 1;
            $intSalesOrderID = null;

            // Filtering the requested data
            $ItemArray = [];
            $monTotalQty = 0;
            $monTotalAmount = 0;
            $strNarration = "";
            $monVatPrice = 0;
            $itemwgt = 0;
            foreach ($request->salesorders as $item) {

                // Check If Duplicate Item Arise
                // if (!in_array($item['intItemID'], $ItemArray)) {
                //     $ItemArray[] = $item['intItemID'];
                // } else {
                //     throw new \Exception('Duplicate Item Found !');
                // }

                $monTotalQty += $item['qnt'];
                $monTotalAmount += ($item['qnt'] * $item['pr']);
                $strNarration = $monTotalQty . " " . "Bag";
                $monVatPrice = 15 * $monTotalQty;
                $itemwgt = (50 * $monTotalQty) / 1000;
            }

            $salesOrderCode = $this->generateSalesCode($request);
            // return $salesOrderCode;

            $intSalesOrderID = DB::table(config('constants.DB_SAD') . ".tblSalesOrder")->insertGetId(
                [
                    // // Required Fields
                    'strCode' => $salesOrderCode,
                    'dteDate' => $request->dteDate,
                    'dteReqDelivaryDate' => $request->dteDate,
                    'intUnitId' => $request->intUnitID,

                    'intCustomerId' => $request->intCustomerId,
                    'intDisPointId' => $request->intDisPointId,
                    'intSalesOffId' => $request->intSalesOffId,
                    'numConversionRate' => $request->numConvRate,
                    'intShipPointId' => $request->intShipPointId,

                    'intCustomerType' => $request->intCustomerType,
                    'strAddress' => $request->strAddress,
                    'strOtherInfo' => $request->strOther,
                    'ysnEnable' => true,
                    'ysnCompleted' => true,
                    'dteInsertionTime' => Carbon::now(),

                    'intInsertedBy' => $request->intUserID,
                    'monTotalAmount' => $monTotalAmount,
                    'numPieces' => $monTotalQty,
                    'numApprPieces' => $monTotalQty,
                    'numRestPieces' => $monTotalQty,
                    'intPriceVarId' => $request->intPriceVarId,
                    'intVehicleVarId' => $request->intVehicleVarId,
                    'monExtraAmount' => $request->monExtraAmount,

                    'strExtraCause' => $request->strExtraCause,
                    'strNarration' => $strNarration,
                    'ysnLogistic' => $request->ysnLogistic,
                    'intChargeId' => $request->intChargeId,
                    'numCharge' => $request->numCharge,
                    'intCurrencyId' => $request->intCurrencyId,
                    'intSalesTypeId' => $request->intSalesTypeId,
                    'intIncentiveId' => $request->intIncentiveId,

                    'numIncentive' => $request->numIncentive,
                    'strContactAt' => $request->strContactAt,
                    'strPhone' => $request->strPhone,
                    'monForceCredit' => 0,
                    'monFCBy' => 0,
                    'dteFCTime' => Carbon::now(),
                    'ysnSiteDelivery' => false,
                    'ysnActiveForRestQnt' => true,
                    'monPricewithoutDiscount' => 0,
                    'ysnSubmitByCustomer' => true,
                    'ysnDOCompleted' => true,
                    'intDOCompletedBy' => $request->intUserID,
                    'dteDOCopmplitionTime' => Carbon::now(),

                ]
            );

            foreach ($request->salesorders as $salesorder) {



                if ($intSalesOrderID > 0) {
                    DB::table(config('constants.DB_SAD') . ".tblSalesOrderDetails")->insertGetId(
                        [
                            'intSOId' => $intSalesOrderID,
                            'intProductId' => $salesorder['intProductId'],
                            'numQuantity' => $salesorder['qnt'],
                            'numApprQuantity' => $salesorder['qnt'],
                            'monPrice' => $salesorder['pr'],
                            'intCOAAccId' => $salesorder['intCOAAccId'],
                            'strCOAAccName' => $salesorder['strCOAAccName'],
                            'monConversionRate' => $salesorder['monConversionRate'],
                            'intCurrencyID' => $salesorder['intCurrencyID'],
                            'intExtraId' => $salesorder['intExtraId'],
                            'monExtraPrice' => $salesorder['monExtraPrice'],
                            'intUom' => $salesorder['intUom'],
                            'strNarration' => $salesorder['strNarration'],
                            'intSalesType' => $salesorder['intSalesType'],


                            'intVehicleVarId' => $salesorder['intVehicleVarId'],
                            'numPromotion' => $salesorder['numPromotion'],
                            'monCommission' => $salesorder['monCommission'],
                            'intIncentiveId' => $salesorder['intIncentiveId'],
                            'numIncentive' => $salesorder['numIncentive'],
                            'monSuppTax' => $salesorder['monSuppTax'],
                            'monVAT' => 15,
                            'monVatPrice' =>    $monVatPrice,
                            'intPromItemId' => $salesorder['intPromItemId'],
                            'strPromItemName' => $salesorder['strPromItemName'],

                            'intPromUOM' => $salesorder['intPromUOM'],
                            'monPromPrice' => $salesorder['pr'],
                            'intPromItemCOAId' => $salesorder['intPromItemCOAId'],
                            'ysnEnable' => true,
                            'dteInsertionTime' => Carbon::now(),
                            'intInsertedBy' => $salesorder['intInsertedBy'],
                            'numWeight' =>  $itemwgt,
                            'numVolume' => $salesorder['numVolume'],
                            'numPromWeight' => $salesorder['numPromWeight'],
                            'numPromVolume' => $salesorder['numPromVolume'],
                            'decDiscountAmount' => $salesorder['decDiscountAmount'],
                            'decDiscountRate' => $salesorder['decDiscountRate'],
                            'numRestQuantity'  => $salesorder['qnt'],

                        ]
                    );
                }
                $i++;
            }
            DB::commit();
            //  return $intSalesOrderID;
            return $salesOrderCode;
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function GetDONChallanQntUpdate($strCode, $intUnitId)
    {
        // 3342833

        $ItemList = DB::select(
            DB::raw("SELECT  * FROM erp_sad.dbo.funDONChallanQntUpdate ($strCode,$intUnitId)")
        );

        foreach ($ItemList as $item) {
            $challanList = DB::table(config('constants.DB_SAD') . ".tblSalesOrder")
                ->where('intId', $item->intOrderID)
                ->update([
                    'numPieces' => $item->ChallanQnt,
                    'numRestPieces' => 0,
                    'numApprPieces' => $item->ChallanQnt,
                    'intRestofQntModifyBy' => $item->intCustomerId,
                    'dteResofQntModify' => Carbon::now(),
                ]);
            DB::table(config('constants.DB_SAD') . ".tblSalesOrderDetails")
                ->where('intSOId', $item->intOrderID)
                ->where('intProductId', $item->intProductId)
                ->update([
                    'numQuantity' => $item->ChallanQnt,
                    'numApprQuantity' => $item->ChallanQnt,
                    'numRestQuantity' => 0,
                ]);
            return $challanList;
        }

        // $strCode = $request->strCode;
        // $intsoid= $ItemList->intOrderID;


    }

    public function getDeliveryRequstDo($intPart,$intEmployeeID)
    {
        // 3342833

        $ItemList = DB::select(
            DB::raw("SELECT  * FROM erp_sad.dbo.funTerritoryUndeliver ($intPart,$intEmployeeID)")
        );
return   $ItemList;

    }

    public function storeSalesOrderEntryByMultipleItem(Request $request)
    {
        // Add Single Entry in tblSalesOrder table
        // and multiple in tblSalesOrderDetails
        $queryweightUOM = DB::table(config('constants.DB_SAD') . ".tblUOMWgtVol");

        $intWeightUOM = $queryweightUOM->select(['intWeightUOMId'])

            ->where('tblUOMWgtVol.intUnitId', $request->intUnitID)
            ->value('intWeightUOMId');

        $VolumeUOM = $queryweightUOM->select(['intVolumeUOMId'])

            ->where('tblUOMWgtVol.intUnitId', $request->intUnitID)
            ->value('intVolumeUOMId');


        $queryysnDOComplete = DB::table(config('constants.DB_SAD') . ".tblSalesOffice");

        $ysnDOComplete = $queryysnDOComplete->select(['ysnDOCompleteAuto'])

            ->where('tblSalesOffice.intId', $request->intSalesOffId)
            ->value('ysnDOCompleteAuto');





        if (count($request->salesorders) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $i = 1;
            $intSalesOrderID = null;

            // Filtering the requested data
            $ItemArray = [];
            $monTotalQty = 0;
            $monTotalAmount = 0;
            $strNarration = "";
            $monVatPrice = 0;
            $itemwgt = 0;
            foreach ($request->salesorders as $item) {

                // Check If Duplicate Item Arise
                // if (!in_array($item['intItemID'], $ItemArray)) {
                //     $ItemArray[] = $item['intItemID'];
                // } else {
                //     throw new \Exception('Duplicate Item Found !');
                // }

                $monTotalQty += $item['qnt'];
                $monTotalAmount += ($item['qnt'] * $item['pr']);
                $strNarration = $monTotalQty . " " . "KG";
                $monVatPrice = 15 * $monTotalQty;
                $itemwgt = (1 * $monTotalQty) / 1000;
            }



      $salesOrderCode = $this->generateSalesCodeForMultipleitem($request);

            $intSalesOrderID = DB::table(config('constants.DB_SAD') . ".tblSalesOrder")->insertGetId(
                [
                    // // Required Fields
                    'strCode' => $salesOrderCode,
                    'dteDate' => $request->dteDate,
                    'dteReqDelivaryDate' => $request->dteDate,
                    'intUnitId' => $request->intUnitID,

                    'intCustomerId' => $request->intCustomerId,
                    'intDisPointId' => $request->intDisPointId,
                    'intSalesOffId' => $request->intSalesOffId,
                    'numConversionRate' => $request->numConvRate,
                    'intShipPointId' => $request->intShipPointId,

                    'intCustomerType' => $request->intCustomerType,
                    'strAddress' => $request->strAddress,
                    'strOtherInfo' => $request->strOther,
                    'ysnEnable' => true,
                    'ysnCompleted' => true,
                    'dteInsertionTime' => Carbon::now(),

                    'intInsertedBy' => $request->intUserID,
                    'monTotalAmount' => $monTotalAmount,
                    'numPieces' => $monTotalQty,
                    'numApprPieces' => $monTotalQty,
                    'numRestPieces' => $monTotalQty,
                    'intPriceVarId' => $request->intPriceVarId,
                    'intVehicleVarId' => $request->intVehicleVarId,
                    'monExtraAmount' => $request->monExtraAmount,

                    'strExtraCause' => $request->strExtraCause,
                    'strNarration' => $strNarration,
                    'ysnLogistic' => $request->ysnLogistic,
                    'intChargeId' => $request->intChargeId,
                    'numCharge' => $request->numCharge,
                    'intCurrencyId' => $request->intCurrencyId,
                    'intSalesTypeId' => $request->intSalesTypeId,
                    'intIncentiveId' => $request->intIncentiveId,

                    'numIncentive' => $request->numIncentive,
                    'strContactAt' => $request->strContactAt,
                    'strPhone' => $request->strPhone,
                    'monForceCredit' => 0,
                    'monFCBy' => 0,
                    'dteFCTime' => Carbon::now(),
                    'ysnSiteDelivery' => false,
                    'ysnActiveForRestQnt' => true,
                    'monPricewithoutDiscount' => 0,
                    'ysnSubmitByCustomer' => false,
                    'ysnDOCompleted' => true,
                    'intDOCompletedBy' => $request->intUserID,
                    'dteDOCopmplitionTime' => Carbon::now(),

                ]
            );

            foreach ($request->salesorders as $salesorder) {
           if ($intSalesOrderID > 0) {
                    DB::table(config('constants.DB_SAD') . ".tblSalesOrderDetails")->insertGetId(
                        [
                            'intSOId' => $intSalesOrderID,
                            'intProductId' => $salesorder['intProductId'],
                            'numQuantity' => $salesorder['qnt'],
                            'numApprQuantity' => $salesorder['qnt'],
                            'monPrice' => $salesorder['pr'],
                            'intCOAAccId' => $salesorder['intCOAAccId'],
                            'strCOAAccName' => $salesorder['strCOAAccName'],
                            'monConversionRate' => $salesorder['monConversionRate'],
                            'intCurrencyID' => $salesorder['intCurrencyID'],
                            'intExtraId' => $salesorder['intExtraId'],
                            'monExtraPrice' => $salesorder['monExtraPrice'],
                            'intUom' => $salesorder['intUom'],
                            'strNarration' => $salesorder['strNarration'],
                            'intSalesType' => $salesorder['intSalesType'],


                            'intVehicleVarId' => $salesorder['intVehicleVarId'],
                            'numPromotion' => $salesorder['numPromotion'],
                            'monCommission' => $salesorder['monCommission'],
                            'intIncentiveId' => $salesorder['intIncentiveId'],
                            'numIncentive' => $salesorder['numIncentive'],
                            'monSuppTax' => $salesorder['monSuppTax'],
                            'monVAT' => 15,
                            'monVatPrice' =>    $monVatPrice,
                            'intPromItemId' => $salesorder['intPromItemId'],
                            'strPromItemName' => $salesorder['strPromItemName'],

                            'intPromUOM' => $salesorder['intPromUOM'],
                            'monPromPrice' => $salesorder['pr'],
                            'intPromItemCOAId' => $salesorder['intPromItemCOAId'],
                            'ysnEnable' => true,
                            'dteInsertionTime' => Carbon::now(),
                            'intInsertedBy' => $salesorder['intInsertedBy'],
                            'numWeight' =>  $itemwgt,
                            'numVolume' => $salesorder['numVolume'],
                            'numPromWeight' => $salesorder['numPromWeight'],
                            'numPromVolume' => $salesorder['numPromVolume'],
                            'decDiscountAmount' => $salesorder['decDiscountAmount'],
                            'decDiscountRate' => $salesorder['decDiscountRate'],
                            'numRestQuantity'  => $salesorder['qnt'],

                        ]
                    );
                }
                $i++;
            }
            DB::commit();

            return $salesOrderCode;
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function storeSalesOrderEntryByMultipleItemForUseColumn(Request $request)
    {
        // Add Single Entry in tblSalesOrder table
        // and multiple in tblSalesOrderDetails

        $queryweightUOM = DB::table(config('constants.DB_SAD') . ".tblUOMWgtVol");

        $intWeightUOM = $queryweightUOM->select(['intWeightUOMId'])

            ->where('tblUOMWgtVol.intUnitId', $request->intUnitID)
            ->value('intWeightUOMId');

        $VolumeUOM = $queryweightUOM->select(['intVolumeUOMId'])

            ->where('tblUOMWgtVol.intUnitId', $request->intUnitID)
            ->value('intVolumeUOMId');


        $queryysnDOComplete = DB::table(config('constants.DB_SAD') . ".tblSalesOffice");

        $ysnDOComplete = $queryysnDOComplete->select(['ysnDOCompleteAuto'])

            ->where('tblSalesOffice.intId', $request->intSalesOffId)
            ->value('ysnDOCompleteAuto');





        if (count($request->salesorders) == 0) {
            return "No Item Given";
        }
        try {
            DB::beginTransaction();
            $i = 1;
            $intSalesOrderID = null;

            // Filtering the requested data
            $ItemArray = [];
            $monTotalQty = 0;
            $monTotalAmount = 0;
            $strNarration = "";
            $monVatPrice = 0;
            $itemwgt = 0;

        $querycust = DB::table(config('constants.DB_SAD') . ".tblCustomer");

            $custname = $querycust->select(['strName'])
            ->where('intCusID', $request->intCustomerId)
            ->value('strName');
            foreach ($request->salesorders as $item) {

                // Check If Duplicate Item Arise
                // if (!in_array($item['intItemID'], $ItemArray)) {
                //     $ItemArray[] = $item['intItemID'];
                // } else {
                //     throw new \Exception('Duplicate Item Found !');
                // }


                $queryprdname = DB::table(config('constants.DB_SAD') . ".tblitem");
                $prdname = $queryprdname->select(['strProductName'])
                 ->where('intid', $item['productId'])
                ->value('strProductName');

                $queryUOM = DB::table(config('constants.DB_SAD') . ".tblUOM");
                $uomname = $queryUOM->select(['strUOM'])
                ->where('intid', $item['intUom'])
                ->value('strUOM');

                $monTotalQty += $item['quantity'];
                $monTotalAmount += ($item['quantity'] * $item['price']);
              //  $strNarration = $monTotalQty . " " . "KG";

                $strNarration = $monTotalQty . " " .  $uomname. " " . $prdname . " " .$custname;
                $monVatPrice = 15 * $monTotalQty;
                $itemwgt = (1 * $monTotalQty) / 1000;
            }



      $salesOrderCode = $this->generateSalesCodeForMultipleitem($request);

            $intSalesOrderID = DB::table(config('constants.DB_SAD') . ".tblSalesOrder")->insertGetId(
                [
                    // // Required Fields
                    'strCode' => $salesOrderCode,
                    'dteDate' => $request->dteDate,
                    'dteReqDelivaryDate' => $request->dteDate,
                    'intUnitId' => $request->intUnitID,

                    'intCustomerId' => $request->intCustomerId,
                    'intDisPointId' => $request->intDisPointId,
                    'intSalesOffId' => $request->intSalesOffId,
                    'numConversionRate' => $request->numConvRate,
                    'intShipPointId' => $request->intShipPointId,

                    'intCustomerType' => $request->intCustomerType,
                    'strAddress' => $request->strAddress,
                    'strOtherInfo' => $request->strOther,
                    'ysnEnable' => true,
                    'ysnCompleted' => true,
                    'dteInsertionTime' => Carbon::now(),

                    'intInsertedBy' => $request->intUserID,
                    'monTotalAmount' => $monTotalAmount,
                    'numPieces' => $monTotalQty,
                    'numApprPieces' => $monTotalQty,
                    'numRestPieces' => $monTotalQty,
                    'intPriceVarId' => $request->intPriceVarId,
                    'intVehicleVarId' => $request->intVehicleVarId,
                    'monExtraAmount' => $request->monExtraAmount,

                    'strExtraCause' => $request->strExtraCause,
                    'strNarration' => $strNarration,
                    'ysnLogistic' => $request->ysnLogistic,
                    'intChargeId' => $request->intChargeId,
                    'numCharge' => $request->numCharge,
                    'intCurrencyId' => $request->intCurrencyId,
                    'intSalesTypeId' => $request->intSalesTypeId,
                    'intIncentiveId' => $request->intIncentiveId,

                    'numIncentive' => $request->numIncentive,
                    'strContactAt' => $request->strContactAt,
                    'strPhone' => $request->strPhone,
                    'monForceCredit' => 0,
                    'monFCBy' => 0,
                    'dteFCTime' => Carbon::now(),
                    'ysnSiteDelivery' => false,
                    'ysnActiveForRestQnt' => true,
                    'monPricewithoutDiscount' => 0,
                    'ysnSubmitByCustomer' => false,
                    'ysnDOCompleted' => false,
                    'intDOCompletedBy' => $request->intUserID,
                    'dteDOCopmplitionTime' => Carbon::now(),

                ]
            );

            foreach ($request['salesorders'] as $salesorder) {
           if ($intSalesOrderID > 0) {
                    DB::table(config('constants.DB_SAD') . ".tblSalesOrderDetails")->insertGetId(
                        [
                            'intSOId' => $intSalesOrderID,
                            'intProductId' => $salesorder['productId'],
                            'numQuantity' => $salesorder['quantity'],
                            'numApprQuantity' => $salesorder['quantity'],
                            'monPrice' =>$salesorder['price'],

                            'intCOAAccId' => $salesorder['product_accId'],
                            'strCOAAccName' => $salesorder['product_accName'],
                            'intUom'=> $salesorder['intUom'],
                            'strNarration'=> $salesorder['strNarration'],
                            'intSalesType'=> $salesorder['intSalesType'],
                            'intVehicleVarId'=> $salesorder['intVehicleVarId'],
                            'intIncentiveId'=> $salesorder['intIncentiveId'],
                            'numIncentive'=> $salesorder['numIncentive'],
                            'monSuppTax'=> $salesorder['monSuppTax'],
                            'monVAT'=> 15,
                            'monVatPrice'=>  $monVatPrice,
                            'numRestQuantity'=> $salesorder['quantity'],

                            'monConversionRate' => 1,
                            'intCurrencyID' => 1,
                            'intExtraId' => 35,
                            'monExtraPrice' => 0,
                            'numPromotion' => 0,
                            'monCommission' => 0,
                            'intPromItemId' => $salesorder['productId'],
                            'strPromItemName' => "na",

                            'intPromUOM' => $salesorder['intUom'],
                            'monPromPrice' =>$salesorder['price'],
                            'intPromItemCOAId' => $salesorder['product_accId'],
                            'ysnEnable' => true,
                            'dteInsertionTime' => Carbon::now(),
                            'intInsertedBy' => $request->intUserID,
                            'numWeight' =>  $itemwgt,
                            'numVolume' => 0,
                            'numPromWeight' => 0,
                            'numPromVolume' => 0,
                            'decDiscountAmount' =>0,
                            'decDiscountRate' =>0,



                        ]
                    );
                }
                $i++;
            }
            DB::commit();

            return $salesOrderCode;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getSalesOrderVsItemDetails($intUnitId, $intId)
    {

// return $intId;

        $ItemDetaills = DB::table(config('constants.DB_SAD') . ".tblsalesorder as so")
            ->join(config('constants.DB_SAD') . ".tblSalesOrderDetails as sod", 'so.intId', '=', 'sod.intSOId')
            ->join(config('constants.DB_SAD') . ".tblitem as i", 'i.intID', '=', 'sod.intProductId');

    //   return   $ItemDetaills;


            $output = $ItemDetaills->select(
            [
                'strCode','intProductId','numApprQuantity','numRestQuantity','strProductName'
            ]
        )
            ->where('so.intUnitId', $intUnitId)
            ->where('so.intId',  $intId)

            ->get();
        return $output;



    }

}
