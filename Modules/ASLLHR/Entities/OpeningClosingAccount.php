<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class OpeningClosingAccount extends Model
{

    protected $table = "tblOpeningClosingAccount";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
    protected $fillable = [];
}
