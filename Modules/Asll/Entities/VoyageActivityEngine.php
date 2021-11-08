<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageActivityEngine extends Model
{
    protected $table = "tblVoyageActivityMainEngine";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intVoyageActivityID',
        'intShipEngineID',
        'strShipEngineName',
        
        'dceJacketTemp1',
        'dceJacketTemp2',
        'dcePistonTemp1',
        'dcePistonTemp2',
        'dceExhtTemp1',
        'dceExhtTemp2',
        'dceScavTemp1',
        'dceScavTemp2',
        'dceTurboCharger1Temp1',
        'dceTurboCharger1Temp2',
        'dceEngineLoad',
        'dceJacketCoolingTemp1',
        'dcePistonCoolingTemp1',
        'dceLubOilCoolingTemp1',
        'dceFuelCoolingTemp1',
        'dceScavCoolingTemp1',
        'strRemarks',
        'intCreatedBy',
    ];
}
