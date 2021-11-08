<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class ShipConditionType extends Model
{
    protected $fillable = [
        'intID',
        'strShipConditionType'
    ];
    protected $table = "tblShipConditionType";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
