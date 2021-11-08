<?php

namespace Modules\Asll\Repositories;

use Modules\Asll\Entities\VesselType;

class VesselTypeRepository
{
    public function getVesselTypes()
    {
        try {
            $vesselTypes = VesselType::select('intID', 'strName')
                ->where('ysnActive', 1)
                ->get();
            return $vesselTypes;
        } catch (\Exception $e) {
            return false;
        }
    }
}
