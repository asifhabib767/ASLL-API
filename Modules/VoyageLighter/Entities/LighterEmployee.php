<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LighterEmployee extends Model
{
    protected $fillable = [
        'intID',
        'intLighterId',
        'intEnroll',
        'intLighterEmployeeId',
        'strLighterEmployeeName',
        'intEmployeeType',
        'ysnActive',
        'created_at',
        'updated_at',
    ];
    protected $table = "tblLighterEmployee";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
