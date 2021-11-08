<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class VesselAccount extends Model
{
    protected $table = "tblVesselAccount";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    protected $fillable = [
        'intVesselId',
        'decBondAccountBalance',
        'decCashAccountBalance',
        'intCreatedBy',
        'intLastVesselId',
    ];
}
