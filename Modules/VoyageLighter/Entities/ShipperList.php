<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class ShipperList extends Model
{
    protected $fillable = [
        'intID',
        'strShipperName',
        
        'ysnActive',
        'intCreatedBy',
        'intUpdatedBy',
     


    ];
    protected $table = "tblShipperList";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    // public function details()
    // {
    //     return $this->hasMany(VoyageLighterDetails::class, 'intVoyageLighterId', 'intID');
    // }

    // public function details()
    // {
    //     return $this->hasMany(VesselDemandSheetDetaills::class, 'intVesselDemandSheetID', 'intID');
    // }
}
