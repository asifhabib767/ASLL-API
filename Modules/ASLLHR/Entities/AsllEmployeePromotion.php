<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsllEmployeePromotion extends Model
{
    protected $table = "tblEmployePromotion";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intEmployeeID',
        'monPreviousSalary',
        'monPromotedSalary',
        'intVesselId',
        'intPreviousDesignationID',
        'intPromotedDesignationID',
        'dteEffectiveFromDate',
        'intCurrencyId',
        'strCurrency',
        'intInsertBy',
        'dteInsertDate',
    ];

}
