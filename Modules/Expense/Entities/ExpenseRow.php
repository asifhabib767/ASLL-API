<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseRow extends Model
{
    protected $fillable = [
        'intExpenseRowId',
        'intExpenseId',
        'strExpenseCode',
        'dteExpenseDate',
        'intExpenseCategoryId',
        'strExpenseCategoryName',
        'intExpenseTypeId',
        'strExpenseTypeName',
        'intExpenseReferenceId',
        'strExpenseReferenceName',
        'strReferenceNo',
        'intTransactionTypeId',
        'strTransactionTypeName',
        'strComments',
        'numQuantity',
        'numRate',
        'numAmount',
        'strExpenseLocation',
        'strAttachmentLink',
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
    protected $table = "tblExpenseRegisterRow";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intExpenseRowId';

    public function expense()
    {
        return $this->belongsTo(ExpenseHeader::class,);
    }
}
