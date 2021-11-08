<?php

namespace Modules\RequisitionIssue\Entities;

use Illuminate\Database\Eloquent\Model;

class FuelRequistion extends Model
{
    protected $fillable = [
        'intID',
        'intUnitID',
        'intSupplierID',
        'strSupplierName',
        'dteRequisitionDate',
        'intEnrol',
        'intUseFor',
        'strUseForName',
        'strReceivedBy',
        'ysnActive',
        'intLastActionBy',
        'dteLastActionTime',
        'intCostCenter',
        'strIssueRemarks'


    ];
    protected $table = "tblRequisitionMain";
    protected $connection = 'DB_iApps';
    protected $primaryKey = 'intID';

}
