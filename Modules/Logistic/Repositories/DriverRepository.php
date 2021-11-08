<?php

namespace Modules\Logistic\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Logistic\Entities\Driver;

class DriverRepository
{

    /**
     * show Driver by id
     *
     * @param integer $id
     * @return object Driver object
     */
    public function getDriverList($intSupplierID = null)
    {
        try {
            $drivers = DB::table(config('constants.DB_Apps') . ".tblDriver")
                ->select(
                    'intDriverId',
                    'strPhoneNo',
                    'strDriverName',
                    'strDrivingLicence',
                    'strDriverImagePath',
                    'strLicenceImagePath',
                    'ysnAppRegistration',
                    'ysnActive',
                )
                ->where('ysnActive', 1);

            if (!is_null($intSupplierID)) {
                $drivers->where('intSupplierID', $intSupplierID);
            }
            $drivers = $drivers->get();
            return $drivers;
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
        if (!$request->intDriverId) {
            throw new \Exception('ID Not Found !');
        }

        try {
            DB::beginTransaction();
            DB::table(config('constants.DB_Apps') . ".tblDriver")
                ->where('intDriverId', $request->intDriverId)
                ->update(
                    [
                        'strPhoneNo' => $request->strPhoneNo,
                        'strDriverName' => $request->strDriverName,
                        'strDrivingLicence' => $request->strDrivingLicence,
                        'strLicenceImagePath' => $request->strLicenceImagePath,
                        'ysnAppregistration' => $request->ysnAppregistration,
                        'ysnActive' => $request->ysnActive,
                        'intSupplierID' => $request->intSupplierID,
                    ]
                );
            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
