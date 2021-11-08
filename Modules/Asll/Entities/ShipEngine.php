<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class ShipEngine extends Model
{
    protected $table = "tblShipEngine";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'strEngineName',
        'priority',
        'strEngineCode',
        'intID',
    ];
}
