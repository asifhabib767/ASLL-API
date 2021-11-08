<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingPoint extends Model
{
    protected $fillable = [
        'intId'
        ,'intUnitId'
        ,'strName'
        ,'strDescription'
        ,'ysnEnable'
        ,'intInsertedBy'
        ,'dteInsertionTime'
        ,'intLastModifiedBy'
        ,'dteLastModificationTime'
        ,'strPrefix'
        ,'strCodeFor'
        ,'strAddress'
        ,'ysnWareHouseOnly'
        ,'intLogisticCatagory'
        ,'strContactPerson'
        ,'strContactNo'
        ,'intWHID'
        ,'ysnStartingPoint'
    ];
    protected $table = "tblShippingPoint";
    protected $connection = 'ERP_SAD';
    protected $primaryKey = 'intId';
}
