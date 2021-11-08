<?php

namespace Modules\Logistic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    // protected $table = "tblDriver";
    // protected $connection = 'DB_Apps';
    // protected $primaryKey = 'intDriverId';

    protected $fillable = [
        'strPhoneNo',
        'strDriverName',
        'strDriverLicence',
        'strDriverImagePath',
        'strLicenceImagePath',
        'ysnAppRegistration',
        'ysnActive',
        'intSupplierID',
    ];
    use SoftDeletes;
}
