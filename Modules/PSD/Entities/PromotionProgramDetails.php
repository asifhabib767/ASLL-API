<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class PromotionProgramDetails extends Model
{
    protected $fillable = [
        'intProgramMainId',
        'intParticipantId',
        'strParticipantName',
        'strAddress',
        'strMobileNumber',
        'intCreatedBy',
        'intUpdatedBy',
        'intDelatedBy',
        'created_at',
        'updated_at',
        'ysnActive',
    ];
    protected $table = "tblPSDProgramDetails";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
