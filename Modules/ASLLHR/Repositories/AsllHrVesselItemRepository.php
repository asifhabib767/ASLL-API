<?php

namespace Modules\ASLLHR\Repositories;

use Illuminate\Support\Str;
use App\Interfaces\CrudInterface;
use Modules\ASLLHR\Entities\VesselItem;
use Illuminate\Support\Facades\Auth;

class AsllHrVesselItemRepository implements CrudInterface{

    /**
     * Get All Vessel Items
     *
     * @return collections Array of Vessel Item Collection
     */
    public function getAll(){
        $query = VesselItem::orderBy('intID', 'desc');
        if(request()->intVesselId){
            $query->where('intVesselId',request()->intVesselId);
        }
        return $query->get();
    }
    /**
     * Get Paginated Vessel Item Data
     *
     * @param int $pageNo
     * @return collections Array of Vessel Item Collection
     */
    public function getPaginatedData($perPage){
        $perPage = isset($perPage) ? $perPage : 12;
        return VesselItem::orderBy('intID', 'desc')->get();
        // ->paginate($perPage);
    }

    /**
     * Create New Vessel Item
     *
     * @param array $data
     * @return object Vessel Item Object
     */
    public function create(array $data){
        return VesselItem::create($data);
    }

    /**
     * Delete Vessel Item
     *
     * @param int $intID
     * @return boolean true if deleted otherwise false
     */
    public function delete($intID){
        $vesselItem = VesselItem::find($intID);
        if (is_null($vesselItem)){
            return false;
        }
        $vesselItem->delete($vesselItem);
        return true;
    }

    /**
     * Get Vessel Item Detail By intID
     *
     * @param int $intID
     * @return void
     */
    public function getByID($intID){
        return VesselItem::find($intID);
    }

    /**
     * Update Vessel Item By intID
     *
     * @param int $intID
     * @param array $data
     * @return object Updated Vessel Item Object
     */
    public function update($intID, array $data){
        $vesselItem = VesselItem::find($intID);
        if (is_null($vesselItem)){
            return null;
        }

        $vesselItem->update($data);
        return $this->getByID($vesselItem->intID);
    }
}
