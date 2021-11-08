<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LighterUnloadCategory extends Model
{
    protected $fillable = [
        'intID',
        'strCategoryName',
        'ysnActive',
        'intCreatedBy',
        'dteCreatedAt'
    ];
    protected $table = "tblLighterUnloadCategory";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
