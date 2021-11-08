<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class Lighter extends Model
{
    protected $fillable = [
        'intID',
        'intLighterId',
        'strLighterName',
        'ysnActive',
        'created_at',
        'updated_at',
        'strType',
        'intTypeId',
        'intMasterId',
        'strMasterName',
        'intDriverId',
        'strDriverName'
    ];
    protected $table = "tblLighter";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    public function employees()
    {
        return $this->hasMany(LighterEmployee::class, 'intLighterId', 'intID')->OrderBy('intLighterEmployeeId', 'asc');
    }
}
