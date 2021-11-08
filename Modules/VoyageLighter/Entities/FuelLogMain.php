<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class FuelLogMain extends Model
{
    protected $fillable = [
        'intID',
        'intLighterId',
        'strDetails',
        'strLighterName',
        'dteDate',
        'intVoyageId',
        'intVoyageNo',
        'intCreatedBy',
        'intUpdatedBy',
        'intDeletedBy',
        'ysnActive'
    ];
    protected $table = "tblFuelLogMain";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    public function details()
    {
        return $this->hasMany(FuelLogDetails::class, 'intFuelLogId', 'intID');
    }
}
