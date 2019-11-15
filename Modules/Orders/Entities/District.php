<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ["id", "name", "province_id"];
    protected $table = "district";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commune(){
        return $this->hasMany('Modules\Agency\Entities\Commune', 'district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province_district(){
        return $this->belongsTo('Modules\Agency\Entities\Province', 'province_id');
    }
}
