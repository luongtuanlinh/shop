<?php

namespace Modules\Core\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Modules\Core\Models\Shop\Cart;
use Modules\Core\Models\Shop\Order;
use Modules\Core\Models\Shop\Product;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use SoftDeletes, HasApiTokens, Authenticatable, CanResetPassword, Cacheable;

    protected $fillable = ["username", "token", 'admin', "email", "password","access_token", "province_id", "commune_id", "district_id", "phone"];
    protected $table = "users";
    // protected $cacheTime = 3600;

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    /**
     * The relationship
     */
    public function user_roles()
    {
        return $this->hasMany('Modules\Core\Models\UserRole', 'user_id');
    }
    public function roles()
    {
        return $this->hasManyThrough(
            'Modules\Core\Models\Role','Modules\Core\Models\UserRole',
            'user_id', 'id'
        );
    }
    public function user_groups()
    {
        return $this->hasMany('Modules\Core\Models\UserGroup', 'user_id');
    }
    public function groups()
    {
        return $this->hasManyThrough(
            'Modules\Core\Models\Group','Modules\Core\Models\UserGroup',
            'user_id', 'id'
        );
    }

    public function message()
    {
        return $this->hasOne('Modules\Notification\Entities\Message', 'receiver_id')->where('messages.user_id', Auth::user()->id)->orderBy('messages.id', 'DESC');
    }

    public function getListPermissions() {
        $roleIds = $this->user_roles->pluck("role_id")->toArray();

        $userPermissions = RolePermission::whereIn("role_id", $roleIds)->groupBy("permission_id")->pluck("permission_id")->toArray();
        //dd($userPermissions);
        return $userPermissions;
    }

    public function hasPermission($controller, $action) {
        $scorePermission = Permission::getRequestPermissionScore($controller, $action);
        //dd($scorePermission);
        //\Debugbar::info($scorePermission);
        if ($scorePermission != null) {
            $userPermissions = $this->getListPermissions();
            //\Debugbar::info($userPermissions);
            return in_array($scorePermission, $userPermissions);
        }
        // No need check permission
        return true;
    }

    public function saveListRoles($roles) {
        UserRole::where('user_id', $this->id)->delete();
        $newObjs = [];
        foreach($roles as $role) {
            $obj = [
                'user_id' => $this->id,
                'role_id' => (int) $role,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            array_push($newObjs, $obj);
        }
        UserRole::insert($newObjs);
    }

    public function saveListGroups($groups) {
        // Delete old records
        $this->user_groups()->delete();
        // Insert new records
        $newObjs = [];
        foreach($groups as $key => $value) {
            foreach ($value as $group){
                $obj = [];
                $obj["user_id"] = $this->id;
                $obj["group_id"] = $group;
                $obj["created_at"] = Carbon::now();
                $obj["updated_at"] = Carbon::now();
                array_push($newObjs, $obj);
            }
        }
        //dd($newObjs);
        UserGroup::insert($newObjs);
    }

    public function last_message(){
        return $this->hasOne('Modules\Notification\Entities\Message', 'conversation_id')->orderBy("id", "desc");
    }

    /**
     * Get user info from accesstoken
     * @param $access_token
     * @return mixed
     */
    public static function getUserInfoFromAccessToken($access_token){
        return self::where('access_token',$access_token)->select('id')->first();
    }

    /**
     * Get avatar url
     * @param $avatar
     * @return string
     */
    public static function getAvatarUrl($avatar){
        if(empty($avatar)){
            return "";
        }
        return env('APP_URL') . "/img/user/{$avatar}";
    }

    public function products()
    {
        return $this->hasMany(Product::class,'admin_id','id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function histories()
    {
        return $this->belongsToMany(Product::class,'user_histories','user_id','product_id')->withPivot(['price','updated_at']);
    }
}
