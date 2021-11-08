<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $fillable = [
        'intID',
        'intItemId',
        'strItemName',
        'ysnActive'
    ];
    protected $table = "tblItemType";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
