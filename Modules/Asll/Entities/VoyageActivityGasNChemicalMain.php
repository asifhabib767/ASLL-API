<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageActivityGasNChemicalMain extends Model
{
    protected $table = "tblVoyageActivityGasNChemicalMain";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intID',
        'intUnitId',
        'intVoyageActivityID',
        'strRemarks',
        'dteCreatedAt',
        'intCreatedBy',
    ];
}
