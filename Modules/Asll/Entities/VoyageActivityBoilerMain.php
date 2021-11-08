<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageActivityBoilerMain extends Model
{
    protected $table = "tblVoyageActivityBoilerMain";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intUnitId',
        'intVoyageActivityID',
        'strRemarks',
        'dteCreatedAt',
        'intCreatedBy',
    ];
}
