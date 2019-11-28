
<table class="table table-condensed table-hover">
    <thead>
    <tr>
        <th>Mã hoá đơn</th>
        <th>Thanh toán</th>
        <th>Trạng thái thanh toán</th>
        <th>Trạng thái đơn hàng</th>
        <th>Tổng tiền</th>
        <th>Tiền ship</th>
        <th>Tổng tiền sau ship</th>
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
            <td>{{ $order->payment }}</td>
            <td>{{ ($order->payment_status) ? "Đã thanh toán" : "Chưa thanh toán" }}</td>
            <td>{{ \Modules\Orders\Entities\Orders::listStatus()[$order->status] }}</td>
            <td>{{ number_format($order->total_price) }}</td>
            <td>{{ number_format($order->ship_price) }}</td>
            <td>{{ number_format($order->total_price + $order->ship_price) }}</td>
            <td>{{ $order->deliver_time }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->customer_phone }}</td>
            <td>{{ $order->deliver_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


