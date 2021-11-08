<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LighterLoadingPoint extends Model
{
    protected $fillable = [
        'intID',
        'strLoadingPointName',
        'dteCompletionDate',
        'intVesselTypeOrPointTypeID',
        'ysnActive',
        
    ];
    protected $table = "tblLighterLoadingPoint";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
