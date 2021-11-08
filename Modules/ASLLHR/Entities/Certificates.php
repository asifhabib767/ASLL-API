<?php

namespace Modules\ASLLHR\Entities;

use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    protected $table = "tblasllCertificatesLists";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
