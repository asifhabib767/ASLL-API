<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoyageActivity extends Model
{
    protected $fillable = [
        'intID',
        'intUnitId',
        'intVoyageID',
        'intShipPositionID',
        'intShipConditionTypeID',
        'dteCreatedAt',
        'decLatitude',
        'decLongitude',
        'intCourse',
        'timeSeaStreaming',
        'timeSeaStoppage',
        'decSeaDistance',
        'decSeaDailyAvgSpeed',
        'decSeaGenAvgSpeed',
        'strSeaDirection',
        'strSeaState',
        'strWindDirection',
        'decWindBF',
        'intETAPortToID',
        'strETAPortToName',
        'strETADateTime',
        'intVoyagePortID',
        'decTimePortWorking',
        'strPortDirection',
        'strPortDSS',
        'intETDPortToID',
        'strETDPortToName',
        'strETDDateTime',
        'decCargoTobeLD',
        'decCargoPrevLD',
        'decCargoDailyLD',
        'decCargoTTLLD',
        'decCargoBalanceCGO',
        'strRPM',
        'decEngineSpeed',
        'decSlip',
        'strRemarks',
        'intCreatedBy',
        'intApprovedBy',
        'intUpdatedBy',
        'intDeletedBy',
        'decProduction',
        'decConsumption',
        'decSeaTemp',
        'decAirTemp',
        'decBaroPressure',
        'decTotalDistance',
        'decDistanceToGo',
        'ysnActive',
        'synced',
    ];

    protected $table = "tblVoyageActivity";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    use SoftDeletes;

    public function shipPosition()
    {
        return $this->belongsTo(ShipPosition::class, 'intShipPositionID');
    }

    public function shipCondition()
    {
        return $this->belongsTo(ShipConditionType::class, 'intShipConditionTypeID');
    }

    public function etdPortTo()
    {
        return $this->belongsTo(VoyagePort::class, 'intETDPortToID');
    }

    public function etaPortTo()
    {
        return $this->belongsTo(VoyagePort::class, 'intETAPortToID');
    }

    public function voyage()
    {
        return $this->belongsTo(Voyage::class, 'intVoyageID', 'intID');
    }

    public function bunker()
    {
        return $this->hasOne(VoyageActivityVlsf::class, 'intVoyageActivityID', 'intID');
    }

    public function aux1()
    {
        return $this->hasOne(VoyageActivityExhtEngine::class, 'intVoyageActivityID', 'intID')
            ->where('intShipEngineID', 2);
    }

    public function aux2()
    {
        return $this->hasOne(VoyageActivityExhtEngine::class, 'intVoyageActivityID', 'intID')
            ->where('intShipEngineID', 3);
    }

    public function aux3()
    {
        return $this->hasOne(VoyageActivityExhtEngine::class, 'intVoyageActivityID', 'intID')
            ->where('intShipEngineID', 4);
    }

    public function boiler()
    {
        return $this->hasMany(VoyageActivityBoiler::class, 'intVoyageActivityID', 'intID');
    }

    // exht 1
    // exht 2
    // exht 3
    // boiler
}
