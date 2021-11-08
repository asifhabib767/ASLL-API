<?php

namespace Modules\Retailer\Entities;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $fillable = [
        'intDisPointId',
        'intUnitId',
        'strName',
        'strAddress',
        'strContactPerson',
        'strContactNo',
        'intCustomerId',
        'intPriceCatagory',
        'intLogisticCatagory',
        'ysnEnable',
        'intFuelRouteID',
        'dteInsertionDate',
        'ysnLocationTag',
        'ysnImageTag',
        'decLatitude',
        'decLongitude',
        'intZAxis',
        'strGoogleMapName',
        'dteUpdateAt'
    ];
    protected $table = "tblDisPoint";
    protected $connection = 'ERP_SAD';
    protected $primaryKey = 'intDisPointId';

    const CREATED_AT = 'dteInsertionDate';
    const UPDATED_AT = 'dteUpdateAt';
}
