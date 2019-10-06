<?php

namespace Modules\Core\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Role extends Model
{
    use SoftDeletes, Cacheable;

    protected $fillable = ["name"];
    //protected $cacheTime = 3600;

    /**
     * The relationship
     */
    public function role_permissions()
    {
        return $this->hasMany('Modules\Core\Models\RolePermission', 'role_id');
    }

    public function saveListPermissions($permissions) {
        // Delete old records
        $this->role_permissions()->delete();
        // Insert new records
        $newObjs = [];
        foreach($permissions as $permission) {
            $obj = [
                'role_id' => $this->id,
                'permission_id' => $permission,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            array_push($newObjs, $obj);
        }
        RolePermission::insert($newObjs);
    }
}
