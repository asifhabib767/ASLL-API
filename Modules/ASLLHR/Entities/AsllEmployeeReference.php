<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllEmployeeReference extends Model
{
    protected $table = "tblasllemployeereference";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
