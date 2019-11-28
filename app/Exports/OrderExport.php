<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Orders\Entities\Orders;

class OrderExport implements FromView
{
    public function view(): View
    {
        $orders = Orders::select("orders.*", "customers.name as customer_name")
            ->join("customers", "customers.id", "orders.customer_id")
            ->get();
        return view('orders::order.excel', [
            'orders' => $orders
        ]);
    }
}
