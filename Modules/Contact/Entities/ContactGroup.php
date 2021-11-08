<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    protected $table = "tblContactGroup";
    protected $connection = 'DB_CRM';
    protected $primaryKey = 'intContactGroupId';

    protected $fillable = [
        'intContactGroupId',
        'strContactGroupName',
        'ysnActive'
    ];
}
