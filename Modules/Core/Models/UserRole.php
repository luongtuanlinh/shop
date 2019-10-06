<?php

namespace Modules\Core\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $fillable = ["user_id", "role_id"];
    protected $table = "role_users";

    /**
     * The relationship
     */
    public function role()
    {
        return $this->belongsTo('Modules\Core\Models\Role', 'role_id');
    }
    public function user()
    {
        return $this->belongsTo('Modules\Core\Models\User', 'user_id');
    }
}
