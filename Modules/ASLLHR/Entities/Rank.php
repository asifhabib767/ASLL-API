<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $table = "tblRank";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
