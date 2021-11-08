<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vessel extends Model
{

    protected $table = "tblVessel";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'strVesselName',
        'strIMONumber',
        'intVesselTypeID',
        'strVesselTypeName',
        'intYardCountryId',
        'strYardCountryName',
        'strVesselFlag',
        'numDeadWeight',
        'numNetWeight',
        'numGrossWeight',
        'strBuildYear',
        'strEngineName',
        'intTotalCrew',
        'ysnOwn',
        'intCreatedBy',
        'intUpdatedBy',
        'intDeletedBy',
        'ysnActive',

    ];
    use SoftDeletes;


    public function voyages()
    {
        return $this->hasMany(Voyage::class, 'intVesselID', 'intID');
    }
}
