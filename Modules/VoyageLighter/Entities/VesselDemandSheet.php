<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class VesselDemandSheet extends Model
{
    protected $fillable = [
        'intID',
        'dteLayCanFromDate',
        'dteLayCanToDate',
        'intCountryID',
        'strCountry',
        'decGrandQuantity',
        'dteETADateFromLoadPort',
        'dteETADateToLoadPort',
        'strComments',
        'ysnActive',
        'intCreatedBy',
        'intUpdatedBy',
        'intDeletedBy',
        'intPortFrom',
        'strPortFrom',
        'intPortTo',
        'strPortTo',
        'strImagePath',
        'strLCNumber',
        'strBLNumber',
        'strCPControl',
        'strVoyageNumber',
        'ysnApprove',
        'intCharterer',
        'strCharterer',
        'intShipper',
        'strShipper',



    ];
    protected $table = "tblVesselDemandSheet";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    // public function details()
    // {
    //     return $this->hasMany(VoyageLighterDetails::class, 'intVoyageLighterId', 'intID');
    // }

    public function details()
    {
        return $this->hasMany(VesselDemandSheetDetaills::class, 'intVesselDemandSheetID', 'intID');
    }
}
