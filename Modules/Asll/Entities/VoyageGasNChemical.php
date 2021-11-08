<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageGasNChemical extends Model
{
    protected $fillable = [
        'intId',
        'intVoyageID',
        'intVoyageActivityID',
        'intGasNChemicalId',
        'intVoyageActivityGasNChemicalMainID',
        'strGasNChemicalName',
        'decBFWD',
        'decRecv',
        'decCons',
        'dectotal',
        'intCreatedBy',
        'intUpdatedBy',
        'intDeletedBy'
    ];
    protected $table = "tblVoyageGasNChemical";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intId';
}
