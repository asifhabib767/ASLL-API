<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllCRRreport extends Model
{

    protected $table = "tblCRReport";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';



}
