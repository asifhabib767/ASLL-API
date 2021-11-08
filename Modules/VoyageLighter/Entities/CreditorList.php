<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class CreditorList extends Model
{
    protected $fillable = [
        'intID',

        'strItemName',
        'strChartOfAccountCode',
        'ysnActive'
    ];
    protected $table = "tblCreditorList";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
