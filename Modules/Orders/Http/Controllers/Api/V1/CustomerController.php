<?php

namespace Modules\Orders\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Orders\Entities\Customer;

class CustomerController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request){
        try {
            $query = Customer::query();
            $value = $request['mobile'];
            $query->whereRaw('LOWER(mobile) LIKE ? ', ['%'.trim(mb_strtolower($value)).'%']);
            $data = $query->get();
            return $this->successResponse(['customers' => $data], 'Response Successfully');
        } catch (\Exception $ex) {
            return $this->errorResponse([], $ex->getMessage());
        }

    }
}
