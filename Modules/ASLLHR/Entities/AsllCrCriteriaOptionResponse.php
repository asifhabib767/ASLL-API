<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AsllCrCriteriaOptionResponse extends Model
{

    protected $table = "tblCRCriteriaOptionResponse";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    protected $fillable = [];
}
