<?php

namespace Modules\Customer\Repositories;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerBalanceRepository
{

    public function getCustomerBalanceInformation($intUnitId, $intCustomerId)
    {
        // Get Customer Primary Information
        $customer = DB::table(config('constants.DB_SAD') . ".tblCustomer")
            ->where('intCusID', $intCustomerId)
            ->where('intUnitID', $intUnitId)
            ->first();

        if (!is_null($customer)) {
            $monCreditLimit = $customer->monCreditLimit;
            $ysnPeriodicleCrLim = $customer->ysnPeriodicleCrLim;
            $intCOAid = $customer->intCOAid;
            $intDaysOfCrLim = $customer->intDaysOfCrLim;

            // Get Openin Balance
            $opendingBalanceData = DB::table(config('constants.DB_Accounts') . ".tblAccountsChartOfAcc")->where('intAccID', $intCOAid)->first();
            $monOpeningBalance = $opendingBalanceData->monOpeningBalance;

            $totalDebit = DB::table(config('constants.DB_Accounts') . ".tblAccountsSubLedger")
                ->where('intCOAAccountID', $intCOAid)
                ->whereIn('intEntryTypeID', [1, 3, 7])
                ->select(
                    DB::raw('SUM(monAmount) as totalDebit')
                )
                ->groupBy('intCOAAccountID')
                ->value('totalDebit');

            $totalCredit = DB::table(config('constants.DB_Accounts') . ".tblAccountsSubLedger")
                ->where('intCOAAccountID', $intCOAid)
                ->whereIn('intEntryTypeID', [2, 4])
                ->select(
                    DB::raw('SUM(monAmount) as totalCredit')
                )
                ->groupBy('intCOAAccountID')
                ->value('totalCredit');

            $totalJR = DB::table(config('constants.DB_Accounts') . ".tblAccountsSubLedger")
                ->where('intCOAAccountID', $intCOAid)
                ->where('intEntryTypeID', 5)
                ->select(
                    DB::raw('SUM(monAmount) as totalAmount')
                )
                ->groupBy('intCOAAccountID')
                ->get();

            echo 'debit - ' . $totalDebit;
            echo 'credit - ' . $totalCredit;
            echo 'opening - ' . $monOpeningBalance;
            $outstanding = (float)  $monOpeningBalance - (float) $totalCredit - (float) $totalDebit;

            return $totalJR;


            //    DB::table(config('constants.DB_SAD') . ".tblCustomer")
            //        ->where('intCusID', $intCustomerId)
            //        ->where('intUnitID', $intUnitId)
            //        ->first();

        } else {
            return 'Not Found';
        }
    }
}
