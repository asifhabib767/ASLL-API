<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageActivityBoiler extends Model
{
    protected $table = "tblVoyageActivityBoiler";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intID',
        'intVoyageActivityID',
        'intVoyageActivityBoilerMainID',
        'decWorkingPressure',
        'dteCreatedAt',
        'decPhValue',
        'decChloride',
        'decAlkalinity',
        'intCreatedBy',
    ];
}
