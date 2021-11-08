<?php

namespace Modules\Role\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends RolesRepository
{
    public function checkHasPermission($permissionName)
    {
        try {
            return request()->user()->hasPermissionTo($permissionName);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function givePermission($permissionName, $user_id)
    {
        try {
            // Check if user has permission to assign permission
            if ($this->checkHasPermission('assign_permission')) {
                $user = User::find($user_id);
                if (!is_null($user)) {
                    $user->givePermissionTo($permissionName);
                    return true;
                }
                return false;
            }
            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
