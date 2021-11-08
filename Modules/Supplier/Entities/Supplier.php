<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = "suppliers";
    protected $connection = 'DB_iApps';
    protected $primaryKey = 'id';
    protected $fillable = [
        'business_id',
        'supplier_business_name',
        'bin',
        'name',
        'tax_number',
        'email',
        'city',
        'state',
        'country',
        'landmark',
        'mobile',
        'landline',
        'alternate_number',
        'pay_term_number',
        'pay_term_type',
        'created_by',
        'is_default'
    ];
}
