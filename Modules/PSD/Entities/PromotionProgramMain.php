<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class PromotionProgramMain extends Model
{
    protected $fillable = [
        'intID',
        'intUnitId',
        'strProgramDate',
        'strProgramTypeName',
        'intProgramTypeId',
        'strProgramTypeId',
        'strVenueName',
        'dteCreatedAt',
        'intCreatedBy',
        'created_at',
        'updated_at',
        'ysnActive',
    ];
    protected $table = "tblPSDProgramMain";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';

    
    public function promotionDetails()
    {
        return $this->hasMany(PromotionProgramDetails::class, 'intProgramMainId');
    }
}
