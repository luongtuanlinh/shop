<?php

namespace Modules\Core\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use Cacheable;
    protected $fillable = ["role_id", "permission_id"];
    protected $table = "permission_roles";
    //protected $cacheTime = 3600;

    /**
     * The relationship
     */
    public function role()
    {
        return $this->belongsTo('Modules\Core\Models\Role', 'role_id');
    }

    /**
     * @param $permissionIds
     * @return \Illuminate\Support\Collection
     */
    public static function getRoleasPermiHasPermissions($permissionIds)
    {
        return self::whereIn('permission_id', $permissionIds)->select('role_id')->get()->pluck('role_id')->toArray();
    }
}
