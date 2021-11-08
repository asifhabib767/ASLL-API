<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "tblContact";
    protected $connection = 'DB_CRM';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intGroupId',
        'strGroupName',
        'strCustomerName',
        'strOrganizationName',
        'strDesignation',
        'strContactNo',
        'strEmail',
        'image',
        'intCreatedBy',
        'intCreatedAtUserTypeId',
        'intUpdatedBy',
        'intUpdatedAtUserTypeId',
        'ysnActive',
        'intDeletedBy',
        'intDeletedAtUserTypeId',
    ];
    use SoftDeletes;
}
