<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageActivityVlsf extends Model
{
    protected $table = "tblVoyageActivityVlsf";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    protected $fillable = [
        'intVoyageActivityID',
        'decBunkerVlsfoCon',
        'decBunkerVlsfoAdj',
        'decBunkerVlsfoRob',
        'decBunkerLsmgoCon',
        'decBunkerLsmgoAdj',
        'decBunkerLsmgoRob',
        'decLubMeccCon',
        'decLubMeccAdj',
        'decLubMeccRob',
        'decLubMecylCon',
        'decLubMecylAdj',
        'decLubMecylRob',
        'decLubAeccCon',
        'decLubAeccAdj',
        'decLubAeccRob',
        'strRemarks',
        'intCreatedBy',
        'intApprovedBy',
        'intUpdatedBy',
        'intDeletedBy',
    ];
}
