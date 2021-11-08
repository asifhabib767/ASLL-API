<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class ChartererList extends Model
{
    protected $fillable = [
        'intChartererId',
        'strChartererName',
        
        'strChartererAddress',
        'strEmail',
        'strContactNo',
        'strContactPerson',
        'isActive',
       
    ];
    protected $table = "tblASLLChartererList";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intChartererId';

    // public function details()
    // {
    //     return $this->hasMany(VoyageLighterDetails::class, 'intVoyageLighterId', 'intID');
    // }

    // public function details()
    // {
    //     return $this->hasMany(VesselDemandSheetDetaills::class, 'intVesselDemandSheetID', 'intID');
    // }
}
