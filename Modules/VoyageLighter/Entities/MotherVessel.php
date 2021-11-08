<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class MotherVessel extends Model
{
    protected $fillable = [
        'intVesselID',

        'strVesselName',
        'dteInsertDate',
        'isActive'
    ];
    protected $table = "tblMotherVesselForLighter";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intVesselID';
}

