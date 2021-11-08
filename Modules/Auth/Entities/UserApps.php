<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;

class UserApps extends Model
{

    protected $table = "tblAppsUserIDNPasswd";
    protected $connection = 'ERP_Apps';
    protected $primaryKey = 'intId';
    protected $fillable = [

    ];
}
