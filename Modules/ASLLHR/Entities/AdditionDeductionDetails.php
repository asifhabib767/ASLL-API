<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class AdditionDeductionDetails extends Model
{
    protected $table = "tblAdditionDeductionDetails";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
