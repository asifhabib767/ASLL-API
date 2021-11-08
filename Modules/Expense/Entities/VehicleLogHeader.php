<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class VehicleLogHeader extends Model
{

    protected $fillable = [
        'strTravelCode',
        'dteTravelDate',
        'intAccountId',
        'intBusinessUnitId',
        'strBusinessUnitName',
        'ysnActive',
        'ysnComplete',
        'intActionBy',
        'dteLastActionDateTime',
        'dteServerDateTime',
        'created_at',
        'updated_at'
    ];

    protected $table = "tblVehicleLogHeader";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intVehicleLogHeaderId';
    protected $appends = ["totalMilage"];

    public function logs()
    {
        return $this->hasMany(VehicleLog::class, 'intVehicleLogHeaderId', 'intVehicleLogHeaderId');
    }

    public function getTotalMilageAttribute() {
        return $this->logs->sum('numVehicleConsumedMileage');
    }
}
