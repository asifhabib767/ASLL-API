<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class ShipPosition extends Model
{
    protected $fillable = [
        'strShipPositionName',
        'intID'
    ];
    protected $table = "tblShipPosition";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
