<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyConversion extends Model
{

    protected $table = "tblCurrencyConversion";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intConvertedFromId',
        'intConvertedToId',
        'decUSDAmount',
        'decBDTAmount',
        'created_at'

    ];
    use SoftDeletes;
}
