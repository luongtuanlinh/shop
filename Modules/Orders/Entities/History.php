<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ["id", "order_id", "user_id", "user_name", "description", "actor_id"];
    protected $table = "orderHistory";
}
