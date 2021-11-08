<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CargoType extends Model
{
    protected $fillable = [
        'intUnitId',
        'strCargoTypeName',
        'ysnActive'
    ];

    protected $table = "tblCargoType";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    use SoftDeletes;
}
