<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $fillable = [
        'intTransactionTypeId',
        'intExpenseTypeId',
        'strTransactionTypeName',
        'strTransactionTypeCode',
        'intBusinessId',
        'ysnActive'
    ];

    protected $table = "tblTransactionType";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intTransactionTypeId';
}
