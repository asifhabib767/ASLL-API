<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;

class UserERP extends Model
{

    protected $fillable = [
        'strEmployeeCode',
        'strOfficeEmail',
        'strEmployeeName',
        'intUnitID',
    ];
    protected $table = "tblEmployee";
    protected $connection = 'ERP_HR';
    protected $primaryKey = 'intEmployeeID';
}
