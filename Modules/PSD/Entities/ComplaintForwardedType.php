<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class ComplaintForwardedType extends Model
{
    protected $fillable = [
        'intForwardedTypeId',
        'strForwardedTypeName',
        'intCreatedat',
        'ysnActive',
    ];
    protected $table = "tblComplainForwardType";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
