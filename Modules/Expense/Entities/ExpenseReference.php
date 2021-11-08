<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseReference extends Model
{
    protected $fillable = [
        'intExpenseReferenceId',
        'intExpenseTypeId',
        'strExpenseReferenceName',
        'strExpenseReferenceCode',
        'intBusinessId',
        'ysnActive'
    ];
    protected $table = "tblExpenseReference";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intExpenseReferenceId';
}
