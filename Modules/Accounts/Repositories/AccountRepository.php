<?php

namespace Modules\Accounts\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountRepository
{
    public function getOnlineBankListByUnitID($intUnitID)
    {
        $query = DB::table(config('constants.DB_Accounts') . ".tblOnlineBankInfoByUnit")
            ->join(config('constants.DB_Accounts') . ".tblBankInfo", 'tblOnlineBankInfoByUnit.intBankID', '=', 'tblBankInfo.intBankID');



        $output = $query->select(
            [
                'tblOnlineBankInfoByUnit.intBankID', 'tblBankInfo.strBankName', 'strBankCode', 'intSupplierMasterID', 'intUnitID'

            ]
        )
            ->where('tblOnlineBankInfoByUnit.ysnActive', true)
            ->where('tblOnlineBankInfoByUnit.intUnitID', $intUnitID)
            ->get();

        return $output;
    }


    public function getOnlineDepositMode()
    {
        $query = DB::table(config('constants.DB_Accounts') . ".tblDepositMode");




        $output = $query->select(
            [
                'intID', 'strDepositMode'

            ]
        )
            ->where('tblDepositMode.ysnActive', true)

            ->get();

        return $output;
    }

    public function postDepositNItemInformationByApps(Request $request)
    {
        // Add Single Entry in tblStoreIssue table 

        try {
            DB::beginTransaction();
            $intPKID = null;
            $decTotalQnt = 0;
            $monTotalAmount = 0;

            foreach ($request->products as $p) {
                $decTotalQnt += $p['decQnt'];
                $monTotalAmount += $p['decQnt'] * $p['monRate'];
            }


            $intPKID = DB::table(config('constants.DB_Accounts') . ".tblDepositInformationByApps")->insertGetId(
                [
                    'intCustID' => $request->intCustID,
                    'intCOAID' => $request->intCOAID,
                    'dteDepositDate' => $request->dteDepositDate,
                    'dteInsertionDate' => Carbon::now(),
                    'decTotalQnt' => $decTotalQnt,
                    'monTotalAmount' => $monTotalAmount,
                    'intUnitID' => $request->intUnitID,
                    'intInsertBy' => $request->intInsertBy,
                    'strNarration' => $request->strNarration,
                    'ysnEnable' => true,
                    'ysnCompleted' => true,
                ]
            );

            foreach ($request->products as $product) {
                if ($intPKID > 0) {
                    DB::table(config('constants.DB_Accounts') . ".tblDepositProductDetaills")->insertGetId(
                        [
                            'intPKID' => $intPKID,
                            'intProductID' => $product['intProductID'],
                            'strProductName' => $product['strProductName'],
                            'monRate' => $product['monRate'],
                            'decQnt' => $product['decQnt'],
                            'intUnitID' => $request->intUnitID,
                            'dteInsertionTime' =>   Carbon::now(),
                        ]
                    );
                }
            }

            foreach ($request->banks as $bank) {
                if ($intPKID > 0) {
                    DB::table(config('constants.DB_Accounts') . ".tblDepositBankDetaills")->insertGetId(
                        [
                            'intPKID' => $intPKID,
                            'intBankID' => $bank['intBankID'],
                            'strBankName' => $bank['strBankName'],
                            'intDepositModeTypeID' => $bank['intDepositModeTypeID'],
                            'strDepositModeTypeName' => $bank['strDepositModeTypeName'],
                            'strBranch' => $bank['strBranch'],
                            'strRTGSChequeNMtr' => $bank['strRTGSChequeNMtr'],
                            'intUnitID' => $request->intUnitID,
                            'dteInsertionTime' =>   Carbon::now(),
                        ]
                    );
                }
            }

            DB::commit();
            return $intPKID;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getDepositInformationByCustomer($intCustID)
    {
        // return $intCustID;

        $query = DB::table(config('constants.DB_Accounts') . ".tblDepositInformationByApps")
            ->join(config('constants.DB_Accounts') . ".tblDepositProductDetaills", 'tblDepositInformationByApps.intID', '=', 'tblDepositProductDetaills.intPKID')
            ->join(config('constants.DB_Accounts') . ".tblDepositBankDetaills", 'tblDepositBankDetaills.intPKID', '=', 'tblDepositInformationByApps.intID')
            ->join(config('constants.DB_SAD') . ".tblcustomer", 'tblcustomer.intcusid', '=', 'tblDepositInformationByApps.intCustID');



        $output = $query->select(
            [
                'intCustID', 'tblcustomer.strName', 'dteDepositDate', 'dteInsertionDate', 'decTotalQnt', 'monTotalAmount', 'tblDepositProductDetaills.strProductName', 'tblDepositProductDetaills.decQnt', 'tblDepositProductDetaills.monRate', 'tblDepositBankDetaills.strBankName', 'tblDepositBankDetaills.strBranch', 'tblDepositBankDetaills.strDepositModeTypeName', 'tblDepositBankDetaills.strRTGSChequeNMtr'

            ]
        )

            ->where('tblDepositInformationByApps.intCustID',  $intCustID)
            ->where('tblDepositInformationByApps.ysnEnable', true)
            ->orderBy('tblDepositInformationByApps.intID')
            ->get();

        return $output;
    }
}
