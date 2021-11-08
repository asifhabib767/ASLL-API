<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Modules\Asll\Entities\ShipConditionType;
use Modules\Asll\Entities\ShipEngine;
use Modules\Asll\Entities\ShipPosition;

class MasterRepository
{
    public function getShipConditionType()
    {

        try {
            $shipConditionType = ShipConditionType::select(
                'intID',
                'strShipConditionType'
            )

                ->get();
            return $shipConditionType;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * shipConditionStore new voyage to voyages
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function shipConditionStore(Request $request)
    {
        $intEmployeeId = 1;
        try {
            $shipConditionType = ShipConditionType::create([

                'strShipConditionType'=> $request->strShipConditionType,
                'intID'=>$request->intID,
            ]);
            return $shipConditionType;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function getShipEngine()
    {

        try {
            $shipEngine = ShipEngine::select(
                'intID',
                'strEngineName',
                'priority',
                'strEngineCode'
            )

                ->get();
            return $shipEngine;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * shipEngineStore new voyage to voyages
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function shipEngineStore(Request $request)
    {
        $intEmployeeId = 1;
        try {
            $shipEngine = ShipEngine::create([

                'strEngineName'=> $request->strEngineName,
                'priority'=> $request->priority,
                'strEngineCode' => $request->strEngineCode,
                'intID' => $request->intID,
            ]);
            return $shipEngine;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getShipPosition()
    {

        try {
            $shipPosition = ShipPosition::select(
                'intID',
                'strShipPositionName'
            )
                ->get();
            return $shipPosition;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * shipPositionStore new voyage to voyages
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function shipPositionStore(Request $request)
    {
        $intEmployeeId = 1;
        try {
            $cargo = ShipPosition::create([

                'strShipPositionName'=> $request->strShipPositionName,
                'intID'=> $request->intID,
            ]);
            return $cargo;
        } catch (\Exception $e) {
            return false;
        }
    }
}
