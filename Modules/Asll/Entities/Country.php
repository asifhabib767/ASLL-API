<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'strName',
        'strIso',
        'strIso3',
        'numCode',
        'intPhoneCode',
        'ysnActive'
    ];
    protected $table = "tblCountry";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
