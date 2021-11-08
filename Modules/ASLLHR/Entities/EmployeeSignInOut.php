<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeSignInOut extends Model
{
    protected $table = "tblEmployeeSignInOut";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    protected $fillable = [
        'intEmployeeId',
        'intVesselId',
        'dteActionDate',
        'ysnSignIn',
        'strRemarks',
        'intLastVesselId',
    ];
}
