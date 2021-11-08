<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class FuelLogDetails extends Model
{
    protected $fillable = [
        'intID',
        'intLighterId',
        'intFuelLogId',
        'intFuelTypeId',
        'strFuelTypeName',
        'decFuelPrice',
        'decFuelQty',
        'ysnActive'
    ];
    protected $table = "tblFuelLogDetails";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
