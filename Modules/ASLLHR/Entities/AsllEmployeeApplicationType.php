<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllEmployeeApplicationType extends Model
{
    protected $table = "tblApplicationType";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'strTypeName',
        'ysnCRReport',
    ];
}
