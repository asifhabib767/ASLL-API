<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class LoadingPointType extends Model
{
    protected $fillable = [
        'intID',
        'intLoadingPointId',
        'strLoadingName',
        'ysnActive'
    ];
    protected $table = "tblLoadingPointType";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
