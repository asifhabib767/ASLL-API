<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class ConstructionType extends Model
{
    protected $fillable = [
        'strConstructionTypeName',
        'intConstructionTypeId',
        'intCreatedat',
        'ysnActive',
    ];
    protected $table = "tblPSDConstructionType";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
