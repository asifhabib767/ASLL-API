<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class GasNChemical extends Model
{
    protected $fillable = [
        'intVoyageActivityID',
        'intId',
        'strName',
        'intCreatedBy',
        'ysnActive'
    ];
    protected $table = "tblGasNChemicalItem";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intId';
}
