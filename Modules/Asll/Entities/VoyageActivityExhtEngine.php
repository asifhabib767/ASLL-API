<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageActivityExhtEngine extends Model
{
    protected $table = "tblVoyageActivityExhtEngine";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intVoyageActivityID',
        'intShipEngineID',
        'strShipEngineName',
        
        'dceMainEngineFuelRPM',
        'dceRH',
        'dceLoad',
        'dceExhtTemp1',
        'dceExhtTemp2',
        'dceJacketTemp',
        'dceScavTemp',
        'dceLubOilTemp',
        'dceTCRPM',
        'dceJacketPressure',
        'dceScavPressure',
        'dceLubOilPressure',
        'strRemarks',
        'intCreatedBy',
    ];
}
