<?php

namespace Modules\PSD\Entities;

use Illuminate\Database\Eloquent\Model;

class ComplaintSolvedType extends Model
{
    protected $fillable = [
        'intSolvedTypeId',
        'strSolvedTypeName',
        'intCreatedat',
        'ysnActive',
    ];
    protected $table = "tblPSDComplaintSolvedType";
    protected $connection = 'DB_PSD';
    protected $primaryKey = 'intID';
}
