<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class ComplaintProblemType extends Model
{
    protected $fillable = [
        'intProblemTypeId',
        'strProblemTypeName',
        'intCreatedat',
        'ysnActive',
    ];
    protected $table = "tblPSDComplaintProblemType";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
