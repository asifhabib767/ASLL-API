<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = [
           'intExpenseTypeId',
           'intExpenseCategoryId',
           'strExpenseTypeName',
           'strExpenseTypeCode',
           'intBusinessId',
           'ysnActive'
    ];
    protected $table = "tblExpenseType";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intExpenseTypeId';
}
