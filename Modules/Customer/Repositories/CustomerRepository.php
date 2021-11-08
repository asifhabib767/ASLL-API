<?php

namespace Modules\Customer\Repositories;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{

    public function getCustomerVsShopInfo($intUnitId, $intCustomerId)
    {
        $ItemList = DB::select(
            DB::raw("SELECT
                dis.intCusID,
                dis.intCusType,
                dis.intDisPointId,
                dis.intSalesOffId,
                dis.intUnitId,
                dis.strDisPointName,
                dis.ysnEnable,
                '' as strEmailAddress,
                dis.strCusName,
                dis.strAddress,
                dis.strContactNo,
                dis.strContactPerson,
                dis.intLogisticCatagory,
                dis.intPriceCatagory
                FROM erp_sad.dbo.qryDisPoint dis
                where intUnitId=$intUnitId and intCusID=$intCustomerId and ysnEnable=1
                order by dis.strDisPointName
            ")
        );
        return $ItemList;
    }

    public function getCustomerVsShopInfoByEmail($intUnitId, $strEmailAddress)
    {

        $queryintLevel = DB::table(config('constants.DB_SAD') . ".tblItemPriceManager");

        $intModul = $queryintLevel->select(['intLevel'])
            ->where('tblItemPriceManager.intUnitID', $intUnitId)
            ->where('tblItemPriceManager.strEmailAddress', $strEmailAddress)
            ->value('intLevel');

        // return   $intModul;

        if ($intModul == 3) {
            $query = DB::table(config('constants.DB_SAD') . ".tblDisPoint as dis")
                ->Join(config('constants.DB_SAD') . ".tblcustomer as c", 'c.intCusID', '=', 'dis.intCustomerId')
                ->Join(config('constants.DB_SAD') . ".tblItemPriceManager as  pm", 'dis.intPriceCatagory', '=', 'pm.intID')
                ->Join(config('constants.DB_SAD') . ".tblItemPriceManager as pm1", 'pm1.intID', '=', 'pm.intParentID');

            $output = $query->select(
                [
                    'dis.intCustomerId as intCusID', 'c.intCusType as intCusType', 'intDisPointId', 'intSalesOffId', 'dis.intUnitId as intUnitId', 'dis.strName as  strDisPointName', 'dis.ysnEnable as  ysnEnable', 'pm.strEmailAddress as strEmailAddress', 'c.strName as strCusName', 'dis.strAddress as strAddress', 'dis.strContactNo as strContactNo', 'strContactPerson', 'dis.intLogisticCatagory as intLogisticCatagory', 'dis.intPriceCatagory as intPriceCatagory', 'pm1.strEmailAddress'

                ]
            )
                ->where('pm1.intUnitID', $intUnitId)
                ->where('pm1.strEmailAddress', $strEmailAddress)

                ->where('pm1.intLevel', $intModul)

                ->get();
        } else if ($intModul == 4) {
            // return 1;

            $query = DB::table(config('constants.DB_SAD') . ".tblDisPoint as dis")
                ->Join(config('constants.DB_SAD') . ".tblcustomer as c", 'c.intCusID', '=', 'dis.intCustomerId')
                ->Join(config('constants.DB_SAD') . ".tblItemPriceManager as  pm", 'dis.intPriceCatagory', '=', 'pm.intID');

            //  return  $query;
            $output = $query->select(
                [
                    'dis.intCustomerId as intCusID', 'c.intCusType as intCusType', 'intDisPointId', 'intSalesOffId', 'dis.intUnitId as intUnitId', 'dis.strName as  strDisPointName', 'dis.ysnEnable as  ysnEnable', 'pm.strEmailAddress as strEmailAddress', 'c.strName as strCusName', 'dis.strAddress as strAddress', 'dis.strContactNo as strContactNo', 'strContactPerson', 'dis.intLogisticCatagory as intLogisticCatagory', 'dis.intPriceCatagory as intPriceCatagory', 'pm.strEmailAddress'

                ]
            )
                ->where('pm.intUnitID', $intUnitId)
                ->where('pm.strEmailAddress', $strEmailAddress)

                ->where('pm.intLevel', $intModul)

                ->get();
        }




        return $output;
    }

    public function getCustomerVsShopInforLevel3($intUnitId, $strEmailAddress)
    {

        $queryintLevel = DB::table(config('constants.DB_SAD') . ".tblItemPriceManager");

        $intModul = $queryintLevel->select(['intLevel'])
            ->where('tblItemPriceManager.intUnitID', $intUnitId)
            ->where('tblItemPriceManager.strEmailAddress', $strEmailAddress)
            ->value('intLevel');

        // return   $intModul;

        if ($intModul == 3) {
            $query = DB::table(config('constants.DB_SAD') . ".tblDisPoint as dis")
                ->Join(config('constants.DB_SAD') . ".tblcustomer as c", 'c.intCusID', '=', 'dis.intCustomerId')
                ->Join(config('constants.DB_SAD') . ".tblItemPriceManager as  pm", 'dis.intPriceCatagory', '=', 'pm.intID');


            $output = $query->select(
                [
                    'dis.intCustomerId as intCusID', 'c.intCusType as intCusType', 'intDisPointId', 'intSalesOffId', 'dis.intUnitId as intUnitId', 'dis.strName as  strDisPointName', 'dis.ysnEnable as  ysnEnable', 'pm.strEmailAddress as strEmailAddress', 'c.strName as strCusName', 'dis.strAddress as strAddress', 'dis.strContactNo as strContactNo', 'strContactPerson', 'dis.intLogisticCatagory as intLogisticCatagory', 'dis.intPriceCatagory as intPriceCatagory', 'pm.strEmailAddress'

                ]
            )
                ->where('pm.intUnitID', $intUnitId)
                ->where('pm.strEmailAddress', $strEmailAddress)

                ->where('pm.intLevel', $intModul)

                ->get();
        }




        return $output;
    }

    /**
     * Get Customers Sales Order for customer base
     *
     * @param integer $intUnitId
     * @param string $dteStartDate
     * @param string $dteEndDate
     * @param integer $intCustomerId
     * @param integer $intSalesOffId
     * @return void
     */
    public function getCustomerVsSalesOrder($intUnitId, $dteStartDate, $dteEndDate, $intCustomerId, $intSalesOffId)
    {
        $startDate = is_null($dteStartDate) ? Carbon::now()->subDays(30) :  $dteStartDate . " 00:00:00.000";
        $endDate = is_null($dteEndDate) ? Carbon::now()->addDays(1) :  $dteEndDate . " 23:59:59.000";

        $query = DB::table(config('constants.DB_SAD') . ".tblSalesOrder")
            ->leftJoin(config('constants.DB_SAD') . ".tblShippingPoint", 'tblSalesOrder.intShipPointId', '=', 'tblShippingPoint.intId')
            ->leftJoin(config('constants.DB_SAD') . ".tblDisPoint", 'tblDisPoint.intDisPointId', '=', 'tblSalesOrder.intDisPointId')
            ->leftJoin(config('constants.DB_SAD') . ".tblCustomer", 'tblCustomer.intCusID', '=', 'tblSalesOrder.intCustomerId');

        $output = $query->select(
            [
                'tblSalesOrder.strCode as DONumber',
                'tblsalesorder.dteDate as dodate',
                'tblcustomer.strName',
                'tblDisPoint.strName as shopname',
                'tblDisPoint.intDisPointId as shopid',
                'tblsalesorder.strAddress as delvadr',
                'tblsalesorder.ysnLogistic',
                'tblsalesorder.strNarration as narration',
                'tblsalesorder.numApprPieces',
                'tblsalesorder.numPieces',
                'tblsalesorder.numRestPieces as restqnt',
                'tblsalesorder.monTotalAmount',
                'tblsalesorder.strContactAt as contactat',
                'tblShippingPoint.strName as shippingpoint',
                'tblsalesorder.ysnEnable as ysnenable',
                'tblsalesorder.ysnCompleted as ysndocompletestatus',
                'tblsalesorder.intUnitId as intunitid',
                'tblsalesorder.strPhone as phone',
                'tblsalesorder.intId',
            ]
        )
            ->where('tblsalesorder.intUnitId', $intUnitId)
           ->whereBetween('tblsalesorder.dteDate', [$startDate, $endDate])
            ->where('tblsalesorder.intCustomerId', $intCustomerId)
             ->where('tblsalesorder.intSalesOffId', $intSalesOffId)
            ->where('tblsalesorder.ysnEnable', true)
            ->where('tblsalesorder.ysnCompleted', true)
            ->where('tblsalesorder.ysnDOCompleted', true)
            ->orderBy('tblsalesorder.intid', 'desc')
            ->get();
        return $output;
    }

    /**
     * Get Unit VS Shop Searching
     *
     * Get Unit List
     *
     * @param integer $intUnitId
     * @param integer $strDisPointName
     * @return void
     */
    public function getUnitvsShopSearching($intUnitId, $strDisPointName)
    {
        $ItemList = DB::select(
            DB::raw("SELECT dis.intCusID, dis.intCusType, dis.intDisPointId, dis.intSalesOffId, dis.intUnitId, dis.strDisPointName, dis.ysnEnable
            ,'' as strEmailAddress, dis.strCusName, dis.strAddress, dis.strContactNo, dis.strContactPerson,
            dis.intLogisticCatagory, dis.intPriceCatagory
            FROM            erp_sad.dbo.qryDisPoint AS dis
            WHERE        (dis.ysnEnable = 1) AND dis.intUnitId = $intUnitId
            and strDisPointName like '%$strDisPointName%'")
        );
        return $ItemList;
    }





    /**
     * Get Sales Office List By Shop List
     *
     * @param integer $intSalesOffId
     * @return void
     */
    public function getSalesOfficevsShopList($intSalesOffId)
    {
        $ItemList = DB::select(
            DB::raw("SELECT dis.intCusID, dis.intCusType, dis.intDisPointId, dis.intSalesOffId, dis.intUnitId, dis.strDisPointName, dis.ysnEnable
            ,'' as strEmailAddress, dis.strCusName, dis.strAddress, dis.strContactNo, dis.strContactPerson,
            dis.intLogisticCatagory, dis.intPriceCatagory
            FROM            erp_sad.dbo.qryDisPoint AS dis
            WHERE        (dis.ysnEnable = 1) AND  dis.intSalesOffId=$intSalesOffId
            order by strDisPointName")
        );
        return $ItemList;
    }

    /**
     * Get Customers Sales Order
     *
     * @param integer $intUnitId
     * @param string $strEmailAddress

     * @return void
     */
    public function getShopListLocationUpdatestatus($intUnitId, $strEmailAddress)
    {
        // return $intUnitId;

        $territory = DB::table(config('constants.DB_SAD') . ".tblItemPriceManager")
            ->select('intID')
            ->where('tblItemPriceManager.intUnitID', $intUnitId)
            ->where('tblItemPriceManager.strEmailAddress', $strEmailAddress)
            ->first();



        $query = DB::table(config('constants.DB_SAD') . ".tblDisPoint as dis")
            ->leftJoin(config('constants.DB_SAD') . ".tblcustomer as c", 'c.intCusID', '=', 'dis.intCustomerId')
            ->leftJoin(config('constants.DB_SAD') . ".tblSalesOffice as sof", 'sof.intId', '=', 'c.intSalesOffId')
            ->leftJoin(config('constants.DB_SAD') . ".tblItemPriceManager as pm", 'pm.intID', '=', 'dis.intPriceCatagory')
            ->leftJoin(config('constants.DB_SAD') . ".tblItemPriceManager as pm1", 'pm1.intID', '=', 'pm.intParentID')
            ->leftJoin(config('constants.DB_SAD') . ".tblItemPriceManager as pm2", 'pm2.intID', '=', 'pm1.intParentID')
            ->leftJoin(config('constants.DB_Logistic') . ".tblVehiclePriceManager as vpm", 'vpm.intID', '=', 'dis.intLogisticCatagory')
            ->leftJoin(config('constants.DB_Logistic') . ".tblVehiclePriceManager as vpm1", 'vpm1.intID', '=', 'vpm.intParentID');

        $output = $query->select(
            [
                'intDisPointId', 'dis.strName as shopname', 'dis.strAddress', 'c.strName as customername', 'dis.strContactNo', 'dis.strContactPerson', 'pm.strText as Territory', 'pm1.strText as Area', 'pm2.strText as Region', 'vpm.strText as Thana', 'vpm1.strText as District', 'sof.strName as salesoffice', 'vpm.intID as Thanaid', 'pm.intid as Territoryid', 'pm1.intid as Areaid', 'pm2.intid as Regionid', 'ysnLocationTag', 'ysnImageTag', 'decLatitude', 'decLongitude', 'intZAxis', 'strGoogleMapName'
            ]
        )
            ->where('dis.intUnitId', $intUnitId)
            ->where('dis.ysnEnable', true)
            ->where('dis.intPriceCatagory', $territory->intID)
            ->where('dis.ysnLocationTag', false)

            ->get();
        return $output;
    }




    /**
     * Get Customers Sales Order
     *
     * @param integer $intUnitId
     * @param string $strEmailAddress

     * @return void
     */
    public function getShopListReportConfiguration($intUnitId)
    {
        // return $intUnitId;




        $query = DB::table(config('constants.DB_SAD') . ".tblDisPointReportConfiguration as dis");

        $output = $query->select(
            [
                'intID', 'strReportName', 'intUnitID'
            ]
        )
            ->where('dis.intUnitId', $intUnitId)


            ->get();
        return $output;
    }

    /**
     * Get Customer Pending Order List
     *
     * Get Unit List
     *
     * @param integer $intCustomerId

     * @return void
     */
    public function getCustomerPendingSalesOrderList($intCustomerId)
    {
        $ItemList = DB::select(
            DB::raw("SELECT c.strName as cutomername,sof.strName as salesofficename,shp.strName as shippingPoint,o.dteDOCopmplitionTime, o.intId AS intOrderID, o.intCustomerId, o.intSalesOffId, o.intShipPointId, so.intProductId
            ,so.numApprQuantity as OrderQNT
            , ISNULL(d.numDeliveryQty, 0) + ISNULL(dd.numDeliveryQty, 0) as ChallanQNT

            , so.numApprQuantity - ISNULL(d.numDeliveryQty, 0) - ISNULL(dd.numDeliveryQty, 0) AS numPendingQty,
            so.monOrderValue - ISNULL(d.monDeliveryValue, 0) - ISNULL(dd.monDeliveryValue, 0) AS monPendingValue, o.strCode, so.decDiscountRate, (so.monOrderValue - ISNULL(d.monDeliveryValue, 0) - ISNULL(dd.monDeliveryValue,
            0)) * ISNULL(so.decDiscountRate, 0) AS monDiscountOnPending
            FROM            ERP_SAD.dbo.tblSalesOrder AS o
            Join ERP_SAD.DBO.TBLCUSTOMER C on c.intCusID=o.intCustomerId
            join erp_Sad.dbo.tblSalesOffice sof on sof.intId=o.intSalesOffId
            join erp_Sad.dbo.tblShippingPoint shp on shp.intId=o.intShipPointId

            INNER JOIN
            (SELECT intSOId, intProductId, SUM(numApprQuantity) AS numApprQuantity, SUM(numApprQuantity * monPrice) AS monOrderValue, decDiscountRate
            FROM            ERP_SAD.dbo.tblSalesOrderDetails
            GROUP BY intSOId, intProductId, decDiscountRate) AS so ON o.intId = so.intSOId LEFT OUTER JOIN
            (SELECT        s.intSalesOrderId, se.intProductId, SUM(se.numQuantity) AS numDeliveryQty, SUM(se.numQuantity * se.monPrice) AS monDeliveryValue
            FROM            ERP_SAD.dbo.tblSalesEntry AS s INNER JOIN
            ERP_SAD.dbo.tblSalesEntryDetails AS se ON s.intId = se.intId
            WHERE        (s.intSalesOrderId IS NOT NULL)
            and s.intCustomerId=$intCustomerId

            AND (ISNULL(s.ysnPostedInSubLedger, 0) = (CASE WHEN s.intCustomerId = 0 THEN 0 ELSE 1 END))
            GROUP BY s.intSalesOrderId, se.intProductId) AS d ON so.intSOId = d.intSalesOrderId AND so.intProductId = d.intProductId LEFT OUTER JOIN
            (SELECT        s.intSalesOrderId, se.intProductId, SUM(se.numQuantity) AS numDeliveryQty, SUM(se.numQuantity * se.monPrice) AS monDeliveryValue
            FROM            ERP_SAD.dbo.tblDamageChallanEntry AS s INNER JOIN
            ERP_SAD.dbo.tblDamageChallanEntryDetails AS se ON s.intId = se.intId
            WHERE        (s.intSalesOrderId IS NOT NULL) and s.intCustomerId=$intCustomerId
            GROUP BY s.intSalesOrderId, se.intProductId) AS dd ON so.intSOId = dd.intSalesOrderId AND so.intProductId = dd.intProductId

            WHERE        (o.intInactiveBy IS NULL) AND (o.ysnEnable = 1) AND ((CASE WHEN o.intCustomerId = 0 THEN o.ysnCompleted ELSE o.ysnDOCompleted END) = 1) AND (o.ysnEnable = 1) AND (so.numApprQuantity <> ISNULL(d.numDeliveryQty,
            0) + ISNULL(dd.numDeliveryQty, 0))
            and o.intCustomerId=$intCustomerId")
        );
        return $ItemList;
    }

    /**
     * Get Geo Level
     *

     * @param string $strEmailAddress

     * @return void
     */
    public function getManpowerGeoLevel($strEmailAddress)
    {
        // return $intUnitId;

        // $lebelData =  DB::table(config('constants.DB_SAD') . ".tblitempricemanager")
        //     ->where('strEmailAddress', $request->strEmailAddress)
        //     ->first();

        // return  $lebelData;


        $query = DB::table(config('constants.DB_SAD') . ".tblitempricemanager as pm");

        $output = $query->select([
            'intLevel',
            'strEmailAddress'
        ])
            ->where('pm.strEmailAddress', $strEmailAddress)
            ->first();

        if (is_null($output)) {
            $data = [[
                'intLevel' => 0,
                'strEmailAddress' => $strEmailAddress,
            ]];
            $output = $data[0];
        }

        return $output;
    }


    /**
     * Get Information for apps user support
     *
     * @param integer $intEnrol
     * @return void
     */
    public function getSupportInformationForAPPSUser($intEnrol)
    {
        $ItemList = DB::select(
            DB::raw("select e.intEmployeeID,e.strEmployeeName as strEmployeeName,strUserName,strPasswd,ModulePermission,decLatitude ,decLongitude,dteUpdateAt,
            e.strDesignation,e.strJobStationName,e.strContactNo1 ,s.strEmployeeName as SupervisorName
            from erp_hr.dbo.QRYEMPLOYEEPROFILEALL e
            join erp_hr.dbo.QRYEMPLOYEEPROFILEALL s on s.intEmployeeID=e.intSuperviserId

            left join
            (
             select strUserName,strPasswd ,intEnrol
             from erp_apps.dbo.tblAppsUserIDNPasswd
             where intEnrol=$intEnrol

            )up on up.intEnrol=e.intEmployeeID

            left join

            (

            select top(1) intUserID,intAppsModuleID,'Module Permission Exists' as ModulePermission
            from erp_apps.dbo.tblAppsPermission
            where intUserID=$intEnrol
            and intAppsModuleID>21
            )appermis on appermis.intUserID=e.intEmployeeID

            left join

            (

            SELECT top(1)  intJobStationId,decLatitude ,decLongitude,dteUpdateAt

              FROM ERP_Remote.dbo.tblGeoLocationForJobstation
              )goj on appermis.intUserID=e.intEmployeeID



            where e.intEmployeeID in($intEnrol)")
        );
        return $ItemList;
    }


    /**
     * Get customer vs Product Price
     *

     * @param string $intCustomerId

     * @return void
     */
    public function getProductPriceByCustomer($intCustomerId, $intProductId)
    {



        // $ItemList = DB::select(
        //     DB::raw("SELECT * FROM erp_sad.dbo.funCustomerStatementOnCrLimitAPI ('$endDate',$intcustomerid,$user->intEnroll,$intunitid,null)")
        // );



        $query = DB::table(config('constants.DB_SAD') . ".tblItemPriceChangeCustomer");

        $output = $query->select([
            'intId', 'intCustomerId', 'strBatchCode', 'intProductId', 'monPrice'
        ])
            ->where('intCustomerId', $intCustomerId)
            ->where('intProductId', $intProductId)
            ->orderBy('intId', 'desc')
            ->first();

        if (is_null($output)) {
            $data = [[
                'intProductId' => 0,
                'monPrice' => 450,
            ]];
            $output = $data[0];
        }
        return $output;
        // return $output;
    }
    /**
     * Get customer vs Product Price
     *

     * @param string $intCustomerId

     * @return void
     */
    public function getProductPricewithOthersInfo($intCustomerId, $intProductId)
    {


        $intId = DB::table(config('constants.DB_SAD') . ".tblItemPriceChangeCustomer")->where('intCustomerId', $intCustomerId)
            ->where('intProductId', $intProductId)
            ->where('ysnActivated', 1)
            ->max('intId');
        // return $intId;


        $query = DB::table(config('constants.DB_SAD') . ".tblItemPriceChangeCustomer");

        $output = $query->select([
            'intId', 'intCustomerId', 'strBatchCode', 'intProductId', 'monPrice'
        ])
            ->where('intId',  $intId)->get();

        $priceInfo = [];
        foreach ($output as $single) {
            $data = [[
                'intProductId' => $single->intProductId,
                'Price' =>  $single->monPrice,
                'Commission' => 0,
                'SuppTax' => 0,
                'Vat'  => 0,
                'VatPrice' => 0,
                'ConvRate' => 0,
            ]];
            array_push($priceInfo, $data[0]);
        }

        return $priceInfo;
    }


    public function getProductPriceByCustomerFunction($intCustomerId, $intProductId, $intSalesType, $intPriceVar, $intUOM, $intCurrency, $dteDate)
    {

        $ItemList = DB::select(
            DB::raw("SELECT * FROM erp_sad.dbo.funItemGetPriceNProductID ($intCustomerId,$intProductId,$intSalesType,$intPriceVar,$intUOM,$intCurrency,'$dteDate')")
        );



        return $ItemList;
    }


    /**
     * Get customer vs Product Price
     *

     * @param string $intCustomerId

     * @return void
     */
    public function getCustomerStatement($fromDate, $toDate, $customerId, $userID, $unitID)
    {





        $query = DB::table(config('constants.DB_SAD') . ".tblCustomer");

        $output = $query->select([
            'intCOAid', 'strName'
        ])
            ->where('intCusID', $customerId)
            ->where('intUnitID', $unitID)
            ->first();

        // return  $output;

        return  $this->getAccountsSubledgerByAccount($fromDate, $toDate, $output->intCOAid, null, 1272, $unitID);
    }
    public function getAccountsSubledgerByAccount($fromDate, $toDate, $coaid, $coaCode, $userID, $unitID)
    {

        // return 1;
        $query = DB::table(config('constants.DB_HR') . ".tblunit AS u")
            ->leftJoin(config('constants.DB_HR') . ".tblUnitAddress AS ua", 'u.intUnitID', '=', 'ua.intUnitID');


        $output = $query->select(
            [
                'u.strUnit AS strUnit', 'ua.strAddress AS strAddress'
            ]
        )
            ->where('u.intUnitID', $unitID)

            ->where('ua.intAddressTypeID', 1)

            ->first();
        // return $output;




        $queryAcntPerid = DB::table(config('constants.DB_Accounts') . ".tblAccountsAccountingPeriod");

        $output = $queryAcntPerid->select([
            'dteStartDate'
        ])

            ->where('intUnitID', $unitID)
            ->where('dteEndDate', NULL)
            ->get();
        //   return $output;



        $ItemList = DB::select(
            DB::raw("SELECT  * FROM ERP_Accounts.dbo.funCOAisInSpecificRootAPI ( $coaid ,1 ,1 ,0 ,0 ,0 )")
        );
        // return  $ItemList;

        $querycoaid = DB::table(config('constants.DB_Accounts') . ".tblAccountsChartOfAcc");

        $outputcoacode =  $querycoaid->select([
            'strAccName', 'strCode'
        ])

            ->where('intAccID', $coaid)
            ->where('intUnitID', $unitID)
            ->first();

        // return    $outputcoacode;

        // get the oppening balance
        $queryopbalance = DB::table(config('constants.DB_Accounts') . ".tblAccountsSubLedger");
        $accountOppeningBalance =  $queryopbalance->select(
            DB::raw("SUM(CASE WHEN monAmount IS NOT NULL THEN monAmount ELSE 0 END) as numOpeningBalance")
        )
            ->where('intCOAAccountID', $coaid)
            ->whereDate('dteTransactionDate', '<', $fromDate)
            ->value('SUM(CASE WHEN monAmount IS NOT NULL THEN monAmount ELSE 0 END) as numOpeningBalance');

        // return    $accountOppeningBalance;

        //GetOpenningBalanceOfAccountWhileSoftwareStart

        $queryopbalancesoftwarestart = DB::table(config('constants.DB_Accounts') . ".tblAccountsSubLedger");
        $fopeningBalance =  $queryopbalancesoftwarestart->select(
            DB::raw("(CASE WHEN monOpeningBalance IS NOT NULL THEN monOpeningBalance ELSE 0 END) as monOpeningBalanceStart")
        )
            ->where('intCOAAccountID', $coaid)

            ->value('monOpeningBalance');

        //  return    $fopeningBalance;

        $accountOppeningBalance = $accountOppeningBalance + $fopeningBalance;
        // return    $accountOppeningBalance;

        return $this->getAccountsSubledgerByCOAID($fromDate, $toDate, $coaid, $accountOppeningBalance, 4);
    }

    public function getAccountsSubledgerByCOAID($fromDate, $toDate, $coaid, $accountOppeningBalance, $unitID)
    {

        //  return 1878;






        $query = DB::table(config('constants.DB_Accounts') . ".tblAccountsSubLedger");



        $output1 = $query->select(
            DB::raw("convert(varchar,$fromDate,103) AS dteDate,'' AS strCode,'Opening Balance' AS sprDescription,Abs((CASE  when $accountOppeningBalance>0 then $accountOppeningBalance else 0 END)) AS monDebit,Abs((CASE  when $accountOppeningBalance<0 then $accountOppeningBalance else 0 END)) AS monCredit,0 AS intEntryTypeID")

        )
            ->whereDate('dteTransactionDate', '>=', $fromDate)
            ->whereDate('dteTransactionDate', '<', $toDate)
            ->where('intCOAAccountID', $coaid);

        $query = DB::table(config('constants.DB_Accounts') . ".tblAccountsSubLedger");
        $output = $query->select(
            DB::raw("convert(varchar,dteTransactionDate,103) AS dteDate,
                strEntryCode AS strCode,
                strNarration AS sprDescription,
                Abs((CASE  when monAmount>0 then monAmount else 0 END)) AS monDebit,
                Abs((CASE  when monAmount<0 then monAmount else 0 END)) AS monCredit,
                intEntryTypeID")

        )
            ->whereDate('dteTransactionDate', '>=', $fromDate)
            ->whereDate('dteTransactionDate', '<', $toDate)
            ->where('intCOAAccountID', $coaid)
            ->union($output1)
            ->get();

        $collection = collect($output);

       return $collection;
        $sorted = $collection->sortBy([
          ['dteDate', 'asc'],
            ['intEntryTypeID', 'asc'],
        ]);

   $sorted->values()->all();

        return  $sorted;
    }
}
