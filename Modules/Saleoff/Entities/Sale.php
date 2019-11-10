<?php

namespace Modules\Saleoff\Entities;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ["start_time", "end_time", "event_name", "introduction", "cover_img"];
    protected $table = "sales";
}
