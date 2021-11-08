<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = [
        'intID',
        'intUnitId',
        'strActivityDate',
        'strOwnerName',
        'strAddress',
        'strMobileNumber',
        'strConstructionTypeName',
        'intConstructionTypeId',
        'intActivityTypeId',
        'strActivityTypeName',
        'intFeedbackTypeId',
        'strFeedbackTypeName',
        'decStepsRecomended',
        'decApproxConsumption',
        'strNextFollowUpdate',
        'dteCreatedAt',
        'intCreatedBy',
        'created_at',
        'updated_at',
        'ysnActive',
    ];
    protected $table = "tblSiteVisit";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
