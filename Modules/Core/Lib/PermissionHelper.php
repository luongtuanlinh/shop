<?php

namespace Modules\Core\Lib;

use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Permission;

class PermissionHelper
{
    /**
     * @param $action
     * @param string $controller
     * @param null $guard
     * @return bool
     */
    public static function hasPermission($action = '', $controller = '', $guard = null)
    {
        // Get current controller
        $route = request()->route();
        $currentAction = $route->getActionName();
        list($currController, $currAction) = explode('@', $currentAction);

        if (empty($controller)) {
            $controller = $currController;
        }

        if (empty($action)) {
            $action = $currAction;
        }


        // Check permission for current user
        $scorePermission = Permission::getRequestPermissionScore($controller, $action);
        if ($scorePermission != null) {
            // Check by current user
            $user = Auth::user($guard);
            if ($user->id != 1) {
                // No permission access => redirect to home page
                $hasPermission = $user->hasPermission($controller, $action);
                if (!$hasPermission) {
                    return false;
                }
            }

        }

        //Role allow edit user -> allow reset password
        //Role not allow edit user => not allow reset password
        if(($controller=="Modules\Core\Http\Controllers\UserController")&&($action=="resetPassword")){
            $user = Auth::user($guard);
            $hasPermission = $user->hasPermission($controller, "edit");
            if ($hasPermission) {
                return true;
            }
            else return false;
        }

        //Role allow delete user -> allow restore user
        //Role not allow delete user => not allow restore user
        if(($controller=="Modules\Core\Http\Controllers\UserController")&&($action=="restore")){
            $user = Auth::user($guard);
            $hasPermission = $user->hasPermission($controller, "destroy");
            if ($hasPermission) {
                return true;
            }
            else return false;
        }

        //Role allow delete role -> allow restore role
        //Role not allow delete role => not allow restore role
        if(($controller=="Modules\Core\Http\Controllers\RoleController")&&($action=="restore")){
            $user = Auth::user($guard);
            $hasPermission = $user->hasPermission($controller, "destroy");
            if ($hasPermission) {
                return true;
            }
            else return false;
        }

        //Role allow delete group -> allow restore group
        //Role not allow delete group => not allow restore group
        if(($controller=="Modules\Core\Http\Controllers\GroupController")&&($action=="restore")){
            $user = Auth::user($guard);
            $hasPermission = $user->hasPermission($controller, "destroy");
            if ($hasPermission) {
                return true;
            }
            else return false;
        }



        return true;
    }

    /**
     * Check current user is administrator or not
     *
     * @return bool
     */
    public static function isAdmin()
    {
        $user = Auth::user();

        $userRoles = $user->user_roles;

        if ($userRoles) {
            foreach ($userRoles as $userRole) {
                if ($userRole->role->is_master == 1) {
                    return true;
                }
            }
        }

        return false;
    }
}