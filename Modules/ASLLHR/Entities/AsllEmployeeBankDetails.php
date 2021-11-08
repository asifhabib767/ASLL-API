<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllEmployeeBankDetails extends Model
{
    protected $table = "tblasllemployeebankdetails";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
