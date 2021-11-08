<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageLighterMain extends Model
{
    protected $fillable = [
        'dteDate',
        'intLoadingPointId',
        'strLoadingPointName',
        'intLighterId',
        'strLighterName',
        'strCode',
        'intLighterVoyageNo',
        'intMasterId',
        'strMasterName',
        'intDriverId',
        'strDriverName',
        'strUnloadStartDate',
        'strUnloadComplateDate',
        'strComments',
        'ysnActive',
        'intCreatedBy',
        'intUpdatedBy',
        'intDeletedBy'
    ];
    protected $table = "tblVoyageLighterMain";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    public function details()
    {
        return $this->hasMany(VoyageLighterDetails::class, 'intVoyageLighterId', 'intID');
    }
    public function oilStatements()
    {
        return $this->hasMany(FuelLogMain::class, 'intVoyageId', 'intID')->with('details');
    }

    public function activities()
    {
        return $this->hasMany(LighterVoyageActivity::class, 'intLighterVoyageId', 'intID');
    }
}
