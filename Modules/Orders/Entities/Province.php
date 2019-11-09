<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ["id", "name"];
    protected $table = "provine";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function district(){
        return $this->hasMany('Modules\Agency\Entities\District', 'province_id');
    }
}
