<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LighterVoyageActivity extends Model
{
    protected $fillable = [
        'intID',
        'intLighterVoyageId',
        'intLighterPositionStatusId',
        'dteCompletionDate',
        'strCompletionTime',
        'intCreatedBy',
        'dteCreatedAt',
        'ysnStatus',
        'ysnActive',
        'strAdditionalStatus',
    ];
    protected $table = "tblLighterVoyageActivity";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    public function status()
    {
        return $this->belongsTo(LighterPositionStatus::class, 'intID', 'intLighterPositionStatusId');
    }
}
