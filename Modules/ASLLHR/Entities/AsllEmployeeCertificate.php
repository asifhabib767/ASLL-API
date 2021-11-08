<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllEmployeeCertificate extends Model
{
    protected $table = "tblasllemployeecertificate";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
