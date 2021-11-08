<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployDuty extends Model
{
    protected $fillable = [
        'intDutyAutoID',
        'intTrackingID',
        'intEmployeeID',
        'intEmployeeTypeID',
        'strLocation',
        'decLatitude',
        'decLongitude',
        'ysnVisited',
        'intAssignedBy',
        'strRemarks',
        'intContactID',
        'strContacName',
        'ysnEnable'
    ];
    protected $table = "tblEmployeeDuty";
    protected $connection = 'ERP_HR';
    protected $primaryKey = 'intDutyAutoID';
}
