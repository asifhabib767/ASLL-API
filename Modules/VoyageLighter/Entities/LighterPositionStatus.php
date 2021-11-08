<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LighterPositionStatus extends Model
{
    protected $fillable = [
        'intID',
        'strWorkingCenter',
        'dteCompletionDate',
        'strCompletionTime',
        'ysnActive',
    ];
    protected $table = "tblLighterPositionStatus";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
