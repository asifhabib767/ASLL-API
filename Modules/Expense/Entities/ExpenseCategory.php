<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = [ 
    'intExpenseCategoryId',
    'strExpenseCategoryName',
    'strExpenseCategoryCode',
    'intBusinessId',
    'ysnActive'
    ];

    protected $table = "tblExpenseCategory";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intExpenseCategoryId';
}
