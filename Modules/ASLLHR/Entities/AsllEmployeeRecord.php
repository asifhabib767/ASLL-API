<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllEmployeeRecord extends Model
{
    protected $table = "tblasllemployeerecord";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
