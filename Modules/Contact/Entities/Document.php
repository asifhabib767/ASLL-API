<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'strFileName',
        'strFilePublicURL',
        'intCreatedBy',
        'intCreatedUserTypeId',
        'ysnActive'
    ];
    
    protected $table = "tblDocument";
    protected $connection = 'DB_CRM';
    protected $primaryKey = 'intDocumentId';
}
