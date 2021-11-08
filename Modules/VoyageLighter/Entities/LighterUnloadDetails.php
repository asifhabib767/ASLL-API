<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LighterUnloadDetails extends Model
{
    protected $fillable = [
        'intID',
        'intUnloadNStandByQntPKId',
        'intItemID',
        'strItemName',
        'decQnt',
        'intTypeId'
    ];
    protected $table = "tblLighterUnloadNStandByQntDetails";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
