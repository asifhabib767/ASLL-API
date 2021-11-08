<?php

namespace Modules\Role\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;

class RolesRepository
{

    public function getModulePermissionByUserTypeID($intUserTypeID)
    {
        $query = DB::table(config('constants.DB_Apps') . ".tblAppsModule as tam")
            ->leftJoin(config('constants.DB_Apps') . ".tblAppsPermission as tap", 'tam.intModuleID', '=', 'tap.intAppsModuleID');

        $output = $query->select(
            [
                'tam.intModuleID',
                'tam.strModuleName',
                'tam.strModuleNameBn',
                'tam.strModuleShortName',
                'tam.strModuleName',
            ]
        )
            ->where('tam.ysnActive', true)
            ->where('tap.intUserTypeID', $intUserTypeID)
            ->get();

        return $output;
    }

    public function getModulePermissionByUser($intUserID, $intUserTypeID)
    {
        $userType = DB::table(config('constants.DB_Apps') . ".tblAppsUserType")->select('ysnOwn')->where('intId', $intUserTypeID)->first();
        $queryDefaultPermission = [];
        if ($userType->ysnOwn) {
            $queryDefaultPermission = DB::table(config('constants.DB_Apps') . ".tblAppsModule as tam")
                ->select(
                    'tam.intModuleID',
                    'tam.strModuleName',
                    'tam.strModuleNameBn',
                    'tam.strModuleShortName',
                    'tam.strOfflineImage',
                    'tam.strAppMenuLink',
                    'tam.ysnVisibleDashboard',
                    'tam.intModuleDefaultPriority',
                    'tam.intParentModuleID',
                )
                ->where('ysnDefault', 1)
                ->get();
        }
        $queryPermission = DB::table(config('constants.DB_Apps') . ".tblAppsModule as tam")
            ->join(config('constants.DB_Apps') . ".tblAppsPermission as tap", 'tam.intModuleID', '=', 'tap.intAppsModuleID');
        $queryPermissionData = $queryPermission->select(
            'tam.intModuleID',
            'tam.strModuleName',
            'tam.strModuleNameBn',
            'tam.strModuleShortName',
            'tam.strOfflineImage',
            'tam.strAppMenuLink',
            'tam.intModuleDefaultPriority',
            'tap.ysnVisibleDashboard',
            'tam.intParentModuleID',
        )
            ->where('tam.ysnActive', true)
            ->where('tap.intUserID', $intUserID)
            ->where('tap.intUserTypeID', $intUserTypeID)
            ->get();

        $output = $queryPermissionData;
        if (count($queryDefaultPermission) > 0) {
            $output = $queryDefaultPermission->merge($queryPermissionData);
        }

        $array = [];
        foreach ($output as $item) {
            $item->intModuleID = (int) $item->intModuleID;
            $array[] = $item;
        }
        $uniqueArray = collect($array)->unique();
        $final = [];
        foreach ($uniqueArray as $key => $value) {
            $final[] = $uniqueArray[$key];
        }
        return $final;
    }

    public function getModuleList($intUserTypeID)
    {
        $queryPermission = DB::table(config('constants.DB_Apps') . ".tblAppsModule as tam");
        $queryPermissionData = $queryPermission->select(
            'tam.intModuleID',
            'tam.strModuleName',
            'tam.strModuleNameBn',
        )->get();

        $output = $queryPermissionData;
        return $output;
    }

    public function getUserTypeList($request)
    {
        $userType = DB::table(config('constants.DB_Apps') . ".tblAppsUserType as tap");
        $userTypeData = $userType->select(
            'tap.IntId',
            'tap.strUserType',
        )->get();

        $output = $userTypeData;
        return $output;
    }

    /**
     * store new AppsPermission to AppsPermission
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function appPermissionStore(Request $request)
    {
        $checkPermission = DB::table(config('constants.DB_Apps') . ".tblAppsPermission")
            ->select('*')
            ->where('intUserID', $request->intUserID)
            ->first();
        try {
            if (is_null($checkPermission)) {
                DB::beginTransaction();
                $appsPermission = DB::table(config('constants.DB_Apps') . ".tblAppsPermission")
                    ->where('intUserID', $request->intUserID)
                    ->insertGetId(
                        [
                            'intAppsModuleID' => $request->intAppsModuleID,
                            'intUserTypeID' => $request->intUserTypeID,
                            'intUserID' => $request->intUserID,
                            'intInsertedBy' => $request->intInsertedBy,
                            // 'ysnActive'=>$request->ysnActive,
                            // 'dteInsertDate'=> Carbon::now()
                        ]
                    );
                DB::commit();
                return $appsPermission;
            } else {
                return "Already Exist";
            }
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * store new AppsPermission to AppsPermission
     *
     * @param Request $request
     * @return object voyage object which is created
     */
    public function multipleAppPermissionStore(Request $request)
    {
        try {
            // Delete all permissions from permission table
            if (count($request->permissions) > 0) {
                DB::table(config('constants.DB_Apps') . ".tblAppsPermission")
                    ->where('intUserID', $request->permissions[0]['intUserID'])
                    ->where('intUserTypeID', $request->permissions[0]['intUserTypeID'])
                    ->delete();

                foreach ($request->permissions as $permission) {
                    DB::table(config('constants.DB_Apps') . ".tblAppsPermission")
                        ->insertGetId(
                            [
                                'intAppsModuleID' => $permission['intAppsModuleID'],
                                'intUserTypeID' => $permission['intUserTypeID'],
                                'intUserID' => $permission['intUserID'],
                                'intInsertedBy' => $permission['intInsertedBy'],
                            ]
                        );
                }
                return 'Updated';
            } else {
                return "Error";
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
