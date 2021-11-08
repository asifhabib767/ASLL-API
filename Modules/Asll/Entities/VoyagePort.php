<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoyagePort extends Model
{
    protected $fillable = [
        'intPortId',
        'strPortCode',
        'strPortName',
        'strCountryName',
        'strCountryCode',
        'strLOCODE',
        'isActive'
    ];

    protected $table = "tblPortList";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intPortId';
}
