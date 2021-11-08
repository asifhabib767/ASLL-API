<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class CodeCount extends Model
{
    protected $fillable = [
        'intID',
        'intLighterId',
        'year',
        'intCount',
        'strCodeFor',
        'ysnActive'
    ];
    protected $table = "tblCodeCount";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intLighterId';
}
