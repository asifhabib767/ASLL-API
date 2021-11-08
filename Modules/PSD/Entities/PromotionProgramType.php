<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class PromotionProgramType extends Model
{
    protected $fillable = [
        'strProgramTypeName',
        'intProgramTypeId',
        'dteCreatedAt',
        'ysnActive',
    ];
    protected $table = "tblPSDProgramType";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intProgramTypeId';
}
