<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LighterUnload extends Model
{
    protected $fillable = [
        'intID',
        'dteDate',
        'dteInsertDate',
        'intCategoryId',
        'strCategoryName',
        'intTypeID',
        'strTypeName',
        'GrandTotal',
        'intInsertBy',
        'ysnActive'
    ];
    protected $table = "tblLighterUnloadNStandByQntMain";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
