<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $table = "tblTransactionType";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    protected $fillable = [];
}
