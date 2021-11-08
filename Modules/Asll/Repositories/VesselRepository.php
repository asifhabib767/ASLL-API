<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Modules\Asll\Entities\Vessel;

class VesselRepository
{
    public function getVessels()
    {
        try {
            $query = Vessel::select(
                'intID',
                'strVesselName',
                'strIMONumber',
                'intVesselTypeID',
                'strVesselTypeName',
                'intYardCountryId',
                'strYardCountryName',
                'strVesselFlag',
                'numDeadWeight',
                'numGrossWeight',
                'numNetWeight',
                'strBuildYear',
                'strEngineName',
                'intTotalCrew',
                'intCreatedBy',
                'intUpdatedBy',
                'ysnOwn',
            )
                ->where('ysnActive', 1);
            if(request()->intVesselId){
                $query->where('intID', request()->intVesselId);
            }
            $vesels = $query->get();
            return $vesels;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new vessel to vessels
     *
     * @param Request $request
     * @return object vessel object which is created
     */
    public function store(Request $request)
    {
        // return $request->ysnOwn;
        if($request->ysnOwn){
            $ysnOwn=1;
        }else{
            $ysnOwn=0;
        }

        $intEmployeeId = 1;
        try {
            $vesel = Vessel::create([
                'strVesselName' => $request->strVesselName,
                'strIMONumber' => $request->strIMONumber,
                'intVesselTypeID' => $request->intVesselTypeID,
                'strVesselTypeName' => $request->strVesselTypeName,
                'intYardCountryId' => $request->intYardCountryId,
                'strYardCountryName' => $request->strYardCountryName,
                'strVesselFlag' => $request->strVesselFlag,
                'numDeadWeight' =>(float) $request->numDeadWeight,
                'numGrossWeight' => (float)$request->numGrossWeight,
                'numNetWeight' => (float)$request->numNetWeight,
                'strBuildYear' => $request->strBuildYear,
                'strEngineName' => $request->strEngineName,
                'intTotalCrew' => $request->intTotalCrew,
                'ysnOwn' => $ysnOwn,
                'intCreatedBy' => $intEmployeeId
            ]);
            return $vesel;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * update vessel by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated vessel object
     */
    public function update(Request $request, $id)
    {
        $intEmployeeId = 1;
        try {
            Vessel::where('intID', $id)
                ->update([
                    'strVesselName' => $request->strVesselName,
                    'strIMONumber' => $request->strIMONumber,
                    'intVesselTypeID' => $request->intVesselTypeID,
                    'strVesselTypeName' => $request->strVesselTypeName,
                    'intYardCountryId' => $request->intYardCountryId,
                    'strYardCountryName' => $request->strYardCountryName,
                    'strVesselFlag' => $request->strVesselFlag,
                    'numDeadWeight' => $request->numDeadWeight,
                    'numGrossWeight' => $request->numGrossWeight,
                    'numNetWeight' => $request->numNetWeight,
                    'strBuildYear' => $request->strBuildYear,
                    'strEngineName' => $request->strEngineName,
                    'intTotalCrew' => $request->intTotalCrew,
                    'intUpdatedBy' => $intEmployeeId,
                ]);
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * delete Vessel by id
     *
     * @param integer $id
     * @return object Deleted Vessel Object
     */
    public function delete($id)
    {
        try {
            $vessel = $this->show($id);
            $vessel->ysnActive = false;;
            $vessel->save();
            $vessel->delete();
            return $vessel;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * show vessel by id
     *
     * @param integer $id
     * @return object vessel object
     */
    public function show($id)
    {
        $id = (int) $id;
        try {
            $vesel = Vessel::findOrFail($id);
            return $vesel;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Vessel Not Found !');
        }
    }
}
