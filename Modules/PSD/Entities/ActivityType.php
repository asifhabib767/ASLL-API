<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    protected $fillable = [
        'strActivityTypeName',
        'intActivityTypeId',
        'dteCreatedAt',
        'intCreatedat',
        'ysnActive',
    ];
    protected $table = "tblActivityType";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
