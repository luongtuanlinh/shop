
<table class="table table-condensed table-hover">
    <thead>
    <tr>
        <th>Mã hoá đơn</th>
        <th>Người tạo</th>
        <th>Cấp</th>
        <th>Trạng thái đơn hàng</th>
        <th>Tổng tiền</th>
        <th>Chiết khấu</th>
        <th>Chiết khấu thanh toán</th>
        <th>Tổng tiền sau chiết khấu</th>
        <th>Thời gian giao hàng</th>
        <th>Tên khách hàng</th>
        <th>Số điện thoại</th>
        <th>Địa chỉ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->creater }}</td>
            <td>{{ ($order->user_level == 0) ? "Cấp công ty" : "Đại lý cấp".$order->user_level }}</td>
            <td>{{ \Modules\Orders\Entities\Orders::listStatus()[$order->status] }}</td>
            <td>{{ number_format($order->total) }}</td>
            @php
                $tax = (isset($order->tax)) ? $order->tax : 0;
                $discount = (isset($order->discount)) ? $order->discount : 0
            @endphp
            <td>{{ $discount }}</td>
            <td>{{ $tax }}</td>
            <td>{{ number_format($order->total * (100 - $tax) * (100 - $discount) / 10000) }}</td>
            <td>{{ $order->deliver_time }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->customer_phone }}</td>
            <td>{{ $order->deliver_address }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


