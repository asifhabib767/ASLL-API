<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class SalesOffice extends Model
{
    protected $fillable = [
        'intId'
        ,'intUnitId'
        ,'intParentId'
        ,'strName'
        ,'strDescription'
        ,'ysnEnable'
        ,'intInsertedBy'
        ,'dteInsertionTime'
        ,'intLastModifiedBy'
        ,'dteLastModificationTime'
        ,'strPrefix'
        ,'strCodeFor'
        ,'ysnPendingDORemove'
        ,'ysnSMSEnable'
        ,'intCategoryid'
        ,'strReturnDOPrefix'
        ,'ysnDiscountApply'
        ,'strQuationPrefix'
        ,'strQuationCodeFor'
        ,'ysnBalanceChkInOrder'
        ,'ysnDOCompleteAuto'
    ];
    protected $table = "tblSalesOffice";
    protected $connection = 'ERP_SAD';
    protected $primaryKey = 'intId';
}
