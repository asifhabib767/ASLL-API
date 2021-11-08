<?php

namespace Modules\HR\Repositories;

use Illuminate\Http\Request;
use App\Interfaces\BasicCrudInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CheckpointRepository
{
    public function createCheckpoint($request)
    {
        $createdID = DB::table(config('constants.DB_Apps') . ".tblGuardCheckPointList")->insertGetId(
            [
                'strCheckPointName' => $request->strCheckPointName,
                'intFloorID' => $request->intFloorID,
                'intJobStationID' => $request->intJobStationID,
                'intUnitID' => $request->intUnitID,
                'ysnActive' => true,
                'intInsertedBy' => $request->intInsertedBy,
                'intUpdatedBy' => $request->intUpdatedBy,
                'dteInsertedDate' => Carbon::now(),
                'dteUpdatedDate' => Carbon::now(),
                'decLatitude' => $request->decLatitude,
                'decLongitude' => $request->decLongitude,
                'intZAxis' => $request->intZAxis,
                'strSideName' => $request->strSideName,
            ]
        );
        return $this->findGuardById($createdID);
    }

    public function findGuardById($id)
    {
        $query = DB::table(config('constants.DB_Apps') . ".tblGuardCheckPointList");

        $output = $query->select(
            [
                '*'
            ]
        )
            ->where('intID', $id)
            ->first();

        return $output;
    }

    public function checkpoints($intUnitID, $intJobStationID, $intFloorID)
    {
        $query = DB::table(config('constants.DB_Apps') . ".tblGuardCheckPointList");

        $output = $query->select(
            [
                '*'
            ]
        )
            ->where('intUnitID', $intUnitID)
            ->where('intJobStationID', $intJobStationID)
            ->where('intFloorID', $intFloorID)
            ->get();

        return $output;
    }

    public function updateQrCode($request)
    {
        $createdID = DB::table(config('constants.DB_Apps') . ".tblGuardCheckPointList")
            ->where('intID', $request->intID)
            ->update(
                [
                    'strQRCode' => $request->strQRCode
                ]
            );
        return $createdID;
    }

    public function qrcodes($intUnitID, $intJobStationID)
    {
        $query = DB::table(config('constants.DB_Apps') . ".tblGuardCheckPointList");

        $output = $query->select(
            [
                '*'
            ]
        )
            ->where('intUnitID', $intUnitID)
            ->where('intJobStationID', $intJobStationID)
            ->get();

        return $output;
    }
}
