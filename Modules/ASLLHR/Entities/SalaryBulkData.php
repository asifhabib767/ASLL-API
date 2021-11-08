<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class SalaryBulkData extends Model
{
    protected $table = "tblSalaryBulkData";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    
    protected $fillable = [
        'strOfficerName',
        'strAdditionDeductionTypeName',
        'intAdditionDeductionTypeId',
        'strRank',
        'strCDCNo',
        'decWagesMonth',
        'strRemarks',
        'decEarningOfMonth',
        'intPreviousBalance',
        'decAddIEarning',
        'decTotalEarning',
        'decAdvanceonBoard',
        'decFbbCallingCard',
        'decBondedItems',
        'decJoiningAdvance',
        'decVSatCallingCard',
        'dechatchCleaning',
        'decEngineCleaning',
        'decSpecialAllowance',
        'decHRAAllowance',
        'decTotalDeduction',
        'decPayableAmount',
        'created_at',
        'updated_at',
    ];

}
