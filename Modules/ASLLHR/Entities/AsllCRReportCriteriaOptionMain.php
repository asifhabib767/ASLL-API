<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllCRReportCriteriaOptionMain extends Model
{
    protected $table = "tblCRReportCriteriaOptionMain";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    protected $fillable = [];

}
