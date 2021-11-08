<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class VehicleLog extends Model
{
    protected $fillable = [
        'intVehicleLogHeaderId',
        'strTravelCode',
        'dteTravelDate',
        'intBusinessUnitId',
        'strBusinessUnitName',
        'dteStartTime',
        'dteEndTime',
        'strFromAddress',
        'strToAddress',
        'intVehicleId',
        'strVehicleNumber',
        'numVehicleStartMileage',
        'numVehicleEndMileage',
        'numVehicleConsumedMileage',
        'intDriverId',
        'strDriverName',
        'intSBUId',
        'strSBUName',
        'numRate',
        'numAmount',
        'strExpenseLocation',
        'strVisitedPlaces',
        'strAttachmentLink',
        'isFuelPurchased',
        'isPersonalUsage',
        'intActionBy',
        'ysnActive',
        'ysnComplete',
        'dteLastActionDateTime',
        'dteServerDateTime',
        'created_at',
        'updated_at'
    ];

    protected $table = "tblVehicleLog";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intVehicleLogId';
}
