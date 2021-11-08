<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeTracking extends Model
{
    protected $fillable = [
        'intAutoID',
        'intUnitId',
        'intEmployeeID',
        'intEmployeeTypeID',
        'dteDate',
        'dtePunchInTime',
        'dtePunchOutTime',
        'decLatitude',
        'decLongitude',
        'strLocation',
        'ysnEnable'

    ];
    protected $table = "tblEmployeeTracking";
    protected $connection = 'ERP_HR';
    protected $primaryKey = 'intAutoID';
}
