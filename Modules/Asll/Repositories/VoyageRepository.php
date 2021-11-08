<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Modules\Asll\Entities\Voyage;

class VoyageRepository
{
    public function getVoyages()
    {
        try {
            $query = Voyage::select(
                'intID',
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
                'intVlsfoRob',
                'intLsmgRob',
                'intLubOilRob',
                'intMeccRob',
                'intAeccRob',
                'created_at',
                'updated_at',
            )
                ->where('ysnActive', 1)
                ->orderBy('intID', 'desc');
            $search = request()->search;
            $type = request()->cargoType;
            $vessel = request()->vessel;

            if($search){
                $query->where('intVoyageNo', (int) $search)
                        ->orWhere('strVesselName', 'like', '%'. $search.'%')
                        ->orWhere('strFromPortName', 'like', '%'. $search.'%')
                        ->orWhere('strToPortName', 'like', '%'. $search.'%')
                        ->orWhere('strPlaceOfVoyageCommencement', 'like', '%'. $search.'%');
            }

            if($type){
                $query->where('intCargoTypeID', $type);
            }

            if($vessel){
                $query->where('intVesselID', (int) $vessel);
            }

            $voyages = $query->get();
            return $voyages;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getVoyageByLastVesselId($request)
    {
        try {
            $voyageActivity = Voyage::where('intVesselID', $request->intVesselId)->orderBy('intID', 'desc')->first();
            return $voyageActivity;
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
            $voyage = Voyage::create([
                'strVesselName' => $request->strVesselName,
                'intVesselID' => $request->intVesselID,
                'intVoyageNo' => $request->intVoyageNo,
                'intCargoTypeID' => $request->intCargoTypeID,
                'strCargoTypeName' => $request->strCargoTypeName,
                'intCargoQty' => $request->intCargoQty,
                'dteVoyageDate' => $request->dteVoyageDate,
                'strPlaceOfVoyageCommencement' => $request->strPlaceOfVoyageCommencement,
                'decBunkerQty' => $request->decBunkerQty,
                'decDistance' => $request->decDistance,
                'intFromPortID' => $request->intFromPortID,
                'strFromPortName' => $request->strFromPortName,
                'intToPortID' => $request->intToPortID,
                'strToPortName' => $request->strToPortName,
                'intCreatedBy' =>  $request->intEmployeeId ? $request->intEmployeeId : null,
                'intVlsfoRob' => $request->intVlsfoRob,
                'intLsmgRob' => $request->intLsmgRob,
                'intLubOilRob' => $request->intLubOilRob,
                'intMeccRob' => $request->intMeccRob,
                'intAeccRob' => $request->intAeccRob,
                'intUnitId' => $request->intUnitId ? $request->intUnitId : 17,
                'ysnActive' => 1,
                'synced' => 0
            ]);
            return $voyage;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * update voyage by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated voyage object
     */
    public function update(Request $request, $id)
    {
        $intEmployeeId = 1;
        try {
            Voyage::where('intID', $id)
                ->update([
                    'strVesselName' => $request->strVesselName,
                    'intVesselID' => $request->intVesselID,
                    'intVoyageNo' => $request->intVoyageNo,
                    'intCargoTypeID' => $request->intCargoTypeID,
                    'strCargoTypeName' => $request->strCargoTypeName,
                    'intCargoQty' => $request->intCargoQty,
                    'dteVoyageDate' => $request->dteVoyageDate,
                    'strPlaceOfVoyageCommencement' => $request->strPlaceOfVoyageCommencement,
                    'decBunkerQty' => $request->decBunkerQty,
                    'decDistance' => $request->decDistance,
                    'intFromPortID' => $request->intFromPortID,
                    'strFromPortName' => $request->strFromPortName,
                    'intToPortID' => $request->intToPortID,
                    'strToPortName' => $request->strToPortName,
                    'intUpdatedBy' => $request->intEmployeeId ? $request->intEmployeeId : null,
                    'intVlsfoRob' => $request->intVlsfoRob,
                    'intLsmgRob' => $request->intLsmgRob,
                    'intLubOilRob' => $request->intLubOilRob,
                    'intMeccRob' => $request->intMeccRob,
                    'intAeccRob' => $request->intAeccRob,
                    'synced' => 0
                ]);
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * delete Voyage by id
     *
     * @param integer $id
     * @return object Deleted Voyage Object
     */
    public function delete($id)
    {
        try {
            $voyage = $this->show($id);
            $voyage->delete();
            return $voyage;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * show voyage by id
     *
     * @param integer $id
     * @return object voyage object
     */
    public function show($id)
    {
        try {
            $voyage = Voyage::findOrFail($id);
            return $voyage;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Voyage Not Found !');
        }
    }
}
