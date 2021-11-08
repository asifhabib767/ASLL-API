<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllCRReportCriteriaMain extends Model
{
    protected $table = "tblCRReportCriteriaMain";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    protected $fillable = [];

   public function options()
{
    return $this->hasMany(AsllCRReportCriteriaOptionMain::class, 'intCriteriaMainId', 'intID')->select(['tblCRReportCriteriaOptionMain.intID','tblCRReportCriteriaOptionMain.intCriteriaMainId','tblCRReportCriteriaOptionMain.strName','tblCRReportCriteriaOptionMain.ysnChecked']);
}
}


