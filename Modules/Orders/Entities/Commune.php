<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $fillable = ["id", "name", "district_id"];
    protected $table = "commune";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(){
        return $this->belongsTo('Modules\Agency\Entities\District', 'district_id');
    }
}
