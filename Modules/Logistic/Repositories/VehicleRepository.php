<?php

namespace Modules\Logistic\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Logistic\Entities\Driver;

class VehicleRepository
{

    /**
     * show Driver by id
     *
     * @param integer $id
     * @return object Driver object
     */
    public function getVehicleList($intSupplierID = null)
    {
        try {
            $vehicles = DB::table(config('constants.DB_Apps') . ".tblVehicle")
                ->join(config('constants.DB_Logistic') . ".tblVehicleType", 'tblVehicle.strCapacity', 'TblVehicleType.intTypeId')
                ->join(config('constants.DB_Asset') . ".tblVehicleArea", 'tblVehicle.strMetroCity', 'tblVehicleArea.strVehicleCity')
                ->join(config('constants.DB_Asset') . ".tblVehicleIndentityFicationNo", 'tblVehicle.strIdentifier', 'tblVehicleIndentityFicationNo.strIndentityNymber')
                ->join(config('constants.DB_Asset') . ".tblVehicleClassDigits", 'tblVehicle.strSerialNo', 'tblVehicleClassDigits.intVehicleClassNumber')
                ->join(config('constants.DB_Apps') . ".tblVehicleClass", 'tblVehicle.intVehicleClassId', 'tblVehicleClass.intvehicleClassid')
                ->where('tblVehicle.ysnEnable', 1);

            if (!is_null($intSupplierID)) {
                $vehicles->where('tblVehicle.intSupplierID', $intSupplierID);
            }
            $vehicles = $vehicles->select(
                'tblVehicle.intVehicleId',
                'tblVehicle.strFullregistrationNo',
                'tblVehicle.intVehicleClassId',
                'tblVehicleClass.strVechicleClassName',
                'tblVehicleClass.intvehicleClassid',
                'tblVehicleArea.intID as areaId',
                'tblVehicleArea.strVehicleCity',
                'tblVehicleIndentityFicationNo.intID as identityId',
                'tblVehicleIndentityFicationNo.strIndentityNymber',
                'tblVehicleClassDigits.intID as classDigitId',
                'tblVehicleClassDigits.intVehicleClassNumber',
                'tblVehicleType.intTypeId',
                'tblVehicleType.strType',
                'tblVehicle.strRegistrationNo',
                'tblVehicle.strOwnerName',
                'tblVehicle.strOwnerContact',
                'tblVehicle.intCapacityCFT',
                'tblVehicle.intFuelUsedType',
                'tblVehicle.intUnladenWeightKg',
                'tblVehicle.intMaxLadenWeightKg',
                'tblVehicle.intSupplierCOAID',
                'tblVehicle.intDriverID',
                'tblVehicle.intSupplierID',
                'tblVehicle.dteInsertDate',
            )->get();
            return $vehicles;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show Driver by id
     *
     * @param integer $id
     * @return object Driver object
     */
    public function show($intDriverId)
    {
        $intDriverId = (int) $intDriverId;
        try {
            $driver = Driver::findOrFail($intDriverId);
            return $driver;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Driver Not Found !');
        }
    }


    /**
     * update driver
     *
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        if (!$request->intVehicleId) {
            throw new \Exception('ID Not Found !');
        }

        try {
            DB::beginTransaction();
            DB::table(config('constants.DB_Apps') . ".tblVehicle")
                ->where('intVehicleId', $request->intVehicleId)
                ->update(
                    [
                        'strFullRegistrationNo' => $request->strFullRegistrationNo,
                        'intVehicleClassId' => $request->intVehicleClassId,
                        'strMetroCity' => $request->strMetroCity,
                        'strIdentifier' => $request->strIdentifier,
                        'strSerialNo' => $request->strSerialNo,
                        'strRegistrationNo' => $request->strRegistrationNo,
                        'strOwnerName' => $request->strOwnerName,
                        'strOwnerContact' => $request->strOwnerContact,
                        'intCapacityCFT' => $request->intCapacityCFT,
                        'intFuelUsedType' => $request->intFuelUsedType,
                        'intUnladenWeightKg' => $request->intUnladenWeightKg,
                        'intMaxLadenWeightKg' => $request->intMaxLadenWeightKg,
                        'strCapacity' => $request->strCapacity,
                        'ysnEnable' => $request->ysnEnable,
                        'intSupplierCOAID' => $request->intSupplierCOAID,
                        'dteInsertDate' => Carbon::now(),
                        'dteUpdateDate' => Carbon::now(),
                    ]
                );
            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show User vs Vehicle Info
     *
     * @param integer $id
     * @return object vehicle object
     */
    public function getUservsVehicleInfo($intResponsibleEnroll = null)
    {

        // return $intResponsibleEnroll;


        try {
            $vehicles = DB::table(config('constants.DB_AG_FuelLog') . ".tblAGVehicleInfoFuelLog as info")

                ->leftjoin(config('constants.DB_Asset') . ".tblAssetCheckINOut as ast", 'info.intAssetID', '=', 'ast.intAssetAutoID')

                ->where('ast.intResponsibleEnroll', $intResponsibleEnroll);

            if (!is_null($intResponsibleEnroll)) {
                $vehicles->where('ast.intResponsibleEnroll', $intResponsibleEnroll);
            }
            $vehicles = $vehicles->select(

                'intVehicleID',
                'strVehicleNo',
                'strDriverName',
                'intDriverEnroll',
            )->get();
            return $vehicles;
        } catch (\Exception $e) {
            return false;
        }
    }

/**
     * show User vs Vehicle Info
     *
     * @param integer $id
     * @return object vehicle object
     */
    public function getVehicleCapacity($intUnitId)
    {

        // return $intResponsibleEnroll;
// return 22;

        try {
            $vehicleType = DB::table(config('constants.DB_Logistic') . ".TblVehicleType")
             ->where('intUnitId',$intUnitId);


            $vehicleTypeL = $vehicleType->select(
               'intTypeId','strType'
            )
            ->orderBy('intSl')
            ->get();

            return $vehicleTypeL;
        } catch (\Exception $e) {
            return false;
        }
    }



}
