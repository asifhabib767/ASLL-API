<?php

namespace Modules\RequisitionIssue\Entities;

use Illuminate\Database\Eloquent\Model;

class RequisitionDet extends Model
{
    protected $fillable = [
        'intID',
        'intReqID',
        'intItemID',
        'strItemName',
        'numReqQty',
        'numIssueQty',
        'strIssueRemarks',
        


    ];
    protected $table = "tblRequisitionDetaills";
    protected $connection = 'DB_iApps';
    protected $primaryKey = 'intID';
}
