<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class DeamandSheetAprvDetaills extends Model
{
    protected $fillable = [
        'intID',
        'intVesselDemandSheetAprvID',
        'intItemId',
        'strItemName',
        'intQuantity'
       
    ];
    protected $table = "tblVesselDemandSheetApproveDetaills";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
