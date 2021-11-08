<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllHrEmployeeEducation extends Model
{
    protected $table = "tblasllemployeeeducation";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
