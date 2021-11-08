<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = "tblCurrency";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intCurrencyID';
    protected $fillable = [
        'strCurrencyName',
        'strCurrencySign',
        'ysnActive'
    ];
}
