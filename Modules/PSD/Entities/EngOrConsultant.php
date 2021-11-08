<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class EngOrConsultant extends Model
{
    protected $fillable = [
        'intID',
        'intUnitId',
        'strActivityDate',
        'intEngConsultantId',
        'strEngConsultantName',
        'strAddress',
        'strMobileNumber',
        'strEmail',
        'strFarmInstOfficeName',
        'intOngoingProject',
        'intCoordinatedProject',
        'dteCreatedAt',
        'created_at',
        'updated_at',
        'intCreatedBy',
        'ysnActive',
    ];
    protected $table = "tblEngineerVisit";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
