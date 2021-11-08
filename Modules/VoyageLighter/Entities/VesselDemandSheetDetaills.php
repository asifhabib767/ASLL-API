<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class VesselDemandSheetDetaills extends Model
{
    protected $fillable = [
        'intID',
        'intVesselDemandSheetID',
        'intItemId',
        'strItemName',
        'intQuantity',
        'strAttachment'
    ];
    protected $table = "tblVesselDemandSheetDetaills";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
