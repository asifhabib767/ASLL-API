<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Modules\Asll\Entities\CargoType;

class CargoRepository
{
    public function getCargo()
    {

        try {
            $cargos = CargoType::select(
                'intID',
                'strCargoTypeName'
            )
                ->where('ysnActive', 1)
                ->get();
            return $cargos;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new voyage to voyages
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function store(Request $request)
    {
        $intEmployeeId = 1;
        try {
            $cargo = CargoType::create([

                'intUnitId' => $request->intUnitId,
                'strCargoTypeName' => $request->strCargoTypeName,
                'ysnActive' => $request->ysnActive,
            ]);
            return $cargo;
        } catch (\Exception $e) {
            return false;
        }
    }
}
