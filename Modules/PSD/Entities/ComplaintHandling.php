<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class ComplaintHandling extends Model
{
    protected $fillable = [
        'intID',
        'intUnitId',
        'strActivityDate',
        'intComplaineeId',
        'strComplaineeName',
        'intCreatedat',
        'ysnActive',
        'strAddress',
        'strMobileNumber',
        'intProblemTypeId',
        'strProblemTypeName',
        'strProblemTypeDetails',
        'strActionTaken',
        'ysnSolved',
        'ysnForwardedTo',
        'dteCreatedAt',
        'created_at',
        'updated_at'
    ];
    protected $table = "tblComplain";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
