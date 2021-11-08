<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VesselType extends Model
{
    protected $fillable = [
        'strName',
        'ysnActive'
    ];
    protected $table = "tblVesselType";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
