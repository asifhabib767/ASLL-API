<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselItem extends Model
{
    protected $table = "tblVesselItem";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intVesselId',
        'strVesselItemName',
        'strVesselName',
        'decQtyAvailable',
        'decDefaultPurchasePrice',
        'decDefaultSalePrice',
        'intItemTypeID',
        'strItemTypeName',
        'intCreatedBy'
    ];
}
