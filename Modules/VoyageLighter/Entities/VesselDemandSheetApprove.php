<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class VesselDemandSheetApprove extends Model
{
    protected $fillable = [
        'intID',
        'intVesselDemandSheetID',
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
        'strVoyageNumber'
        

    ];
    protected $table = "tblVesselDemandSheetApprove";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    public function details()
    {
        return $this->hasMany(DeamandSheetAprvDetaills::class, 'intVesselDemandSheetAprvID', 'intID');
    }
}
