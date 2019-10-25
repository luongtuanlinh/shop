<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [];
    protected $table = "customers";

    const COMPANY_STATUS = 1;
    const PERSON_STATUS = 2;
}
