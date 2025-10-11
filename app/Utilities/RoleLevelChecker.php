<?php
namespace App\Utilities;

use App\Models\User;

class RoleLevelChecker
{
    private static $roleLevels = [
        'super_admin' => 0,
        'admin' => 1,
        'user' => 2,
    ];

    /**
     * Checks if the user's role level is less than or equal to the given role level.
     *
     * This function is useful for checking if a user has sufficient privileges to perform an action.
     *
     * @param User $user The user to check.
     * @param int $roleLevel The minimum role level required to perform the action.
     * @return bool True if the user's role level is less than or equal to the given role level, false otherwise.
     */
    public static function checkMinimumByRoleLevel(User $user, int $roleLevel) {
        return RoleLevelChecker::$roleLevels[$user->role] <= $roleLevel;
    }

    /**
     * Checks if the user's role level is less than or equal to the given role level by the role name.
     *
     * This function is useful for checking if a user has sufficient privileges to perform an action,
     * given the role name of the required level.
     *
     * @param User $user The user to check.
     * @param string $roleName The name of the role to check against.
     * @return bool True if the user's role level is less than or equal to the given role level, false otherwise.
     */
    public static function checkMinimumByRoleName(User $user, string $roleName) {
        return RoleLevelChecker::$roleLevels[$user->role] <= RoleLevelChecker::getRoleLevel($roleName);
    }

    /**
     * Returns the role level associated with the given role name.
     *
     * If the role name is not found in the $roleLevels array, this function returns 1000.
     *
     * @param string $role The role name to retrieve the role level from.
     * @return int The role level associated with the given role name, or 1000 if the role name is not found.
     */
    public static function getRoleLevel(string $role) {
        return RoleLevelChecker::$roleLevels[$role] ?? 1000;
    }
}