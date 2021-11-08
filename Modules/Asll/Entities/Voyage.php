<?php

namespace Modules\Asll\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voyage extends Model
{
    protected $fillable = [
        'intUnitId',
        'strVesselName',
        'intVesselID',
        'intVoyageNo',
        'intCargoTypeID',
        'strCargoTypeName',
        'intCargoQty',
        'dteVoyageDate',
        'strPlaceOfVoyageCommencement',
        'decBunkerQty',
        'decDistance',
        'intFromPortID',
        'strFromPortName',
        'intToPortID',
        'strToPortName',
        'intCreatedBy',
        'intUpdatedBy',
        'intDeletedBy',
        'intVlsfoRob',
        'intLsmgRob',
        'intLubOilRob',
        'intMeccRob',
        'intAeccRob',
        'ysnActive'
    ];

    protected $table = "tblVoyage";
    protected $connection = 'DB_ASLL';
    protected $primaryKey = 'intID';

    use SoftDeletes;

    public function voyageActivities()
    {
        return $this->hasMany(VoyageActivity::class, 'intVoyageID', 'intID');
    }
}
