<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VesselServer extends Model
{
    protected $table = "tblVesselServer";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'id';
}
