<?php

namespace Modules\Asll\Repositories;

use Illuminate\Http\Request;
use Modules\Asll\Entities\Voyage;
use Modules\Asll\Entities\VoyagePort;

class VoyagePortRepository
{
    public function getVoyagePorts()
    {
        try {
            $voyagePorts = VoyagePort::select(
                'intPortId',
                'strPortCode',
                'strPortName',
                'strCountryName',
                'strCountryCode',
                'strLOCODE',
            )
                ->where('isActive', "1")
                ->get();
            return $voyagePorts;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function getVoyagePortsBySearch($searchQuery)
    {
        try {
            $voyagePorts = VoyagePort::select(
                'intPortId',
                'strPortCode',
                'strPortName',
                'strCountryName',
                'strCountryCode',
                'strLOCODE',
            )
                ->where('strPortName', 'like', '%' . $searchQuery . '%')
                ->orWhere('strPortCode', 'like', '%' . $searchQuery . '%')
                ->orWhere('strCountryName', 'like', '%' . $searchQuery . '%')
                ->orWhere('strCountryCode', 'like', '%' . $searchQuery . '%')
                ->where('isActive', "1")
                ->get();
            return $voyagePorts;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * store new port
     *
     * @param Request $request
     * @return object port object which is created
     */
    public function store(Request $request)
    {
        try {
            $port = VoyagePort::create([
                'strPortCode' => $request->strPortCode,
                'strPortName' => $request->strPortName,
                'strCountryName' => $request->strCountryName,
                'strCountryCode' => $request->strCountryCode,
                'strLOCODE' => $request->strLOCODE,
                'isActive' => 1,
            ]);
            return $port;
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
        try {
            Voyage::where('intPortId', $id)
                ->update([
                    'strPortCode' => $request->strPortCode,
                    'strPortName' => $request->strPortName,
                    'strCountryName' => $request->strCountryName,
                    'strCountryCode' => $request->strCountryCode,
                    'strLOCODE' => $request->strLOCODE
                ]);
            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * delete VoyagePort by id
     *
     * @param integer $id
     * @return object Deleted VoyagePort Object
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
     * show port by id
     *
     * @param integer $id
     * @return object port object
     */
    public function show($id)
    {
        try {
            $vesel = VoyagePort::findOrFail($id);
            return $vesel;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Voyage Port Not Found !');
        }
    }
}
