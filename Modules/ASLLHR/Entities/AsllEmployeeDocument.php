<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllEmployeeDocument extends Model
{
    protected $table = "tblasllemployeedocument";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
