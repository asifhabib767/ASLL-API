<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllEmployeeApplication extends Model
{
    protected $table = "tblApplication";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intApplicationTypeId',
        'intEmployeeId',
        'intRankId',
        'intVesselId',
        'strReceiverName',
        'dteFromDate',
        'strPortName',
        'strApplicationBody',
        'strCommencementTenure',
        'dteDateOfCompletion',
        'dteExtensionRequested',
        'dteRejoiningDate',
        'strRemarks',
        'strApplicationSubject',
    ];
}
