<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseHeader extends Model
{
    protected $fillable = [
        'intExpenseId',
        'strExpenseCode',
        'intBusinessUnitId',
        'intBusinessUnitName',
        'intExpenseCategoryId',
        'strExpenseCategoryName',
        'intSBUId',
        'strSBUName',
        'intCountryId',
        'strCountryName',
        'intCurrencyId',
        'strCurrencyName',
        'intExpenseForId',
        'dteFromDate',
        'dteToDate',
        'intProjectId',
        'strProjectName',
        'intCostCenterId',
        'strCostCenterName',
        'intInstrumentId',
        'strInstrumentName',
        'intDisbursementCenterId',
        'strDisbursementCenterName',
        'strReferenceNo',
        'numTotalAmount',
        'numTotalApprovedAmount',
        'numAdjustmentAmount',
        'numPendingAmount',
        'strComments',
        'ysnComplete',
        'ysnActive',
        'intActionBy',
        'dteLastActionDateTime',
        'dteServerDateTime',
        'ysnApproveBySupervisor',
        'ysnApproveByHR',
        'ysnApproveByAudit',
        'intApproveBySupervisor',
        'intApproveByHR',
        'intApproveByAudit',


    ];

    protected $table = "tblExpenseRegisterHeader";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intExpenseId';

    public function details()
    {
        return $this->hasMany(ExpenseRow::class, 'intExpenseId', 'intExpenseId');
    }
}
