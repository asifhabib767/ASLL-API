<?php

namespace Modules\Expense\Repositories;

use App\Helpers\UploadHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Entities\ExpenseCategory;
use Modules\Expense\Entities\ExpenseHeader;
use Modules\Expense\Entities\ExpenseReference;
use Modules\Expense\Entities\ExpenseRow;
use Modules\Expense\Entities\ExpenseType;
use Modules\Expense\Entities\TransactionType;
use Modules\HR\Repositories\HRRepository;

class ExpenseRepository
{
    public function getExpenseType(Request $request)
    {
        try {
            $expenseType = ExpenseType::where('intExpenseCategoryId', $request->intExpenseCategoryId)
                ->get();
            return $expenseType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getExpense($intActionBy)
    {
        try {
            $expenseType = ExpenseHeader::where('intActionBy', $intActionBy)
                ->orderBy('intExpenseId', 'desc')
                ->get();
            return $expenseType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getSupervisorAprovePending($supervisorID)
    {
        try {
            $hrRepo = new HRRepository();
            // Find employee ID's of this supervisor
            $idLists = $hrRepo->getSupervisorVsEmployeeList($supervisorID);

            // make an array of ID
            $ids = [];
            foreach ($idLists as $id) {
                array_push($ids, (int) $id->intEmployeeid);
            }

            $expenses = ExpenseHeader::whereIn('intExpenseForId', $ids)
                ->orderBy('intExpenseId', 'desc')
                ->get();
            return $expenses;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getExpenseById($intExpenseId)
    {
        try {
            $expenses = ExpenseHeader::where('intExpenseId', $intExpenseId)
                ->with('details')
                ->first();
            return $expenses;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getExpenseCategoryType()
    {
        try {
            $expenseCategoryType = ExpenseCategory::get();
            return $expenseCategoryType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getReferenceType(Request $request)
    {
        try {
            $expenseReferenceType = ExpenseReference::where('intExpenseTypeId', $request->intExpenseTypeId)
                ->get();

            return $expenseReferenceType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getReference(Request $request)
    {
        try {
            $expenseReference = ExpenseReference::get();

            return $expenseReference;
        } catch (\Exception $e) {
            return false;
        }
    }



    public function getTransactionType(Request $request)
    {
        try {
            $expenseTransactionType = TransactionType::where('intExpenseTypeId', $request->intExpenseTypeId)
                ->get();

            return $expenseTransactionType;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getTransaction(Request $request)
    {
        try {
            $expenseTransaction = TransactionType::get();

            return $expenseTransaction;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function storeExpense(Request $request)
    {
        try {
            $i = 1;

            $total = 0;
            foreach ($request->expenseRowLists as $e) {
                $total += $e['numAmount'];
            }

            $strExpenseCode = 'EX-';

            $business = DB::table(config('constants.DB_HR') . ".tblUnit")
                ->where('intUnitID',  $request->intBusinessUnitId)
                ->first();

            if (!is_null($business)) {
                $expenseHeader = ExpenseHeader::create([
                    'strExpenseCode' => $strExpenseCode,
                    'intBusinessUnitId' => $request->intBusinessUnitId,
                    'strBusinessUnitName' => $business->strUnit,
                    'intExpenseCategoryId' => $request->intExpenseCategoryId,
                    'strExpenseCategoryName' => $request->strExpenseCategoryName,
                    'intSBUId' => $request->intSBUId,
                    'strSBUName' => $request->strSBUName,
                    'intCountryId' => $request->intCountryId,
                    'strCountryName' => $request->strCountryName,
                    'intCurrencyId' => $request->intCurrencyId,
                    'strCurrencyName' => $request->strCurrencyName,
                    'intExpenseForId' => $request->intExpenseForId,
                    'dteFromDate' => $request->dteFromDate,
                    'dteToDate' => $request->dteToDate,
                    'intProjectId' => $request->intProjectId,
                    'strProjectName' => $request->strProjectName,
                    'intCostCenterId' => $request->intCostCenterId,
                    'strCostCenterName' => $request->strCostCenterName,
                    'intInstrumentId' => $request->intInstrumentId,
                    'strInstrumentName' => $request->strInstrumentName,
                    'intDisbursementCenterId' => $request->intDisbursementCenterId,
                    'strDisbursementCenterName' => $request->strDisbursementCenterName,
                    'strReferenceNo' => $request->strReferenceNo,
                    'numTotalAmount' => $total,
                    'numTotalApprovedAmount' => $request->numTotalApprovedAmount,
                    'numAdjustmentAmount' => $request->numAdjustmentAmount,
                    'numPendingAmount' => $request->numPendingAmount,
                    'strComments' => $request->strComments,
                    'ysnComplete' => 0,
                    'ysnActive' => 1,
                    'intActionBy' => $request->intActionBy,
                    'dteLastActionDateTime' => Carbon::now(),
                    'dteServerDateTime' => Carbon::now()
                ]);

                $expenseHeader->strExpenseCode = $strExpenseCode . $expenseHeader->intExpenseId;
                $expenseHeader->save();

                foreach ($request->expenseRowLists as $expenseRowList) {

                    // Upload Attachment if file given
                    $image = null;
                    if (!is_null($expenseRowList['strAttachmentLink'])) {
                        $image = UploadHelper::upload('strAttachmentLink', $expenseRowList['strAttachmentLink'],  'expense-' . time(), 'images/expense');
                    }
                    // Document
                    $strAttachmentLink = url('images/expense/' . $image);

                    ExpenseRow::create([
                        // 'intExpenseRowId'=>$expenseRowList->intExpenseRowId,
                        'intExpenseId' => $expenseHeader->intExpenseId,
                        'strExpenseCode' => $expenseHeader->strExpenseCode,
                        'dteExpenseDate' => $expenseRowList['dteExpenseDate'],
                        'intExpenseCategoryId' => $expenseRowList['intExpenseCategoryId'],
                        'strExpenseCategoryName' => $expenseRowList['strExpenseCategoryName'],
                        'intExpenseTypeId' => $expenseRowList['intExpenseTypeId'],
                        'strExpenseTypeName' => $expenseRowList['strExpenseTypeName'],
                        'intExpenseReferenceId' => $expenseRowList['intExpenseReferenceId'],
                        'strExpenseReferenceName' => $expenseRowList['strExpenseReferenceName'],
                        'intReferenceId' => $expenseRowList['intReferenceId'],
                        'strReferenceNo' => $expenseRowList['strReferenceNo'],
                        'intTransactionTypeId' => $expenseRowList['intTransactionTypeId'],
                        'strTransactionTypeName' => $expenseRowList['strTransactionTypeName'],
                        'strComments' => $expenseRowList['strComments'],
                        'numQuantity' => $expenseRowList['numQuantity'],
                        'numRate' => $expenseRowList['numRate'],
                        'numAmount' => $expenseRowList['numAmount'],
                        'strExpenseLocation' => $expenseRowList['strExpenseLocation'],
                        'strAttachmentLink' => $strAttachmentLink,
                        'ysnComplete' => 0,
                        'ysnActive' => 1,
                        'intActionBy' => $expenseRowList['intActionBy'],
                        'dteLastActionDateTime' => Carbon::now(),
                        'dteServerDateTime' => Carbon::now()
                    ]);
                    $i++;
                }
                $expenseHeader = ExpenseHeader::where('intExpenseId', $expenseHeader->intExpenseId)
                    ->with('details')
                    ->first();
            return $expenseHeader;
        }   else {
            return 'Business Not Found !!';
            }
    }   catch (\Exception $e) {
        return $e->getMessage();
        }
        return true;
    }


    /**
     * update Expense by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated Expense object
     */
    public function updateExpense(Request $request, $id)
    {
        try {
            $i = 1;

            $total = 0;
            foreach ($request->expenseRowLists as $e) {
                $total += $e['numQuantity'];
            }


            $business = DB::table(config('constants.DB_HR') . ".tblUnit")
                ->where('intUnitID',  $request->intBusinessUnitId)
                ->first();

            if (!is_null($business)) {

                $expenseHeader = ExpenseHeader::where('intExpenseId', $request->intExpenseId)
                    ->update([
                        // 'intExpenseId'=> $request->intExpenseId,
                        'intBusinessUnitId' => $request->intBusinessUnitId,
                        'strBusinessUnitName' => $request->strBusinessUnitName,
                        'intExpenseCategoryId' => $request->intExpenseCategoryId,
                        'strExpenseCategoryName' => $request->strExpenseCategoryName,
                        'intSBUId' => $request->intSBUId,
                        'strSBUName' => $request->strSBUName,
                        'intCountryId' => $request->intCountryId,
                        'strCountryName' => $request->strCountryName,
                        'intCurrencyId' => $request->intCurrencyId,
                        'strCurrencyName' => $request->strCurrencyName,
                        'intExpenseForId' => $request->intExpenseForId,
                        'dteFromDate' => $request->dteFromDate,
                        'dteToDate' => $request->dteToDate,
                        'intProjectId' => $request->intProjectId,
                        'strProjectName' => $request->strProjectName,
                        'intCostCenterId' => $request->intCostCenterId,
                        'strCostCenterName' => $request->strCostCenterName,
                        'intInstrumentId' => $request->intInstrumentId,
                        'strInstrumentName' => $request->strInstrumentName,
                        'intDisbursementCenterId' => $request->intDisbursementCenterId,
                        'strDisbursementCenterName' => $request->strDisbursementCenterName,
                        'strReferenceNo' => $request->strReferenceNo,
                        'numTotalAmount' => $total,
                        'numTotalApprovedAmount' => $request->numTotalApprovedAmount,
                        'numAdjustmentAmount' => $request->numAdjustmentAmount,
                        'numPendingAmount' => $request->numPendingAmount,
                        'strComments' => $request->strComments,
                        'ysnComplete' => $request->ysnComplete,
                        'ysnActive' => $request->ysnActive,
                        'intActionBy' => $request->intActionBy,
                        'ysnApproveBySupervisor' => $request->ysnApproveBySupervisor,
                        'ysnApproveByHR' => $request->ysnApproveByHR,
                        'ysnApproveByAudit' => $request->ysnApproveByAudit,
                        'intApproveBySupervisor' => $request->intApproveBySupervisor,
                        'intApproveByHR' => $request->intApproveByHR,
                        'intApproveByAudit' => $request->intApproveByAudit,
                        'dteLastActionDateTime' => Carbon::now(),
                        'dteServerDateTime' => Carbon::now()
                    ]);
            }



            foreach ($request->expenseRowLists as $expenseRowList) {



                // Upload Attachment if file given
                // $image = null;
                // if (!is_null($request->strAttachmentLink)) {
                //     $image = UploadHelper::upload('strAttachmentLink', $request->file('strAttachmentLink'),  'expense-' . time(), 'images/expense');
                // }
                // if (!is_null($expenseRowList['strAttachmentLink'])) {
                //     $image = UploadHelper::upload('strAttachmentLink', $expenseRowList['strAttachmentLink'],  'expense-' . time(), 'images/expense');
                // }
                // // Document
                // $strAttachmentLink = url('images/expense/' . $image);

                $expenseRow = ExpenseRow::where('intExpenseRowId', $request->intExpenseRowId)
                    ->update([
                        // 'intExpenseRowId'=>$expenseRowList['intExpenseRowId'],
                        'intExpenseId' => $expenseRowList['intExpenseId'],
                        'dteExpenseDate' => $expenseRowList['dteExpenseDate'],
                        'intExpenseCategoryId' => $expenseRowList['intExpenseCategoryId'],
                        'strExpenseCategoryName' => $expenseRowList['strExpenseCategoryName'],
                        'intExpenseTypeId' => $expenseRowList['intExpenseTypeId'],
                        'strExpenseTypeName' => $expenseRowList['strExpenseTypeName'],
                        'intExpenseReferenceId' => $expenseRowList['intExpenseReferenceId'],
                        'strExpenseReferenceName' => $expenseRowList['strExpenseReferenceName'],
                        'strReferenceNo' => $expenseRowList['strReferenceNo'],
                        'intTransactionTypeId' => $expenseRowList['intTransactionTypeId'],
                        'strTransactionTypeName' => $expenseRowList['strTransactionTypeName'],
                        'strComments' => $expenseRowList['strComments'],
                        'numQuantity' => $expenseRowList['numQuantity'],
                        'numRate' => $expenseRowList['numRate'],
                        'numAmount' => $expenseRowList['numAmount'],
                        'strExpenseLocation' => $expenseRowList['strExpenseLocation'],
                        'strAttachmentLink' => $expenseRowList['strAttachmentLink'],
                        'ysnComplete' => $expenseRowList['ysnComplete'],
                        'ysnActive' => $expenseRowList['ysnActive'],
                        'intActionBy' => $expenseRowList['intActionBy'],
                        'ysnApproveBySupervisor' => $request->ysnApproveBySupervisor,
                        'ysnApproveByHR' => $request->ysnApproveByHR,
                        'ysnApproveByAudit' => $request->ysnApproveByAudit,
                        'intApproveBySupervisor' => $request->intApproveBySupervisor,
                        'intApproveByHR' => $request->intApproveByHR,
                        'intApproveByAudit' => $request->intApproveByAudit,
                        'dteLastActionDateTime' => Carbon::now(),
                        'dteServerDateTime' => Carbon::now()
                    ]);


                $i++;
            }
            // return $this->show($id);
            $expenseHeader = ExpenseHeader::where('intExpenseId', $request->intExpenseId)
                ->with('details')
                ->first();
            return $expenseHeader;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show Expense boiler by id
     *
     * @param integer $id
     * @return object Expense object
     */
    public function show($id)
    {
        // $id = (int) $id;
        // return $id;

        try {
            $expenseHeader = ExpenseHeader::find($id);
            return $expenseHeader;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Expense Not Found !');
        }
    }

    /**
     * delete Expense by id
     *
     * @param integer $id
     * @return object Deleted Expense Object
     */
    public function deleteExpense($id)
    {
        try {
            $expenseDelete = $this->show($id);
            $expenseDelete->delete();
            return $expenseDelete;
        } catch (\Exception $e) {
            return false;
        }
    }
}
