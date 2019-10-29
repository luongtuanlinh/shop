<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class Customer extends Model
{
    protected $fillable = ['customer_name', 'customer_phone', 'customer_address', 'province_id', 'district_id', 'commune_id'];
    protected $table = "customers";

    const COMPANY_STATUS = 1;
    const PERSON_STATUS = 2;

    public static function insertGetId($customer) {
        DB::beginTransaction();
        try {
            $customer_id = Customer::create($customer)->id;
            DB::commit();

            return $customer_id;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[Order] ' . $e->getMessage());
            return redirect()->route('order.create')->withErrors($e);
        }
    }
}
