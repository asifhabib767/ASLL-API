<?php

namespace Modules\VoyageLighter\Entities;

use Illuminate\Database\Eloquent\Model;

class VoyageLighterDetails extends Model
{
    protected $fillable = [
        'intID',
        'intVoyageLighterId',
        'intItemId',
        'strItemName',
        'intQuantity',
        'intVesselId',
        'strVesselName',
        'dteETAVessel',
        'intVoyageId',
        'intVoyageNo',
        'strLCNo',
        'intBoatNoteQty',
        'intSurveyNo',
        'intSurveyQty',
        'ysnActive',
        'strPartyName',
        'intPartyID',
        'decFreightRate',
    ];
    protected $table = "tblVoyageLighterDetails";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';
}
