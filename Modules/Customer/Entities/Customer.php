<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = "customers";
    protected $connection = 'DB_iApps';
    protected $primaryKey = 'id';
    protected $fillable = [
        'business_id',
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
